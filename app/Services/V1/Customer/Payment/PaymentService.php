<?php

namespace App\Services\V1\Customer\Payment;
use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Integrations\Paystack;
use App\Models\Order\Order;
use App\Models\Order\OrderPayment;
use App\Models\Payment\Payment;
use App\Services\BaseService;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class PaymentService extends BaseService
{
  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function initialize(Request $request): JsonResponse
  {
    try {
      $orders = Order::owner()->where(['status' => OrderStatusEnum::PENDING->value])->get();
      if(empty($orders->count())) {
        return Responser::send(Status::HTTP_NOT_FOUND, [], 'No pending orders found.');
      }

      $reference = str()->uuid();
      $total_amount = (float)$orders->sum('total_amount');
      $paystack = Paystack::payment()->initialize([
        'amount' => $total_amount * 100, //in kobo
        'reference' => $reference,
        'email' => auth()->user()->email,
        'currency' => 'NGN',
      ]);

      $user_id = auth()->id();
      $payment = Payment::updateOrCreate([
        'user_id' => $user_id,
        'amount' => $total_amount,
        'status' => PaymentStatusEnum::INITIALIZED->value
      ], [
        'user_id' => $user_id,
        'amount' => $total_amount,
        'reference' => $reference,
        'status' => PaymentStatusEnum::INITIALIZED->value,
        'payload' => $request->all(),
        'order_id' => $request->order_id
      ]);

      foreach ($orders as $order) {
        $order_id = $order->id;
        OrderPayment::updateOrCreate(['order_id' => $order_id], [
          'order_id' => $order_id,
          'payment_id' => $payment->id,
          'user_id' => $user_id,
        ]);
      }

      return Responser::send(Status::HTTP_OK, [$payment, 'paystack' => $paystack], 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  /**
   * Request $request
   * @return JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $payments = Payment::owner()->latest()->paginate($request->limit ?? 20);
      return Responser::send(Status::HTTP_OK, $payments, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function verify(Request $request): JsonResponse
  {
    try {

      $reference = $request->reference;
      $paystack = Paystack::payment()->verify($reference);
      $payment = Payment::owner()->where([
        'reference' => $reference,
      ]);

      return Responser::send(Status::HTTP_OK, [$payment, 'paystack' => $paystack], 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}