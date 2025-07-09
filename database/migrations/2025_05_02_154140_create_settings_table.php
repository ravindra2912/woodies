<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
			$table->string('seo_title', 200)->nullable();
			$table->text('seo_tags')->nullable();
			$table->text('seo_description')->nullable();
			$table->string('Facebook', 200)->nullable();
			$table->string('Instagram', 200)->nullable();
			$table->string('LinkedIn', 200)->nullable();
			$table->string('YouTube', 200)->nullable();
			$table->string('Twitter', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
