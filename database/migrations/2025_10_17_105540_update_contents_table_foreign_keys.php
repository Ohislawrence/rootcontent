<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            // Remove old columns
            $table->dropColumn(['grade_level', 'subject']);

            // Add foreign keys
            $table->foreignId('grade_level_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropForeign(['grade_level_id']);
            $table->dropForeign(['subject_id']);
            $table->dropColumn(['grade_level_id', 'subject_id']);

            // Add back old columns
            $table->string('grade_level');
            $table->string('subject');
        });
    }
};
