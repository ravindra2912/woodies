<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('brand')->nullable();
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->bigInteger('price')->default(0);
            $table->bigInteger('original_price')->default(0);
            $table->float('purchase_price', 10, 1)->default(0);
            $table->float('margin', 10, 1)->default(0);
            $table->bigInteger('quantity')->default(0);
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->text('SEO_description')->nullable();
            $table->string('SEO_tags')->nullable();
            $table->float('rating', 2, 1)->default(0);
            $table->boolean('is_tax_applicable')->default(0);
            $table->boolean('is_replacement')->default(0);
            $table->Integer('replacement_days')->default(0);
            $table->boolean('is_variants')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->date('featured_date')->nullable();
            $table->integer('igst')->default(0);
            $table->integer('cgst')->default(0);
            $table->integer('sgst')->default(0);
            $table->string('status')->default('Active');

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('coupon_id')->references('id')->on('coupons')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
