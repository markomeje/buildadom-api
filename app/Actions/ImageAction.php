<?php

namespace App\Actions;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Storage;
use Exception;


class ImageAction 
{
  /**
   * Handle Image upload
   * 
   * @return Image model
   */
  public function handle(array $data): Image
  {
    $upload = function() use ($data) {
      $file = $data['image'];
      $filename = str()->uuid();
      $extension = $file->getClientOriginalExtension();

      $avatar = "{$filename}.{$extension}";
      $disk = Storage::disk('s3');

      unset($data['image']);
      $image = Image::where([...$data, 'user_id' => auth()->id()])->first();
      if (empty($image)) {
        $disk->put($avatar, file_get_contents($file));
        return Image::create([
          ...$data,
          'user_id' => auth()->id(),
          'url' => $disk->url($avatar)
        ]);
      }

      $url = explode('/', $image->url);
      $filename = end($url);
      if($disk->has($filename)) {
        if(!$disk->delete($filename)) throw new Exception('Could not delete image');
      }

      $disk->put($avatar, file_get_contents($file));
      $image->update([...$data, 'user_id' => auth()->id(), 'url' => $disk->url($avatar)]);
      return $image;
    };

    return DB::transaction($upload);
  }
}







