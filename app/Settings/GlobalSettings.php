<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GlobalSettings extends Settings
{
    public array $site_name;
    public ?array $site_description;
    public ?string $favicon;
    public ?string $header_logo;
    public ?string $footer_logo;
    public ?string $contact_email;
    public ?string $contact_phone;
    public ?string $facebook_url;
    public ?string $twitter_url;
    public ?string $instagram_url;

    public static function group(): string
    {
        return 'global';
    }

    /**
     * Get a translated setting value based on the current app locale.
     */
    public function getTranslated(string $property): ?string
    {
        $value = $this->{$property};
        
        if (!is_array($value)) {
            return $value;
        }
        
        $locale = app()->getLocale();
        return $value[$locale] ?? $value['en'] ?? null;
    }
}
