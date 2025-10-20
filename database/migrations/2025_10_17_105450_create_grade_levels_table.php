<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grade_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Primary 1", "JSS 1", "SSS 1"
            $table->string('level'); // "primary", "junior_secondary", "senior_secondary"
            $table->integer('order')->default(0); // for ordering
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grade_levels');
    }
};
