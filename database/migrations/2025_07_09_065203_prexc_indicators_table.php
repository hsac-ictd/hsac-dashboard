<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prexc_indicators', function (Blueprint $table) {
            $table->id();
            $table->string('indicator', 100);
            $table->decimal('target', 10, 2);
            $table->decimal('accomplishment', 10, 2);
            $table->unsignedSmallInteger('year');
            $table->decimal('percentage_of_accomplishment', 10, 2);
            $table->timestamps();

            $table->index(['indicator', 'year']);
            $table->index('year');

            $table->unique([
                'indicator',
                'year'
            ], 'unique_yearly_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prexc_indicators');
    }
};
