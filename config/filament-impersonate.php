<?php
return [
    // This is the guard used when logging in as the impersonated user.
    'guard' => env('FILAMENT_IMPERSONATE_GUARD', 'web'),
    
    // After impersonating this is where we'll redirect you to.
    'redirect_to' => env('FILAMENT_IMPERSONATE_REDIRECT', '/'),

    // We wire up a route for the "leave" button. You can change the middleware stack here if needed.
    'leave_middleware' => env('FILAMENT_IMPERSONATE_LEAVE_MIDDLEWARE', 'web'),

    'banner' => [
        // Available hooks: https://filamentphp.com/docs/3.x/support/render-hooks#available-render-hooks
        'render_hook' => env('FILAMENT_IMPERSONATE_BANNER_RENDER_HOOK', 'panels::body.start'),
    
        // Currently supports 'dark', 'light' and 'auto'.
        'style' => env('FILAMENT_IMPERSONATE_BANNER_STYLE', 'auto'),

        // Turn this off if you want `absolute` positioning, so the banner scrolls out of view
        'fixed' => env('FILAMENT_IMPERSONATE_BANNER_FIXED', false),

        // Currently supports 'top' and 'bottom'.
        'position' => env('FILAMENT_IMPERSONATE_BANNER_POSITION', 'top'),

        'styles' => [
            'light' => [
                'text' => '#FEFFFE',
                'background' => '#4E47E5',
                'border' => '#F49F0B',
            ],
            'dark' => [
                'text' => '#FEFFFE',
                'background' => '#6266F0',
                'border' => '#F49F0B',
            ],
        ]
    ],
];
