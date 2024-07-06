<?php

namespace App\Services\V1\Customer\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Http\Resources\V1\Customer\Order\OrderPaymentResource;
use App\Integrations\Paystack;
use App\Jobs\V1\Order\SaveCustomerOrderPaymentJob;
use App\Models\Order\Order;
use App\Models\Order\OrderPayment;
use App\Services\BaseService;
use App\Traits\V1\CurrencyTrait;
use App\Traits\V1\PaymentTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class OrderPaymentService extends BaseService
{
  use CurrencyTrait, PaymentTrait;

  /**
   * @return JsonResponse
   */
  public function initialize(): JsonResponse
  {
    try {
      $orders = Order::owner()->where(['status' => OrderStatusEnum::PENDING->value])->get();
      if(empty($orders->count())) {
        return Responser::send(Status::HTTP_NOT_FOUND, null, 'No pending orders found.');
      }

      $reference = (string)str()->uuid();
      $total_amount = $orders->sum('total_amount');
      $currency = $this->getDefaultCurrency();

      $paystack = Paystack::payment()->initialize([
        'amount' => (int)$total_amount * 100, //in kobo
        'reference' => $reference,
        'email' => auth()->user()->email,
        'currency' => strtoupper($currency->code)
      ]);

      $customer_id = (int)auth()->id();
      $payment = $this->createPayment($customer_id, $total_amount, $reference, (int)$currency->id);
      SaveCustomerOrderPaymentJob::dispatch($orders, $customer_id, $payment->id);

      return Responser::send(Status::HTTP_OK, $paystack, 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

  /**
   * @param Request $request
   */
  public function list(Request $request): JsonResponse
  {
    try {
      $orders = OrderPayment::owner()->latest()->with(['payment', 'order'])->paginate($request->limit ?? 20);
      return Responser::send(Status::HTTP_OK, OrderPaymentResource::collection($orders), 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}
