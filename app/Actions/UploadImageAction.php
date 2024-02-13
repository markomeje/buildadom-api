<?php

namespace App\Actions;
use Illuminate\Http\UploadedFile;
use Storage;


class UploadImageAction
{
  /**
   * Handle Image upload
   * @param UploadedFile $file
   * @param mixed $previous_file
   * @return array
   */
  public static function handle(UploadedFile $file, $previous_file = null): array
  {
    $extension = $file->getClientOriginalExtension();
    $file_string = str()->random(32);
    $filename = "{$file_string}.{$extension}";
    $disk = Storage::disk('s3');

    if($previous_file && $disk->has($previous_file)) {
      $disk->delete($previous_file);
    }

    $disk->put($filename, file_get_contents($file));
    $url = $disk->url($filename);

    return [
      'file_url' => $url,
      'filename' => $filename
    ];
  }

  /**
   * Delete uploaded image
   * @param string $file
   * @return void
   */
  public static function delete($file = null)
  {
    $disk = Storage::disk('s3');
    if($file && $disk->has($file)) {
      $disk->delete($file);
    }
  }
}
