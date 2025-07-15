<?php

namespace App\Filament\Clusters;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Clusters\Cluster;

class Cases extends Cluster
{
    use HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $navigationLabel = "Cases";
    protected static ?string $clusterBreadcrumb = "Cases";
    protected static ?string $navigationGroup = 'Data Management';
}
