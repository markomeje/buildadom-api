<?php

namespace App\Services\V1\Merchant\Product;

use App\Enums\Product\ProductImageRoleEnum;
use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use App\Services\BaseService;
use App\Traits\FileUploadTrait;
use App\Traits\ProductImageTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductImageService extends BaseService
{
  use FileUploadTrait, ProductImageTrait;

  /**
   * @param int $product_id,
   * @param Request $request
   * @return JsonResponse
   */
  public function upload($product_id, Request $request): JsonResponse
  {
    try {
      $product = Product::find($product_id);
      if(empty($product)) {
        return Responser::send(Status::HTTP_NOT_FOUND, $product, 'Product not found. Try again.');
      }

      $image_url = $this->uploadToS3($request->file('image'));
      $role = strtolower($request->role);
      if($this->productHasMainImage($product_id) && ($role == strtolower(ProductImageRoleEnum::MAIN->value))) {
        $role = ProductImageRoleEnum::OTHERS->value;
      }

      $product_image = ProductImage::create([
        'role' => $role,
        'product_id' => $product_id,
        'url' => $image_url,
        'user_id' => auth()->id(),
      ]);

      return Responser::send(Status::HTTP_OK, $product_image, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

  /**
   * @param int $id
   * @return JsonResponse
   */
  public function delete($id): JsonResponse
  {
    try {
      $product_image = ProductImage::owner()->find($id);
      if(empty($product_image)) {
        return Responser::send(Status::HTTP_NOT_FOUND, $product_image, 'Product image not found. Try again.');
      }

      $this->deleteFileFromS3($product_image->url);
      $deleted = $product_image->delete();
      return Responser::send(Status::HTTP_OK, $deleted, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

  /**
   * @param int $id,
   * @param Request $request
   * @return JsonResponse
   */
  public function change($id, Request $request): JsonResponse
  {
    try {
      $product_image = ProductImage::owner()->find($id);
      if(empty($product_image)) {
        return Responser::send(Status::HTTP_NOT_FOUND, $product_image, 'Product not found. Try again.');
      }

      $image_url = $this->uploadToS3($request->file('image'), $product_image->url);
      $product_image->update(['url' => $image_url]);

      return Responser::send(Status::HTTP_OK, $product_image, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.', $e);
    }
  }

}
