<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('global_settings', function (Blueprint $table) {
            $table->id();

            // Non-translatable fields
            $table->string('favicon')->nullable();
            $table->string('header_logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();

            $table->timestamps();
        });

        Schema::create('global_setting_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('global_setting_id')
                ->constrained('global_settings')
                ->cascadeOnDelete();
            $table->foreignId('language_id')
                ->constrained('languages')
                ->cascadeOnDelete();

            // Translatable fields
            $table->string('site_name')->nullable();
            $table->text('site_description')->nullable();

            $table->timestamps();

            $table->unique(['global_setting_id', 'language_id'], 'gs_lang_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('global_setting_translations');
        Schema::dropIfExists('global_settings');
    }
};
