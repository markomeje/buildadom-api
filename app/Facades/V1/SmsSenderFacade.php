<?php

namespace App\Facades\V1;
use App\Enums\Sms\SmsStatusEnum;
use App\Facades\BaseFacade;
use App\Jobs\V1\SmsSenderJob;
use App\Models\SmsLog;
use App\Models\User;
use App\Utility\Help;

class SmsSenderFacade extends BaseFacade
{
  /**
   *
   */
  public static function push(User $user, string $message): SmsLog
  {
    $smsLog = SmsLog::query()->create([
      'user_id' => $user->id,
      'phone' => Help::formatPhoneNumber($user->phone),
      'message' => $message,
      'status' => SmsStatusEnum::PENDING->value,
      'from' => config('services.termii.sender_id')
    ]);

    SmsSenderJob::dispatch($smsLog->id);
    return $smsLog;
  }

}