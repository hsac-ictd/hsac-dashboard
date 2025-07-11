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
        Schema::create('affirmance_rates', function (Blueprint $table) {
            $table->id();
            $table->string('court', 50);
            $table->string('outcome', 50);
            $table->unsignedBigInteger('total');
            $table->date('month_year');
            $table->timestamps();

            //for pie chart queries
            $table->index(['court', 'month_year']);
            //for filtering by outcome
            $table->index(['court', 'outcome', 'month_year']);

            $table->unique([
                'court',
                'outcome',
                'month_year'
            ], 'unique_monthly_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affirmance_rates');
    }
};
