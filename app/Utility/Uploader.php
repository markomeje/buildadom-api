<?php

namespace App\Utility;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class Uploader
{

  /**
   * Handle Image upload
   * @param UploadedFile $file
   * @param mixed $previous_file
   * @param string $path
   * @return mixed
   */
  public function uploadToS3(UploadedFile $file, $previous_file = null)
  {
    $filename = $this->generateFilename($file);
    $disk = Storage::disk('s3');

    if($previous_file && is_string($previous_file)) {
      $old_file = basename($previous_file);
      if($disk->has($old_file)) {
        $disk->delete($old_file);
      }
    }

    $disk->put($filename, file_get_contents($file));
    return $disk->url($filename);
  }

  /**
   * Generate filename
   *
   * @param UploadedFile $file
   * @return string
   */
  private function generateFilename(UploadedFile $file): string
  {
    $extension = $file->getClientOriginalExtension();
    $file_string = str()->random(32);
    return "$file_string.$extension";
  }

}
