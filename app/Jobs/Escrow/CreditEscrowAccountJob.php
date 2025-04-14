<?php

declare(strict_types=1);

namespace App\Jobs\Escrow;
use App\Enums\Escrow\EscrowPaymentTypeEnum;
use App\Enums\Payment\PaymentAccountTypeEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Escrow\EscrowPayment;
use App\Models\Payment\Payment;
use App\Traits\Escrow\EscrowAccountTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreditEscrowAccountJob implements ShouldQueue
{
    use Dispatchable;
    use EscrowAccountTrait;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $tries = 5; // Number of attempts

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->onQueue(QueueEnum::ESCROW->value);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payments = Payment::where([
            'status' => PaymentStatusEnum::SUCCESS->value,
            'account_type' => PaymentAccountTypeEnum::ESCROW->value,
            'type' => PaymentTypeEnum::CHARGE->value,
        ])->get();

        if ($payments->count()) {
            $payments->map(function ($payment)
            {
                $this->handleEscrowPayment($payment);
            });
        }
    }

    /**
     * @return void
     */
    private function handleEscrowPayment(Payment $payment)
    {
        $float_amount = (float) $payment->amount;
        $payment_id = $payment->id;
        $user_id = $payment->user_id;

        $escrow_payment = EscrowPayment::where([
            'payment_id' => $payment_id,
            'user_id' => $user_id,
            'payment_type' => EscrowPaymentTypeEnum::DEPOSIT->value,
        ])->first();

        if (!$escrow_payment) {
            $escrow = $this->creditEscrowAccount($payment->user, $float_amount);
            EscrowPayment::create([
                'payment_id' => $payment_id,
                'user_id' => $user_id,
                'amount' => $float_amount,
                'payment_type' => EscrowPaymentTypeEnum::DEPOSIT->value,
                'escrow_account_id' => $escrow->id,
            ]);
        }
    }
}
