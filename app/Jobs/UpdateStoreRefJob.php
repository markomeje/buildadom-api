<?php

declare(strict_types=1);

namespace App\Jobs;
use App\Enums\QueuedJobEnum;
use App\Models\Store\Store;
use App\Traits\StoreTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStoreRefJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use StoreTrait;

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
        $stores = Store::where(['ref' => null])->orWhere('slug', null)->get();
        if ($stores->count()) {
            $stores->map(function ($store)
            {
                $store->update(['ref' => $this->generateUniqueStoreRef(), 'slug' => strtolower(str()->slug($store->name))]);
            });
        }
    }
}
