<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('user_id');
			$table->string('name')->nullable();
			$table->bigInteger('contact');
			$table->string('address');
			$table->string('address2');
			$table->string('country');
			$table->string('state');
			$table->string('city');
			$table->string('zipcode', 6);
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
        Schema::dropIfExists('addresses');
    }
}
