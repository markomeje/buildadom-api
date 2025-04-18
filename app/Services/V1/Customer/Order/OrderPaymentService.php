<?php

namespace App\Services\V1\Customer\Order;
use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Http\Resources\V1\Customer\Order\OrderPaymentResource;
use App\Jobs\Order\SaveCustomerOrderPaymentJob;
use App\Models\Order\Order;
use App\Models\Order\OrderPayment;
use App\Models\User;
use App\Partners\Paystack;
use App\Services\BaseService;
use App\Traits\CurrencyTrait;
use App\Traits\Fee\FeeSettingTrait;
use App\Traits\Payment\PaymentTrait;
use App\Utility\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderPaymentService extends BaseService
{
    use CurrencyTrait;
    use FeeSettingTrait;
    use PaymentTrait;

    public function initialize(Request $request): JsonResponse
    {
        try {
            $orders = Order::owner()->where(['status' => OrderStatusEnum::PENDING->value])->get();
            if (empty($orders->count())) {
                return responser()->send(Status::HTTP_NOT_FOUND, null, 'No pending orders found.');
            }

            $amount = $orders->sum('total_amount');
            $currency = $this->getDefaultCurrency();

            $fee = $this->calculateFeeAmount('VAT', $amount);
            $total_amount = ($amount + $fee);
            $reference = (string) str()->uuid();

            $customer = User::find(auth()->id());
            $payment = $this->initializePayment($customer, $reference, $amount, $fee, PaymentTypeEnum::CHARGE->value, $request->account_type);

            $payload = [
                'amount' => (int) ($total_amount * 100), // in kobo
                'reference' => $reference,
                'email' => auth()->user()->email,
                'currency' => strtoupper($currency->code),
            ];

            $paystack = Paystack::payment()->initialize($payload);
            $payment->update(['payload' => $payload, 'initialize_response' => $paystack]);

            SaveCustomerOrderPaymentJob::dispatch($orders, $customer, $payment);

            return responser()->send(Status::HTTP_OK, $paystack, 'Order payment initialized successfully.');
        } catch (Exception) {
            return responser()->send(Status::HTTP_INTERNAL_SERVER_ERROR, [], 'Order payment initialization failed. Try again.');
        }
    }

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
