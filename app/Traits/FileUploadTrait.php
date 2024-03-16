<?php

namespace App\Traits;

use App\Utility\Help;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
  /**
   * @param UploadedFile $file
   * @param string|null $previous_file
   * @return string
   */
  public function uploadToS3(UploadedFile $file, string|null $previous_file = null): string
  {
    return $this->uploadFile($file, Storage::disk('s3'), $previous_file, false);
  }

  /**
   * @param UploadedFile $file
   * @param string|null $previous_file
   * @return string
   */
  public function uploadToLocal(UploadedFile $file, string|null $previous_file = null): string
  {
    return $this->uploadFile($file, Storage::disk('local'), $previous_file, true);
  }

  /**
   * @param UploadedFile $file
   * @param string|null $previous_file
   * @param bool $is_local
   * @return string
   */
  private function uploadFile(UploadedFile $file, mixed $disk, string|null $previous_file = null, bool $is_local = false): string
  {
    $this->deleteFile($disk, $previous_file);

    $filename = Help::generateFilename($file);
    $disk->put($filename, file_get_contents($file));
    return (string)$disk->url($filename);
  }

  /**
   * @param mixed $disk,
   * @param string|null $previous_file
   * @return void
   */
  private function deleteFile(mixed $disk, string|null $previous_file = null)
  {
    if(!empty($previous_file)) {
      $filename = basename($previous_file);
      if($disk->has($filename)) {
        $disk->delete($filename);
      }
    }
  }

  /**
   * @param string|null $previous_file
   * @return void
   */
  public function deleteFileFromS3(string|null $previous_file = null)
  {
    $this->deleteFile(Storage::disk('s3'), $previous_file);
  }

  /**
   * @param string|null $previous_file
   * @return void
   */
  public function deleteFileFromLocal(string|null $previous_file = null)
  {
    $this->deleteFile(Storage::disk('local'), $previous_file);
  }

}
