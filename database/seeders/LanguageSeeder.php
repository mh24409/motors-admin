<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            ['code' => 'en',    'name' => 'English',              'native_name' => 'English',             'direction' => 'ltr', 'flag' => '🇺🇸', 'is_active' => true,  'is_default' => true,  'sort_order' => 1],
            ['code' => 'ar',    'name' => 'Arabic',               'native_name' => 'العربية',             'direction' => 'rtl', 'flag' => '🇸🇦', 'is_active' => true,  'is_default' => false, 'sort_order' => 2],
            ['code' => 'fr',    'name' => 'French',               'native_name' => 'Français',            'direction' => 'ltr', 'flag' => '🇫🇷', 'is_active' => false, 'is_default' => false, 'sort_order' => 3],
            ['code' => 'es',    'name' => 'Spanish',              'native_name' => 'Español',             'direction' => 'ltr', 'flag' => '🇪🇸', 'is_active' => false, 'is_default' => false, 'sort_order' => 4],
            ['code' => 'de',    'name' => 'German',               'native_name' => 'Deutsch',             'direction' => 'ltr', 'flag' => '🇩🇪', 'is_active' => false, 'is_default' => false, 'sort_order' => 5],
            ['code' => 'it',    'name' => 'Italian',              'native_name' => 'Italiano',            'direction' => 'ltr', 'flag' => '🇮🇹', 'is_active' => false, 'is_default' => false, 'sort_order' => 6],
            ['code' => 'pt',    'name' => 'Portuguese',           'native_name' => 'Português',           'direction' => 'ltr', 'flag' => '🇧🇷', 'is_active' => false, 'is_default' => false, 'sort_order' => 7],
            ['code' => 'ru',    'name' => 'Russian',              'native_name' => 'Русский',             'direction' => 'ltr', 'flag' => '🇷🇺', 'is_active' => false, 'is_default' => false, 'sort_order' => 8],
            ['code' => 'zh',    'name' => 'Chinese',              'native_name' => '中文',                'direction' => 'ltr', 'flag' => '🇨🇳', 'is_active' => false, 'is_default' => false, 'sort_order' => 9],
            ['code' => 'ja',    'name' => 'Japanese',             'native_name' => '日本語',              'direction' => 'ltr', 'flag' => '🇯🇵', 'is_active' => false, 'is_default' => false, 'sort_order' => 10],
            ['code' => 'ko',    'name' => 'Korean',               'native_name' => '한국어',              'direction' => 'ltr', 'flag' => '🇰🇷', 'is_active' => false, 'is_default' => false, 'sort_order' => 11],
            ['code' => 'hi',    'name' => 'Hindi',                'native_name' => 'हिन्दी',               'direction' => 'ltr', 'flag' => '🇮🇳', 'is_active' => false, 'is_default' => false, 'sort_order' => 12],
            ['code' => 'tr',    'name' => 'Turkish',              'native_name' => 'Türkçe',              'direction' => 'ltr', 'flag' => '🇹🇷', 'is_active' => false, 'is_default' => false, 'sort_order' => 13],
            ['code' => 'nl',    'name' => 'Dutch',                'native_name' => 'Nederlands',          'direction' => 'ltr', 'flag' => '🇳🇱', 'is_active' => false, 'is_default' => false, 'sort_order' => 14],
            ['code' => 'pl',    'name' => 'Polish',               'native_name' => 'Polski',              'direction' => 'ltr', 'flag' => '🇵🇱', 'is_active' => false, 'is_default' => false, 'sort_order' => 15],
            ['code' => 'sv',    'name' => 'Swedish',              'native_name' => 'Svenska',             'direction' => 'ltr', 'flag' => '🇸🇪', 'is_active' => false, 'is_default' => false, 'sort_order' => 16],
            ['code' => 'th',    'name' => 'Thai',                 'native_name' => 'ไทย',                 'direction' => 'ltr', 'flag' => '🇹🇭', 'is_active' => false, 'is_default' => false, 'sort_order' => 17],
            ['code' => 'vi',    'name' => 'Vietnamese',           'native_name' => 'Tiếng Việt',          'direction' => 'ltr', 'flag' => '🇻🇳', 'is_active' => false, 'is_default' => false, 'sort_order' => 18],
            ['code' => 'id',    'name' => 'Indonesian',           'native_name' => 'Bahasa Indonesia',    'direction' => 'ltr', 'flag' => '🇮🇩', 'is_active' => false, 'is_default' => false, 'sort_order' => 19],
            ['code' => 'ms',    'name' => 'Malay',                'native_name' => 'Bahasa Melayu',       'direction' => 'ltr', 'flag' => '🇲🇾', 'is_active' => false, 'is_default' => false, 'sort_order' => 20],
            ['code' => 'uk',    'name' => 'Ukrainian',            'native_name' => 'Українська',          'direction' => 'ltr', 'flag' => '🇺🇦', 'is_active' => false, 'is_default' => false, 'sort_order' => 21],
            ['code' => 'he',    'name' => 'Hebrew',               'native_name' => 'עברית',               'direction' => 'rtl', 'flag' => '🇮🇱', 'is_active' => false, 'is_default' => false, 'sort_order' => 22],
            ['code' => 'fa',    'name' => 'Persian',              'native_name' => 'فارسی',               'direction' => 'rtl', 'flag' => '🇮🇷', 'is_active' => false, 'is_default' => false, 'sort_order' => 23],
            ['code' => 'ur',    'name' => 'Urdu',                 'native_name' => 'اردو',                'direction' => 'rtl', 'flag' => '🇵🇰', 'is_active' => false, 'is_default' => false, 'sort_order' => 24],
            ['code' => 'bn',    'name' => 'Bengali',              'native_name' => 'বাংলা',               'direction' => 'ltr', 'flag' => '🇧🇩', 'is_active' => false, 'is_default' => false, 'sort_order' => 25],
            ['code' => 'el',    'name' => 'Greek',                'native_name' => 'Ελληνικά',            'direction' => 'ltr', 'flag' => '🇬🇷', 'is_active' => false, 'is_default' => false, 'sort_order' => 26],
            ['code' => 'cs',    'name' => 'Czech',                'native_name' => 'Čeština',             'direction' => 'ltr', 'flag' => '🇨🇿', 'is_active' => false, 'is_default' => false, 'sort_order' => 27],
            ['code' => 'ro',    'name' => 'Romanian',             'native_name' => 'Română',              'direction' => 'ltr', 'flag' => '🇷🇴', 'is_active' => false, 'is_default' => false, 'sort_order' => 28],
            ['code' => 'hu',    'name' => 'Hungarian',            'native_name' => 'Magyar',              'direction' => 'ltr', 'flag' => '🇭🇺', 'is_active' => false, 'is_default' => false, 'sort_order' => 29],
            ['code' => 'da',    'name' => 'Danish',               'native_name' => 'Dansk',               'direction' => 'ltr', 'flag' => '🇩🇰', 'is_active' => false, 'is_default' => false, 'sort_order' => 30],
            ['code' => 'fi',    'name' => 'Finnish',              'native_name' => 'Suomi',               'direction' => 'ltr', 'flag' => '🇫🇮', 'is_active' => false, 'is_default' => false, 'sort_order' => 31],
            ['code' => 'no',    'name' => 'Norwegian',            'native_name' => 'Norsk',               'direction' => 'ltr', 'flag' => '🇳🇴', 'is_active' => false, 'is_default' => false, 'sort_order' => 32],
            ['code' => 'fil',   'name' => 'Filipino',             'native_name' => 'Filipino',            'direction' => 'ltr', 'flag' => '🇵🇭', 'is_active' => false, 'is_default' => false, 'sort_order' => 33],
            ['code' => 'sw',    'name' => 'Swahili',              'native_name' => 'Kiswahili',           'direction' => 'ltr', 'flag' => '🇰🇪', 'is_active' => false, 'is_default' => false, 'sort_order' => 34],
            ['code' => 'ku',    'name' => 'Kurdish',              'native_name' => 'کوردی',               'direction' => 'rtl', 'flag' => '🏳️', 'is_active' => false, 'is_default' => false, 'sort_order' => 35],
        ];

        foreach ($languages as $lang) {
            Language::updateOrCreate(
                ['code' => $lang['code']],
                $lang
            );
        }
    }
}
