<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultColorInLanguagesLkpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('languages_lkp', function (Blueprint $table) {
            $table->string('default_color')
                ->comment('default color for visualization purposes, eg statistic bar charts')
                ->after('language_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('languages_lkp', function (Blueprint $table) {
            $table->dropColumn('default_color');
        });
    }
}
