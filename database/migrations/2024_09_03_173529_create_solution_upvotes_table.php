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
        if (! Schema::hasTable('solution_upvotes')) {
            $columnType = ColumnTypeHelper::getColumnType('users', 'id');
            Schema::create('solution_upvotes', function (Blueprint $table) use ($columnType) {
                $table->unsignedBigInteger('solution_id');
                $table->foreign('solution_id', 'solution_upvotes_solution_id_foreign')->references('id')->on('solutions');

                if ($columnType === 'bigint') {
                    $table->unsignedBigInteger('user_voter_id');
                } else {
                    $table->unsignedInteger('user_voter_id');
                }
                $table->foreign('user_voter_id', 'solution_upvotes_user_voter_id_foreign')->references('id')->on('users');

                $table->primary(['solution_id', 'user_voter_id'], 'solution_upvotes_primary');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('solution_upvotes');
    }
};
