<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array<int, string|null>
     */
    public function hosts()
    {
        return [
            $this->allSubdomainsOfApplicationUrl(),
            'http://localhost:9004',
            'https://buildadom.com',
            'https://main.d3rwsmys7ohsil.amplifyapp.com',
        ];
    }
}
