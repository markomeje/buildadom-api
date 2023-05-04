<?php

namespace App\Actions;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Storage;
use Exception;


class UploadImageAction
{
  /**
   * Handle Image upload
   * 
   * @return Image model
   */
  public static function handle(array $data): Image
  {
    return DB::transaction(function() use ($data) {
      $file = request()->file('image');
      $extension = $file->getClientOriginalExtension();

      $filename = str()->random(32);
      $avatar = "{$filename}.{$extension}";
      $disk = Storage::disk('s3');

      unset($data['image']);
      $image = Image::where(['model' => $data['model'], 'model_id' => $data['model_id'], 'user_id' => auth()->id()])->first();
      if (empty($image)) {
        $disk->put($avatar, file_get_contents($file));
        $image = Image::create(['user_id' => auth()->id(), 'url' => $disk->url($avatar), ...$data, 'filename' => $filename, 'extension' => $extension]);
      }else {
        if($disk->has($avatar)) $disk->delete($avatar);
        $disk->put($avatar, file_get_contents($file));
        $image->update([...$data, 'url' => $disk->url($avatar), 'filename' => $filename, 'extension' => $extension]);
      }

      return $image;
    });
  }
}







