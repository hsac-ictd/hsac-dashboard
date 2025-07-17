<?php

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Widget;

class RedirectToDashboard extends Widget
{
    use HasWidgetShield;
    protected static string $view = 'filament.widgets.redirect-to-dashboard';

    public function getColumnSpan(): int | string | array
    {
        return 'full'; // Or 12 for 12-column layout
    }
}
