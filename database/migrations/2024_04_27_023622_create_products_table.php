<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'products',
            function (Blueprint $table) {
                $table->id()->unsigned();
                $table->uuid('uuid')->unique()->nullable(false);
                $table->string('barcode')->unique()->nullable(false);
                $table->string('name')->nullable(false);
                $table->float('price', 8, 2);
                $table->integer('qty_stock');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
