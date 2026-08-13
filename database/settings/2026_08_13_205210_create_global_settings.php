<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('global.site_name', ['en' => 'Motors Admin', 'ar' => 'موتورز ادمن']);
        $this->migrator->add('global.site_description', ['en' => 'Admin panel for Motors application', 'ar' => 'لوحة تحكم تطبيق موتورز']);
        $this->migrator->add('global.favicon', null);
        $this->migrator->add('global.header_logo', null);
        $this->migrator->add('global.footer_logo', null);
        $this->migrator->add('global.contact_email', 'admin@example.com');
        $this->migrator->add('global.contact_phone', null);
        $this->migrator->add('global.facebook_url', null);
        $this->migrator->add('global.twitter_url', null);
        $this->migrator->add('global.instagram_url', null);
    }
};
