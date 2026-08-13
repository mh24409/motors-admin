<?php

namespace Modules\Admin\Filament\Resources;

use Modules\Admin\Filament\Resources\LanguageResource\Pages;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;
    protected static ?string $navigationIcon = 'heroicon-o-language';
    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.nav.settings');
    }

    public static function getModelLabel(): string
    {
        return __('admin.language.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.language.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.nav_labels.languages');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('admin.language.section_details'))
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label(__('admin.language.code'))
                            ->required()
                            ->maxLength(10)
                            ->unique(ignoreRecord: true)
                            ->placeholder(__('admin.language.code_placeholder'))
                            ->helperText(__('admin.language.code_helper')),
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.language.name'))
                            ->required()
                            ->maxLength(255)
                            ->placeholder(__('admin.language.name_placeholder')),
                        Forms\Components\TextInput::make('native_name')
                            ->label(__('admin.language.native_name'))
                            ->required()
                            ->maxLength(255)
                            ->placeholder(__('admin.language.native_name_placeholder')),
                        Forms\Components\Select::make('direction')
                            ->label(__('admin.language.direction'))
                            ->options([
                                'ltr' => __('admin.language.direction_ltr'),
                                'rtl' => __('admin.language.direction_rtl'),
                            ])
                            ->default('ltr')
                            ->required(),
                        Forms\Components\TextInput::make('flag')
                            ->label(__('admin.language.flag'))
                            ->maxLength(10)
                            ->placeholder(__('admin.language.flag_placeholder'))
                            ->helperText(__('admin.language.flag_helper')),
                        Forms\Components\TextInput::make('sort_order')
                            ->label(__('admin.fields.sort_order'))
                            ->numeric()
                            ->default(0),
                    ])->columns(2),

                Forms\Components\Section::make(__('admin.language.section_status'))
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('admin.language.active'))
                            ->default(false)
                            ->helperText(__('admin.language.active_helper')),
                        Forms\Components\Toggle::make('is_default')
                            ->label(__('admin.language.default'))
                            ->default(false)
                            ->helperText(__('admin.language.default_helper')),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('flag')
                    ->label('')
                    ->alignCenter()
                    ->width('40px'),
                Tables\Columns\TextColumn::make('code')
                    ->label(__('admin.language.code'))
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.language.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('native_name')
                    ->label(__('admin.language.native_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('direction')
                    ->label(__('admin.language.direction'))
                    ->badge()
                    ->color(fn (string $state): string => $state === 'rtl' ? 'warning' : 'info'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('admin.language.active'))
                    ->afterStateUpdated(function ($record, $state) {
                        if (!$state && $record->is_default) {
                            $record->update(['is_active' => true]);
                            Notification::make()
                                ->danger()
                                ->title(__('admin.language.cannot_deactivate_default'))
                                ->send();
                        }
                    }),
                Tables\Columns\IconColumn::make('is_default')
                    ->label(__('admin.language.default'))
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->trueColor('warning'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('admin.fields.sort_order'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('admin.language.active_status')),
                Tables\Filters\SelectFilter::make('direction')
                    ->label(__('admin.language.direction'))
                    ->options([
                        'ltr' => 'LTR',
                        'rtl' => 'RTL',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('setDefault')
                    ->label(__('admin.language.set_default'))
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->hidden(fn (Language $record) => $record->is_default)
                    ->action(function (Language $record) {
                        Language::where('is_default', true)->update(['is_default' => false]);
                        $record->update(['is_default' => true, 'is_active' => true]);
                        Notification::make()
                            ->success()
                            ->title(__('admin.language.default_set', ['name' => $record->name]))
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn (Language $record) => $record->is_default),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label(__('admin.language.activate_selected'))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label(__('admin.language.deactivate_selected'))
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if (!$record->is_default) {
                                    $record->update(['is_active' => false]);
                                }
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
