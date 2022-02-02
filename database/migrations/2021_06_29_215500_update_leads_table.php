<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('leads', function (Blueprint $table) {
            $table->text('lead_description')->nullable()->change();
            $table->string('lead_company_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('leads', function (Blueprint $table) {
            $table->text('lead_description')->nullable()->change();
            $table->string('lead_company_name')->nullable()->change();
        });
    }
}
