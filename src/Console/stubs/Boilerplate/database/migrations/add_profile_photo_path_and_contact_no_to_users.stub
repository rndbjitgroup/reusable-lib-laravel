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
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact_no')->after('email_verified_at')->nullable();
            $table->string('profile_photo_path', 2048)->after('remember_token')->nullable();
            $table->softDeletes()->after('updated_at');
            $table->dropUnique('users_email_unique');
            $table->unique(['email', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('contact_no');
            $table->dropColumn('profile_photo_path');
            $table->dropColumn('deleted_at');
            $table->dropUnique(['email', 'deleted_at']);
            $table->unique('email');
        });
    }
};
