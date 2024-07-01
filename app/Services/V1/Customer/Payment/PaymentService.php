<?php

namespace App\Services\V1\Customer\Payment;
use App\Enums\Order\OrderStatusEnum;
use App\Http\Resources\V1\Customer\Payment\PaymentResource;
use App\Integrations\Paystack;
use App\Jobs\V1\Customer\Order\SaveCustomerOrderPaymentJob;
use App\Models\Order\Order;
use App\Models\Payment\Payment;
use App\Services\BaseService;
use App\Traits\V1\CurrencyTrait;
use App\Traits\V1\PaymentTrait;
use App\Utility\Responser;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class PaymentService extends BaseService
{
  use CurrencyTrait, PaymentTrait;

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
      $currency = $this->getDefaultCurrency();

      $paystack = Paystack::payment()->initialize([
        'amount' => $total_amount * 100, //in kobo
        'reference' => $reference,
        'email' => auth()->user()->email,
        'currency' => strtoupper($currency->code),
      ]);

      $customer_id = auth()->id();
      $payment = $this->createPayment($customer_id, $total_amount, $reference, $currency->id, $request->all());
      SaveCustomerOrderPaymentJob::dispatch($orders, $customer_id, $payment->id);
      return Responser::send(Status::HTTP_OK, ['payment' => $payment, 'paystack' => $paystack], 'Operation successful.');
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
      $payments = Payment::owner()->with(['currency'])->latest()->paginate($request->limit ?? 20);
      return Responser::send(Status::HTTP_OK, PaymentResource::collection($payments), 'Operation successful.');
    } catch (Exception $e) {
      return Responser::send(Status::HTTP_INTERNAL_SERVER_ERROR, [], $e->getMessage());
    }
  }

}