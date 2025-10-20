<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->text('description')->nullable()->after('price');
            $table->json('features')->nullable()->after('description');
            $table->boolean('is_active')->default(true)->after('features');
            $table->boolean('is_default')->default(false)->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['description', 'features', 'is_active', 'is_default']);
        });
    }
};
