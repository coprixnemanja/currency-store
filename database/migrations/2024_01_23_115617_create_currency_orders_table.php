<?php

use App\Models\Currency;
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
        Schema::create('currency_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_id')->references('id')->on('currencies')->cascadeOnDelete();
            $table->unsignedDecimal('rate', 12, 8);
            $table->unsignedDecimal('surcharge_percentage',5, 2);
            $table->unsignedDecimal('surcharge_amount', 12, 4);
            $table->unsignedMediumInteger('amount_purchased');
            $table->unsignedDecimal('amount_usd', 12, 4);
            $table->unsignedDecimal('discount_percentage',5, 2);
            $table->unsignedDecimal('discount_amount', 12, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_orders');
    }
};
