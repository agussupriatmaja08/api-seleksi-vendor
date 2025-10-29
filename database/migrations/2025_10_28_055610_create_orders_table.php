<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->date('tgl_order');
            $table->string('no_order')->unique();
            $table->foreignId('id_vendor')
                ->constrained('vendors', 'id_vendor')
                ->onDelete('cascade');
            $table->foreignId('id_item')->constrained('items', 'id_item')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
