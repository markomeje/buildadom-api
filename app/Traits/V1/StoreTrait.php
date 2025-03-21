<?php

namespace App\Traits\V1;
use App\Enums\User\UserTypeEnum;
use App\Models\Store\Store;
use App\Models\User;


trait StoreTrait
{
    /**
     * @return string
     */
    public function generateUniqueStoreRef(): string
    {
        do {
            $ref = str()->random(64);
        } while (Store::where('ref', $ref)->exists());
        return $ref;
    }

}
