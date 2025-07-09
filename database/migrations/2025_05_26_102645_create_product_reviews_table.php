<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('product_id');
			$table->unsignedBigInteger('user_id');
			$table->float('rating', 2, 1)->default(0);
			$table->string('review_title');
			$table->string('review');
			$table->string('email');
			$table->string('reviewer_name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('product_id')->references('id')->on('products') ->cascadeOnDelete();
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
        Schema::dropIfExists('product_reviews');
    }
}
