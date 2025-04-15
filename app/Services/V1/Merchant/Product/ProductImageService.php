<?php

namespace App\Services\V1\Merchant\Product;
use App\Enums\Product\ProductImageRoleEnum;
use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use App\Services\BaseService;
use App\Traits\FileUploadTrait;
use App\Traits\ProductImageTrait;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductImageService extends BaseService
{
    use FileUploadTrait;
    use ProductImageTrait;

    public function upload(Request $request): JsonResponse
    {
        try {
            $product_id = $request->product_id;
            $product = Product::owner()->find($product_id);
            if (empty($product)) {
                return responser()->send(Status::HTTP_NOT_FOUND, $product, 'Product not found. Try again.');
            }

            $image_url = $this->uploadToS3($request->file('image'));
            $role = $this->productHasMainImage($product_id) ? ProductImageRoleEnum::OTHERS->value : ProductImageRoleEnum::MAIN->value;

            $product_image = ProductImage::create([
                'role' => $role,
                'product_id' => $product_id,
                'url' => $image_url,
                'user_id' => auth()->id(),
            ]);

            return responser()->send(Status::HTTP_OK, $product_image, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    /**
     * @param  int  $id
     */
    public function delete($id, Request $request): JsonResponse
    {
        try {
            $product_image = ProductImage::owner()->where(['product_id' => $request->product_id])->find($id);
            if (empty($product_image)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Product image not found. Try again.');
            }

            if (strtolower($product_image->role) == strtolower(ProductImageRoleEnum::MAIN->value)) {
                return responser()->send(Status::HTTP_NOT_ACCEPTABLE, null, 'Operation not allowed. You cannot delete a main image.');
            }

            $this->deleteFileFromS3($product_image->url);
            $deleted = $product_image->delete();

            return responser()->send(Status::HTTP_OK, $deleted, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }

    /**
     * @param  int  $id
     */
    public function change($id, Request $request): JsonResponse
    {
        try {
            $product_image = ProductImage::owner()->where(['product_id' => $request->product_id])->find($id);
            if (empty($product_image)) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'Product not found. Try again.');
            }

            $image_url = $this->uploadToS3($request->file('image'), $product_image->url);
            if (empty($image_url)) {
                throw new Exception('Error uploading the image');
            }

            $product_image->update(['url' => $image_url]);

            return responser()->send(Status::HTTP_OK, $product_image, 'Operation successful.');
        } catch (Exception $e) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Operation failed. Try again.');
        }
    }
}
