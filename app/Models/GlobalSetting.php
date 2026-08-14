<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class GlobalSetting extends Model
{
    use HasTranslations;

    protected $table = 'global_settings';

    protected $fillable = [
        'favicon',
        'header_logo',
        'footer_logo',
        'contact_email',
        'contact_phone',
        'facebook_url',
        'twitter_url',
        'instagram_url',
    ];

    /**
     * Fields that live in the translations table.
     */
    public array $translatable = [
        'site_name',
        'site_description',
    ];

    /**
     * Get or create the singleton settings row.
     */
    public static function instance(): static
    {
        return static::firstOrCreate([]);
    }
}
