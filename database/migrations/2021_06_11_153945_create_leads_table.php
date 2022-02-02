<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('lead_name');
            $table->string('lead_last_name');
            $table->string('lead_email')->nullable();
            $table->text('lead_description');
            $table->string('lead_company_name');
            $table->string('lead_number')->nullable();
            $table->text('lead_notes')->nullable();
            $table->string('lead_status')->nullable();
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
        Schema::dropIfExists('leads');
    }
}
