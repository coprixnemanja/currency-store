<?php

use App\Models\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

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
            $table->string('signature', 3);
            $table->float('rate', 12, 8);
            $table->float('surcharge', 3);
            $table->boolean('send_order_email');
            $table->unsignedTinyInteger('discount');
            $table->timestamps();
        });

        Currency::insert([
            [
                'name' => 'Japanese Yen',
                'signature' => 'JPY',
                'rate' => 107.17,
                'surcharge' => 7.5,
                'send_order_email'=>false,
                'discount'=>0,
                'created_at' => Carbon::now()->utc(),
                'updated_at' => Carbon::now()->utc()
            ],
            [
                'name' => 'British Pound',
                'signature' => 'GBP',
                'rate' => 0.711178,
                'surcharge' => 5,
                'send_order_email'=>true,
                'discount'=>0,
                'created_at' => Carbon::now()->utc(),
                'updated_at' => Carbon::now()->utc()],
            [
                'name' => 'Euro',
                'signature' => 'EUR',
                'rate' => 0.884872,
                'surcharge' => 5,
                'send_order_email'=>false,
                'discount'=>2,
                'created_at' => Carbon::now()->utc(),
                'updated_at' => Carbon::now()->utc()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
