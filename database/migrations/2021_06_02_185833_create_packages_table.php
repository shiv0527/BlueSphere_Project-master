<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            // $table->id();
            $table->increments('id');
            $table->string('product_id')->unique();
            $table->string('package_name');
            $table->integer('package_benefits');
            $table->string('package_duration');
            $table->string('is_active');
            $table->string('price_id')->nullable();
            $table->integer('price');
            $table->integer('offer_price');
            $table->softDeletes();
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
        Schema::dropIfExists('packages');
    }
}
