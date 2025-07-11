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
        Schema::create('rab_cases', function (Blueprint $table) {
            $table->id();
            $table->string('rab', 50);
            $table->string('status', 20);
            $table->string('case_type', 20);
            $table->unsignedBigInteger('total');
            $table->date('month_year');
            $table->timestamps();

            //total rab cases per status in a specific year
            $table->index(['status', 'month_year']);

            //new cases filed per rab per month in a specific year
            $table->index(['rab', 'status', 'month_year']);

            //rab cases per status per case type per month in a specific year
            $table->index(['rab', 'status', 'case_type', 'month_year']);
            $table->index(['status', 'case_type', 'month_year']);

            $table->unique([
                'rab',
                'status',
                'case_type',
                'month_year',
            ], 'unique_monthly_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rab_cases');
    }
};
