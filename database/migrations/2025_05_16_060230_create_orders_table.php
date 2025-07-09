<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('address_id')->nullable();
			$table->unsignedBigInteger('coupon_id')->nullable();
			$table->string('coupon_code', 10)->nullable();
			$table->string('name');
			$table->bigInteger('contact');
			$table->string('address');
			$table->string('address2')->nullable();
			$table->string('country');
			$table->string('state');
			$table->string('payment_transaction_id')->nullable();
			$table->string('payment_status')->default(0);
			$table->string('payment_by')->nullable();
			$table->tinyInteger('payment_type');
			$table->string('city');
			$table->string('zipcode', 6);
			$table->float('shipping', 8, 2)->default(0);
			$table->float('subtotal', 8, 2)->default(0);
			$table->float('discount', 8, 2)->default(0);
			$table->float('tax', 8, 2)->default(0);
			$table->float('total', 8, 2)->default(0);
            $table->dateTime('delivery_date')->nullable();
			$table->string('status')->default('1');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users') ->cascadeOnDelete();
            $table->foreign('address_id')->references('id')->on('addresses') ->cascadeOnDelete();
            $table->foreign('coupon_id')->references('id')->on('coupons') ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
