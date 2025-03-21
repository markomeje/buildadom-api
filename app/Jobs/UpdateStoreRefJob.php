<?php

namespace App\Jobs;
use App\Enums\QueuedJobEnum;
use App\Models\Store\Store;
use App\Traits\V1\StoreTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStoreRefJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, StoreTrait;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->onQueue(QueuedJobEnum::INFO->value);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stores = Store::where(['ref' => null])->get();
        if($stores->count()) {
            $stores->map(function ($store) {
                $store->update(['ref' => $this->generateUniqueStoreRef()]);
            });
        }
    }

}
