<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('user_id');
			$table->string('coupon_code');
			$table->float('coupon_amount')->default(0);
			$table->float('coupon_percent')->default(0);
			$table->tinyInteger('coupon_type');
			$table->tinyInteger('minimum_requrment_type')->nullable();
			$table->float('minimum_requrment')->default(0)->nullable();
			$table->tinyInteger('is_coupon_limit')->nullable();
			$table->tinyInteger('once_per_user')->default(0)->nullable();
			$table->integer('coupon_limit')->nullable();
			$table->date('active_date');
			$table->time('active_time')->nullable();
			$table->date('end_date');
			$table->time('end_time')->nullable();
			$table->boolean('show_in_list')->default(false)->nullable();
			$table->string('status')->default('Active');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users') ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
