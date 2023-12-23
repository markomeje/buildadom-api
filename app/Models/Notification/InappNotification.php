<?php

namespace App\Models\Notification;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InappNotification extends DatabaseNotification
{
  use HasFactory;

  protected $table = 'inapp_notifications';

  private $quarded = [];

}
