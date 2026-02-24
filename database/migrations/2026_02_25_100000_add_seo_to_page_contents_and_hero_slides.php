<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->string('title', 255)->nullable()->after('content');
            $table->string('meta_description', 500)->nullable()->after('title');
            $table->string('meta_keywords', 500)->nullable()->after('meta_description');
            $table->string('og_title', 255)->nullable()->after('meta_keywords');
            $table->string('og_description', 500)->nullable()->after('og_title');
            $table->string('og_image', 500)->nullable()->after('og_description');
        });

        Schema::table('hero_slides', function (Blueprint $table) {
            $table->string('alt_text', 255)->nullable()->after('image');
            $table->string('caption', 500)->nullable()->after('alt_text');
        });
    }

    public function down(): void
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->dropColumn([
                'title', 'meta_description', 'meta_keywords',
                'og_title', 'og_description', 'og_image',
            ]);
        });
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->dropColumn(['alt_text', 'caption']);
        });
    }
};
