<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'order_items',
            function (Blueprint $table) {
                $table->id();
                $table->bigInteger('product_id')->unsigned()->nullable(false);
                $table->bigInteger('order_id')->unsigned()->nullable(false);
                $table->integer('quantity')->unsigned()->nullable(false);
                $table->float('price', 8, 2)->unsigned()->nullable(false);
                $table->timestamps();

                $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
                    ->onDelete('cascade');

                $table->foreign('order_id')
                    ->references('id')
                    ->on('orders')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
