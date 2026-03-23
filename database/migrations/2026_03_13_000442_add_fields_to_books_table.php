<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('books', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
            }
            if (!Schema::hasColumn('books', 'status')) {
                $table->string('status')->default('pending')->after('author');
            }
            if (!Schema::hasColumn('books', 'cover_i')) {
                $table->string('cover_i')->nullable()->after('author');
            }
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'user_id')) {
                // Drop foreign key before dropping the column
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('books', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('books', 'cover_i')) {
                $table->dropColumn('cover_i');
            }
        });
    }
};

