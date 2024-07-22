<?php

namespace App\Jobs;
use App\Enums\QueuedJobEnum;
use App\Notifications\LogDeveloperInfoNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class LogDeveloperInfoJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(private $info)
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
    Notification::route('mail', ['markomejeonline@gmail.com'])->notify(new LogDeveloperInfoNotification($this->info));
  }

}
