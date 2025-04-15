<?php

namespace App\Enums;
use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum QueuedJobEnum: string
{
    use UsefulEnums;

    case ESCROW = 'escrow';
    case ORDER = 'order';
    case SMS = 'sms';
    case EMAIL = 'email';
    case PAYMENT = 'payment';
    case KYC = 'kyc';
    case INFO = 'info';
}
