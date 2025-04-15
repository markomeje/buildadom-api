<?php

namespace App\Services\V1\Kyc;
use App\Enums\Kyc\KycFileStatusEnum;
use App\Models\Kyc\KycFile;
use App\Models\Kyc\KycVerification;
use App\Services\BaseService;
use App\Traits\FileUploadTrait;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KycFileService extends BaseService
{
    use FileUploadTrait;

    /**
     * Initialize kyc verification
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

            if ($kyc_file) {
                return $this->change((int) $kyc_file->id, $request);
            }

            $uploaded_file = $this->uploadToS3($request->file('kyc_file'));
            $kyc_verification = KycVerification::find($kyc_verification_id);
            $document_name = $kyc_verification->documentType ? optional($kyc_verification->documentType)->name : '';

            $kyc_file = KycFile::create([
                'description' => "The {$document_name} {$file_side} side.",
                'file_side' => $file_side,
                'uploaded_file' => $uploaded_file,
                'status' => KycFileStatusEnum::PENDING->value,
                'user_id' => $user_id,
                'kyc_verification_id' => $kyc_verification_id,
                'extras' => null,
            ]);

            return responser()->send(Status::HTTP_OK, $kyc_file, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    public function list()
    {
        try {
            $kyc_files = KycFile::where(['user_id' => auth()->id()])->get();

            return responser()->send(Status::HTTP_OK, $kyc_files, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    /**
     * Change kyc file
     */
    public function change(int $id, Request $request): JsonResponse
    {
        try {
            $kyc_file = KycFile::where(['id' => $id, 'user_id' => auth()->id()])->first();
            if (strtolower($kyc_file->status) === strtolower(KycFileStatusEnum::ACCEPTED->value)) {
                return responser()->send(Status::HTTP_BAD_REQUEST, [], 'Operation not allowed. Uploaded file is already accepted.');
            }

            $previous_file = optional($kyc_file->extras)->filename;
            $kyc_file->uploaded_file = $this->uploadToS3($request->file('kyc_file'), $previous_file);
            $kyc_file->status = KycFileStatusEnum::PENDING->value;

            $kyc_file->update();

            return responser()->send(Status::HTTP_OK, $kyc_file, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    /**
     * Delete kyc file
     *
     * @param  Request  $request
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $kyc_file = KycFile::where(['id' => $id, 'user_id' => auth()->id()])->first();
            if (empty($kyc_file)) {
                return responser()->send(Status::HTTP_NOT_FOUND, [], 'Record not found. Try again.');
            }

            if (strtolower($kyc_file->status) === strtolower(KycFileStatusEnum::ACCEPTED->value)) {
                return responser()->send(Status::HTTP_BAD_REQUEST, [], 'Operation not allowed. Accepted file cannot be deleted.');
            }

            $kyc_file->delete();

            return responser()->send(Status::HTTP_OK, null, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }
}
