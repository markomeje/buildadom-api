<?php

declare(strict_types=1);

namespace App\Traits;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    /**
     * @param  mixed  $previous_file
     */
    public function uploadToS3(UploadedFile $file, ?string $previous_file = null): string
    {
        return $this->uploadFile($file, Storage::disk('s3'), $previous_file);
    }

    /**
     * @param  mixed  $previous_file
     */
    public function uploadToLocal(UploadedFile $file, ?string $previous_file = null): string
    {
        return $this->uploadFile($file, Storage::disk('local'), $previous_file);
    }

    /**
     * @return void
     */
    public function deleteFileFromS3(?string $previous_file = null)
    {
        $this->deleteFile(Storage::disk('s3'), $previous_file);
    }

    public function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str()->random(32);

        return "{$filename}.{$extension}";
    }

    /**
     * @return void
     */
    public function deleteFileFromLocal(?string $previous_file = null)
    {
        $this->deleteFile(Storage::disk('local'), $previous_file);
    }

    /**
     * @param  mixed  $previous_file
     */
    private function uploadFile(UploadedFile $file, mixed $disk, ?string $previous_file = null): string
    {
        $this->deleteFile($disk, $previous_file);

        $filename = $this->generateFilename($file);
        $disk->put($filename, file_get_contents($file));

        return (string) $disk->url($filename);
    }

    /**
     * @param  mixed  $previous_file
     * @return void
     */
    private function deleteFile(mixed $disk, ?string $previous_file = null)
    {
        if (!empty($previous_file)) {
            $filename = basename($previous_file);
            if ($disk->has($filename)) {
                $disk->delete($filename);
            }
        }
    }
}
