<?php

namespace App\Services\V1\Kyc;
use App\Actions\UploadImageAction;
use App\Enums\Kyc\KycFileStatusEnum;
use App\Enums\Kyc\KycVerificationStatusEnum;
use App\Models\Kyc\KycFile;
use App\Models\Kyc\KycVerification;
use App\Services\BaseService;
use App\Utility\Responser;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class KycFileService extends BaseService
{

  /**
   * Initialize kyc verification
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function upload(Request $request): JsonResponse
  {
    try {
      $user_id = auth()->id();
      $kyc_verification_id = $request->kyc_verification_id;
      $file_side = $request->file_side;

      $kyc_file = KycFile::where([
        'user_id' => $user_id,
        'kyc_verification_id' => $kyc_verification_id,
        'file_side' => $file_side,
      ])->first();

      if($kyc_file) {
        return $this->change((int)$kyc_file->id, $request);
      }

      $file = $request->file('kyc_file');
      $uploaded = UploadImageAction::handle($file);
      $uploaded_file = $uploaded['url'] ?? null;

      if(empty($uploaded_file)) {
        return Responser::send(JsonResponse::HTTP_BAD_REQUEST, [], 'File upload failed. Try again.');
      }

      $kyc_verification = KycVerification::find($kyc_verification_id);
      $document_name = $kyc_verification->documentType ? optional($kyc_verification->documentType)->name : '';

      $kyc_file = KycFile::create([
        'description' => "The $document_name $file_side side.",
        'file_side' => $file_side,
        'uploaded_file' => $uploaded_file,
        'status' => KycFileStatusEnum::PENDING->value,
        'user_id' => $user_id,
        'kyc_verification_id' => $kyc_verification_id,
        'extras' => ['filename' => $uploaded['filename'] ?? '']
      ]);

      return Responser::send(JsonResponse::HTTP_OK, $kyc_file, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
    }
  }

  public function list()
  {
    try {
      $kyc_files = KycFile::where(['user_id' => auth()->id()])->get();
      return Responser::send(JsonResponse::HTTP_OK, $kyc_files, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
    }
  }

  /**
   * Change kyc file
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function change(int $id, Request $request): JsonResponse
  {
    try {
      $kyc_file = KycFile::where(['id' => $id, 'user_id' => auth()->id()])->first();
      if(strtolower($kyc_file->status) === strtolower(KycFileStatusEnum::ACCEPTED->value)) {
        return Responser::send(JsonResponse::HTTP_BAD_REQUEST, [], 'Operation not allowed. Uploaded file is already accepted.');
      }

      $file = $request->file('kyc_file');
      $previous_file = optional($kyc_file->extras)->filename;
      $uploaded = UploadImageAction::handle($file, $previous_file);
      $uploaded_file = $uploaded['url'] ?? null;

      if(empty($uploaded_file)) {
        return Responser::send(JsonResponse::HTTP_BAD_REQUEST, [], 'File upload failed. Try again.');
      }

      $kyc_file->uploaded_file = $uploaded_file;
      $kyc_file->status = KycFileStatusEnum::PENDING->value;
      $kyc_file->extras = ['filename' => $uploaded['filename'] ?? ''];
      $kyc_file->update();
      return Responser::send(JsonResponse::HTTP_OK, $kyc_file, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
    }
  }

  /**
   * Delete kyc file
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function delete(int $id): JsonResponse
  {
    try {
      $kyc_file = KycFile::where(['id' => $id, 'user_id' => auth()->id()])->first();
      if(empty($kyc_file)) {
        return Responser::send(JsonResponse::HTTP_NOT_FOUND, [], 'Record not found. Try again.');
      }

      if(strtolower($kyc_file->status) === strtolower(KycFileStatusEnum::ACCEPTED->value)) {
        return Responser::send(JsonResponse::HTTP_BAD_REQUEST, [], 'Operation not allowed. Accepted file cannot be deleted.');
      }

      $extras = optional($kyc_file->extras);
      UploadImageAction::delete($extras->filename);
      $kyc_file->delete();
      return Responser::send(JsonResponse::HTTP_OK, [], 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
    }
  }

}
