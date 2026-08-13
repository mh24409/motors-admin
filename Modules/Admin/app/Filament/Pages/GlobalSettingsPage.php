<?php

namespace Modules\Admin\Filament\Pages;

use App\Settings\GlobalSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class GlobalSettingsPage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GlobalSettings::class;

    protected static ?int $navigationSort = 11;

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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make(__('admin.settings.general'))
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Tabs::make('Translations')
                                    ->tabs([
                                        Forms\Components\Tabs\Tab::make('English')
                                            ->icon('heroicon-m-language')
                                            ->schema([
                                                Forms\Components\TextInput::make('site_name.en')
                                                    ->label(__('admin.settings.site_name') . ' (EN)')
                                                    ->required(),
                                                Forms\Components\Textarea::make('site_description.en')
                                                    ->label(__('admin.settings.site_description') . ' (EN)')
                                                    ->rows(3),
                                            ]),
                                        Forms\Components\Tabs\Tab::make('العربية')
                                            ->icon('heroicon-m-language')
                                            ->schema([
                                                Forms\Components\TextInput::make('site_name.ar')
                                                    ->label(__('admin.settings.site_name') . ' (AR)')
                                                    ->required(),
                                                Forms\Components\Textarea::make('site_description.ar')
                                                    ->label(__('admin.settings.site_description') . ' (AR)')
                                                    ->rows(3),
                                            ]),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make(__('admin.settings.branding'))
                            ->icon('heroicon-o-paint-brush')
                            ->schema([
                                Forms\Components\FileUpload::make('favicon')
                                    ->label(__('admin.settings.favicon'))
                                    ->image()
                                    ->directory('settings'),
                                Forms\Components\FileUpload::make('header_logo')
                                    ->label(__('admin.settings.header_logo'))
                                    ->image()
                                    ->directory('settings'),
                                Forms\Components\FileUpload::make('footer_logo')
                                    ->label(__('admin.settings.footer_logo'))
                                    ->image()
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
            ]);
    }
}
