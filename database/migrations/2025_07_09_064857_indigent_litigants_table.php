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
        Schema::create('indigent_litigants', function (Blueprint $table) {
            $table->id();
            $table->string('rab', 50);
            $table->date('month_year');
            $table->unsignedBigInteger('total_indigents');
            $table->unsignedBigInteger('with_certificate');
            $table->timestamps();

            $table->index(['rab', 'month_year']);
            $table->index('month_year');

            $table->unique([
                'rab',
                'month_year'
            ], 'unique_monthly_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indigent_litigants');
    }
};
