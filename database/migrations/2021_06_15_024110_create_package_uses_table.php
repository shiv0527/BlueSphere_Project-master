<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_uses', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('use_type');
            $table->string('leads');
            $table->string('leads_left');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('subscription_id');
            $table->timestamps();

            $table->foreign('subscription_id')->references('subscription_id')->on('subscription_details');
            $table->foreign('product_id')->references('product_id')->on('packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_uses');
    }
}
