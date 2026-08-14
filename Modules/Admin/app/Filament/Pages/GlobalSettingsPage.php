<?php

namespace Modules\Admin\Filament\Pages;

use App\Models\GlobalSetting;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class GlobalSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?int $navigationSort = 11;

    protected static string $view = 'admin::filament.pages.global-settings';

    public ?array $data = [];

    public static function getNavigationGroup(): ?string
    {
        return __('admin.nav.settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.nav_labels.global_settings');
    }

    public function getTitle(): string
    {
        return __('admin.nav_labels.global_settings');
    }

    public function mount(): void
    {
        $setting = GlobalSetting::instance();
        $languages = Language::active()->ordered()->get();

        $data = $setting->only($setting->getFillable());

        // Load translations keyed by language code
        foreach ($languages as $language) {
            $translation = $setting->translations()
                ->where('language_id', $language->id)
                ->first();

            foreach ($setting->translatable as $field) {
                $data["translations_{$language->code}_{$field}"] = $translation?->{$field};
            }
        }

        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        $languages = Language::active()->ordered()->get();

        // Build language tabs for translatable fields
        $languageTabs = [];
        foreach ($languages as $language) {
            $label = trim("{$language->flag} {$language->native_name}");
            $code = $language->code;

            $languageTabs[] = Forms\Components\Tabs\Tab::make($label)
                ->icon('heroicon-m-language')
                ->schema([
                    Forms\Components\TextInput::make("translations_{$code}_site_name")
                        ->label(__('admin.settings.site_name') . " ({$code})")
                        ->required($language->is_default),
                    Forms\Components\Textarea::make("translations_{$code}_site_description")
                        ->label(__('admin.settings.site_description') . " ({$code})")
                        ->rows(3),
                ]);
        }

        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make(__('admin.settings.general'))
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Tabs::make('Translations')
                                    ->tabs($languageTabs),
                            ]),
                        Forms\Components\Tabs\Tab::make(__('admin.settings.branding'))
                            ->icon('heroicon-o-paint-brush')
                            ->schema([
                                Forms\Components\FileUpload::make('favicon')
                                    ->label(__('admin.settings.favicon'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('settings'),
                                Forms\Components\FileUpload::make('header_logo')
                                    ->label(__('admin.settings.header_logo'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('settings'),
                                Forms\Components\FileUpload::make('footer_logo')
                                    ->label(__('admin.settings.footer_logo'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('settings'),
                            ]),
                        Forms\Components\Tabs\Tab::make(__('admin.settings.contact_social'))
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('contact_email')
                                            ->label(__('admin.settings.contact_email'))
                                            ->email(),
                                        Forms\Components\TextInput::make('contact_phone')
                                            ->label(__('admin.settings.contact_phone'))
                                            ->tel(),
                                        Forms\Components\TextInput::make('facebook_url')
                                            ->label(__('admin.settings.facebook_url'))
                                            ->url(),
                                        Forms\Components\TextInput::make('twitter_url')
                                            ->label(__('admin.settings.twitter_url'))
                                            ->url(),
                                        Forms\Components\TextInput::make('instagram_url')
                                            ->label(__('admin.settings.instagram_url'))
                                            ->url(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $setting = GlobalSetting::instance();
        $languages = Language::active()->ordered()->get();

        // Save non-translatable fields
        $setting->update([
            'favicon' => $data['favicon'] ?? null,
            'header_logo' => $data['header_logo'] ?? null,
            'footer_logo' => $data['footer_logo'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'contact_phone' => $data['contact_phone'] ?? null,
            'facebook_url' => $data['facebook_url'] ?? null,
            'twitter_url' => $data['twitter_url'] ?? null,
            'instagram_url' => $data['instagram_url'] ?? null,
        ]);

        // Save translations per language
        foreach ($languages as $language) {
            $translationData = [];
            foreach ($setting->translatable as $field) {
                $key = "translations_{$language->code}_{$field}";
                $translationData[$field] = $data[$key] ?? null;
            }

            $setting->setTranslation($language->id, $translationData);
        }

        // Re-fill form with persisted data so file previews resolve
        $this->mount();

        Notification::make()
            ->title(__('admin.settings.saved'))
            ->success()
            ->send();
    }
}
