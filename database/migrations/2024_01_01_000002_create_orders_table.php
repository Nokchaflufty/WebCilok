<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('whatsapp');
            $table->text('address');
            $table->string('note')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'processed', 'completed', 'proses', 'selesai', 'batal'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};