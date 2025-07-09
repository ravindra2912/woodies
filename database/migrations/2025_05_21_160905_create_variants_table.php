<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('product_id');	
			$table->unsignedBigInteger('variant_name_id');	
			$table->string('variant');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('product_id')->references('id')->on('products') ->cascadeOnDelete();
            $table->foreign('variant_name_id')->references('id')->on('variant_names') ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variants');
    }
}
