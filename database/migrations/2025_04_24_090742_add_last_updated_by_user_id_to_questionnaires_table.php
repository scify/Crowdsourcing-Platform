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
        // Check the data type of the users.id column
        $columnType = ColumnTypeHelper::getColumnType('users', 'id');

        // If the column type is bigint, use unsignedBigInteger; otherwise, use unsignedInteger
        if ($columnType === 'bigint') {
            Schema::table('questionnaire_status_history', function (Blueprint $table) {
                $table->unsignedBigInteger('updated_by_user_id')->nullable()->after('status_id');
                $table->foreign('updated_by_user_id')->references('id')->on('users')->onDelete('cascade');
            });
        } else {
            Schema::table('questionnaire_status_history', function (Blueprint $table) {
                $table->unsignedInteger('updated_by_user_id')->nullable()->after('status_id');
                $table->foreign('updated_by_user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('questionnaire_status_history', function (Blueprint $table) {
            //
        });
    }
};
