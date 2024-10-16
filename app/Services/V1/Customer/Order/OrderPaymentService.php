<?php

namespace App\Services\V1\Customer\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Http\Resources\V1\Customer\Order\OrderPaymentResource;
use App\Integrations\Paystack;
use App\Jobs\V1\Order\SaveCustomerOrderPaymentJob;
use App\Models\Order\Order;
use App\Models\Order\OrderPayment;
use App\Models\Payment\Payment;
use App\Services\BaseService;
use App\Traits\V1\CurrencyTrait;
use App\Traits\V1\Fee\FeeSettingTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderPaymentService extends BaseService
{
  use CurrencyTrait, FeeSettingTrait;

  /**
   * @return JsonResponse
   */
  public function initialize(): JsonResponse
  {
    try {
      $orders = Order::owner()->where(['status' => OrderStatusEnum::PENDING->value])->get();
      if(empty($orders->count())) {
        return responser()->send(Status::HTTP_NOT_FOUND, null, 'No pending orders found.');
      }

      $amount = $orders->sum('total_amount');
      $currency = $this->getDefaultCurrency();

      $fee = $this->calculateFeeAmount('VAT', $amount);
      $total_amount = ($amount + $fee);

      $payload = [
        'amount' => (int)($total_amount * 100), //in kobo
        'reference' => (string)str()->uuid(),
        'email' => auth()->user()->email,
        'currency' => strtoupper($currency->code)
      ];

      $paystack = Paystack::payment()->initialize($payload);
      $customer_id = (int)auth()->id();

      $payment = Payment::updateOrCreate([
        'user_id' => $customer_id,
        'amount' => $amount,
        'status' => PaymentStatusEnum::INITIALIZED->value
      ], [
        'user_id' => $customer_id,
        'total_amount' => $total_amount,
        'amount' => $amount,
        'fee' => $fee,
        'reference' => $payload['reference'],
        'status' => PaymentStatusEnum::INITIALIZED->value,
        'currency_id' => $currency->id,
        'payload' => $payload,
        'initialize_response' => $paystack,
        'type' => PaymentTypeEnum::CHARGE->value
      ]);

      SaveCustomerOrderPaymentJob::dispatch($orders, $customer_id, $payment->id);
      return responser()->send(Status::HTTP_OK, $paystack, 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  /**
   * @param Request $request
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $orders = OrderPayment::owner()->latest()->with(['payment', 'order'])->paginate($request->limit ?? 20);
      return responser()->send(Status::HTTP_OK, OrderPaymentResource::collection($orders), 'Operation successful.');
    } catch (Exception $e) {
      return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}
