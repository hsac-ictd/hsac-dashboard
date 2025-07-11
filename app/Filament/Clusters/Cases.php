<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Cases extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $navigationLabel = "Cases";
    protected static ?string $clusterBreadcrumb = "Cases";
    protected static ?string $navigationGroup = 'Data Management';
}
