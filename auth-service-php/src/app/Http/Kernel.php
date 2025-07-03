<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\SubstituteBindings;

class Kernel extends HttpKernel
{

    /**
     * Middleware groups.
     */
    protected $middlewareGroups = [
        'api' => [
            'throttle:api',
            SubstituteBindings::class,
        ]
    ];
}
