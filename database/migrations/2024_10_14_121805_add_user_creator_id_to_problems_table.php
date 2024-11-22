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
        if (Schema::hasColumn('problems', 'user_creator_id')) {
            return;
        }
        $columnType = ColumnTypeHelper::getColumnType('users', 'id');

        Schema::table('problems', function (Blueprint $table) use ($columnType) {
            if ($columnType === 'bigint') {
                $table->unsignedBigInteger('user_creator_id')->after('project_id')->nullable(true);
            } else {
                $table->unsignedInteger('user_creator_id')->after('project_id')->nullable(true);
            }
            $table->foreign('user_creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('problems', function (Blueprint $table) {});
    }
};
