<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class MakeListIdNullableInMailChimpList extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('mailchimp_lists', function ($table) {
            $table->string('list_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('mailchimp_lists', function ($table) {
            $table->string('list_id')->nullable(false)->change();
        });
    }
}
