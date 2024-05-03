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
            'orders',
            function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->unique()->nullable(false);
                $table->bigInteger('client_id')->unsigned()->nullable();
                $table->bigInteger('product_id')->unsigned()->nullable();
                $table->timestamp('delivery_at');
                $table->integer('status')->unsigned();
                $table->timestamps();

                $table->foreign('client_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

                $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
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
        Schema::dropIfExists('orders');
    }
};
