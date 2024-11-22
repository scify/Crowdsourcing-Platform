<?php

use Database\Helpers\ColumnTypeHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (Schema::hasColumn('solutions', 'user_creator_id')) {
            return;
        }


        // Check the data type of the users.id column
        $columnType = ColumnTypeHelper::getColumnType('users', 'id');

        Schema::table('solutions', function (Blueprint $table) use ($columnType) {
            if ($columnType === 'bigint') {
                $table->unsignedBigInteger('user_creator_id')->after('problem_id')->nullable(false);
            } else {
                $table->unsignedInteger('user_creator_id')->after('problem_id')->nullable(false);
            }
            $table->foreign('user_creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('solutions', function (Blueprint $table) {
            //
        });
    }
};
