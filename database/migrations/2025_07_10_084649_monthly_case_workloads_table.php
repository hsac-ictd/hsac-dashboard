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
        Schema::create('monthly_case_workloads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('total_disposed');
            $table->unsignedBigInteger('total_handled');
            $table->date('month_year')->unique();
            $table->unsignedSmallInteger('year');
            $table->timestamps();

            $table->index('month_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_case_workloads');
    }
};
