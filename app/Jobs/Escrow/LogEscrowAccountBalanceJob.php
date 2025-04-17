<?php

namespace App\Jobs\Escrow;
use App\Enums\Queue\QueueEnum;
use App\Models\Escrow\EscrowAccount;
use App\Models\Escrow\EscrowBalance;
use App\Models\User;
use App\Traits\Escrow\EscrowAccountTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogEscrowAccountBalanceJob implements ShouldQueue
{
    use Dispatchable;
    use EscrowAccountTrait;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private float $new_balance,
        private float $old_balance,
        private EscrowAccount $escrow_account,
        private float $amount,
        private string $balance_type,
        private User $user
    ) {
        $this->onQueue(QueueEnum::ESCROW->value);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        EscrowBalance::create([
            'old_balance' => $this->old_balance,
            'new_balance' => $this->new_balance,
            'balance_type' => $this->balance_type,
            'escrow_account_id' => $this->escrow_account->id,
            'amount' => $this->amount,
            'user_id' => $this->user->id,
        ]);
    }
}
