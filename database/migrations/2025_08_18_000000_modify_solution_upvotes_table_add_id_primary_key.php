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
        // Since the table only has 1 row, it's safer to drop and recreate
        Schema::dropIfExists('solution_upvotes');
        $columnType = ColumnTypeHelper::getColumnType('users', 'id');
        Schema::create('solution_upvotes', function (Blueprint $table) use ($columnType) {
            $table->id();
            $table->unsignedBigInteger('solution_id');
            $table->foreign('solution_id', 'solution_upvotes_solution_id_foreign')->references('id')->on('solutions');

            if ($columnType === 'bigint') {
                $table->unsignedBigInteger('user_voter_id');
            } else {
                $table->unsignedInteger('user_voter_id');
            }

            $table->timestamps();

            $table->foreign('user_voter_id', 'solution_upvotes_user_voter_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('solution_upvotes');

        // Recreate the original table structure
        Schema::create('solution_upvotes', function (Blueprint $table) {
            $table->unsignedBigInteger('solution_id');
            $table->unsignedBigInteger('user_voter_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('solution_id')->references('id')->on('solutions')->onDelete('cascade');
            $table->foreign('user_voter_id')->references('id')->on('users')->onDelete('cascade');

            // Composite primary key (original structure)
            $table->primary(['solution_id', 'user_voter_id']);
        });
    }
};
