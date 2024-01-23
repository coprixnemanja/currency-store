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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 75);
            $table->string('signature', 3)->unique();
            $table->unsignedDecimal('rate', 12, 8);
            $table->unsignedDecimal('surcharge',5, 2);
            $table->boolean('send_order_email');
            $table->unsignedDecimal('discount',5, 2);
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
