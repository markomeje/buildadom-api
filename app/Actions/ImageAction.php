<?php

namespace App\Actions;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OnboardingRequest;
use Storage;

/**
 * Like a black box
 * With one method
 * 
 */
class ImageAction 
{
  /**
   * Handle Image upload
   * 
   * @return Image model
   */
  public function handle($request): Image
  {
    return DB::transaction(function() use ($request) {
      $file = $request->file('image');

      $filename = str()->random(64);
      $extension = $file->getClientOriginalExtension();

      $avatar = "{$filename}.{$extension}";
      $disk = Storage::disk('s3');
      $disk->put($avatar, file_get_contents($file));

      return Image::create([
        'model_id' => $request->model_id,
        'model' => $request->model,
        'url' => $disk->url($avatar),
        'user_id' => auth()->id(),
        'role' => $request->role
      ]);
    });
  }
}







