<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('beds', function (Blueprint $table) {
            // Drop the old foreign key constraint
            $table->dropForeign(['student_id']);

            // Add the new foreign key constraint to the students table
            $table->foreign('student_id')
                  ->references('id')->on('students')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beds', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['student_id']);

            // Add the old foreign key constraint back to the users table
            $table->foreign('student_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }
};
