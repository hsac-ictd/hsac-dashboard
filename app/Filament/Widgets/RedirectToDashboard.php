<?php

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Widget;

class RedirectToDashboard extends Widget
{
    use HasWidgetShield;
    protected static string $view = 'filament.widgets.redirect-to-dashboard';
}
