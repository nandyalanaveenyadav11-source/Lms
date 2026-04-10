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
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('type')->default('video')->after('title'); // video, pdf
            $table->string('content_path')->nullable()->after('video_url'); // For uploaded PDFs
            $table->string('video_url')->nullable()->change(); // Make nullable for PDF lessons
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['type', 'content_path']);
            $table->string('video_url')->nullable(false)->change();
        });
    }
};
