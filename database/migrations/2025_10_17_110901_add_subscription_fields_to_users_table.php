<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('school_name')->nullable()->after('phone');
            $table->string('school_type')->nullable()->after('school_name'); // public, private, federal, state
            $table->string('state')->nullable()->after('school_type');
            $table->string('lga')->nullable()->after('state'); // Local Government Area
            $table->boolean('is_active')->default(true)->after('role_id');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->timestamp('registered_at')->after('last_login_at');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'school_name',
                'school_type',
                'state',
                'lga',
                'is_active',
                'last_login_at',
                'registered_at'
            ]);
        });
    }
};
