<?php

namespace App\Traits;
use App\Models\Store\Store;

trait StoreTrait
{
    public function generateUniqueStoreRef(): string
    {
        do {
            $ref = str()->random(64);
        } while (Store::where('ref', $ref)->exists());

        return $ref;
    }
}
