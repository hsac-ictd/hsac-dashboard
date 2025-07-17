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
        Schema::create('case_timeliness_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('case_type', 30);
            $table->unsignedBigInteger('total_disposed');
            $table->unsignedBigInteger('total_ripe');
            $table->date('month_year');
            $table->unsignedSmallInteger('year');
            $table->timestamps();

            $table->index('month_year');
            $table->index('year');

            $table->unique(['case_type', 'month_year'], 'unique_monthly_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_timeliness_metrics');
    }
};
