<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            // nullable: o currículo de demonstração não pertence a ninguém
            $table->foreignId('user_id')->nullable()->after('id')
                ->constrained()->nullOnDelete();
            $table->string('photo_path')->nullable()->after('template');
        });
    }

    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('photo_path');
        });
    }
};
