<?php

namespace App\Filament\Clusters;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Clusters\Cluster;

class Prexc extends Cluster
{
    use HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationLabel = "PREXC";
    protected static ?string $clusterBreadcrumb = "PREXC";
    protected static ?string $navigationGroup = 'Data Management';
}
