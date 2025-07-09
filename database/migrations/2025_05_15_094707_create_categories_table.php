<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->unsignedBigInteger('parent_id')->nullable();
			$table->string('slug');
			$table->string('image',250)->nullable();
			$table->string('banner_img',250)->nullable();
			$table->string('SEO_description')->nullable();
			$table->string('SEO_tags')->nullable();
			$table->string('status')->default('Active');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parent_id')->references('id')->on('categories') ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
