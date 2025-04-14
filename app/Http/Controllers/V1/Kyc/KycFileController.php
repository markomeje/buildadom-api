<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Kyc;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Kyc\ChangeKycFileRequest;
use App\Http\Requests\V1\Kyc\UploadKycFileRequest;
use App\Services\V1\Kyc\KycFileService;
use Illuminate\Http\JsonResponse;

class KycFileController extends Controller
{
    public function __construct(private KycFileService $kycFile)
    {
        $this->kycFile = $kycFile;
    }

    /**
     * @param JsonResponse
     */
    public function upload(UploadKycFileRequest $request): JsonResponse
    {
        return $this->kycFile->upload($request);
    }

    /**
     * @param JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return $this->kycFile->delete((int) $id);
    }

    /**
     * @param JsonResponse
     */
    public function change(int $id, ChangeKycFileRequest $request): JsonResponse
    {
        return $this->kycFile->change((int) $id, $request);
    }

    /**
     * @param JsonResponse
     */
    public function list(): JsonResponse
    {
        return $this->kycFile->list();
    }
}
