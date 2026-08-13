<?php

namespace Modules\Admin\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Filament\Resources\UserResource\Pages;
use Modules\Api\Models\User;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): ?string
    {
        return __('admin.nav.user_management');
    }

    public static function getModelLabel(): string
    {
        return __('admin.user.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.user.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.nav_labels.users');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('admin.user.section_info'))
                    ->description(__('admin.user.section_info_desc'))
                    ->icon('heroicon-o-user')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->placeholder(__('admin.user.placeholder_name')),

                        Forms\Components\TextInput::make('email')
                            ->label(__('admin.fields.email'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder(__('admin.user.placeholder_email')),

                        Forms\Components\TextInput::make('phone')
                            ->label(__('admin.fields.phone'))
                            ->tel()
                            ->maxLength(20)
                            ->placeholder(__('admin.user.placeholder_phone')),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('admin.fields.is_active'))
                            ->default(true)
                            ->helperText(__('admin.user.helper_inactive')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('admin.user.section_security'))
                    ->description(__('admin.user.section_security_desc'))
                    ->icon('heroicon-o-lock-closed')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label(__('admin.fields.password'))
                            ->password()
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->minLength(8)
                            ->maxLength(255)
                            ->confirmed()
                            ->placeholder(__('admin.user.placeholder_password')),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label(__('admin.fields.password_confirmation'))
                            ->password()
                            ->requiredWith('password')
                            ->dehydrated(false)
                            ->placeholder(__('admin.user.placeholder_password_confirm')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('admin.fields.id'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.fields.name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('admin.fields.email'))
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage(__('admin.user.email_copied')),

                Tables\Columns\TextColumn::make('phone')
                    ->label(__('admin.fields.phone'))
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('admin.fields.status'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label(__('admin.fields.verified'))
                    ->dateTime('M d, Y')
                    ->placeholder(__('admin.user.not_verified'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.fields.registered'))
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('admin.fields.updated_at'))
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->label(__('admin.user.filter_status'))
                    ->options([
                        '1' => __('admin.user.filter_active'),
                        '0' => __('admin.user.filter_inactive'),
                    ]),

                Tables\Filters\Filter::make('verified')
                    ->label(__('admin.user.filter_verified'))
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),

                Tables\Filters\Filter::make('unverified')
                    ->label(__('admin.user.filter_unverified'))
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\Action::make('toggleActive')
                        ->label(fn (User $record): string => $record->is_active ? __('admin.user.deactivate') : __('admin.user.activate'))
                        ->icon(fn (User $record): string => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn (User $record): string => $record->is_active ? 'danger' : 'success')
                        ->requiresConfirmation()
                        ->action(function (User $record): void {
                            $record->update(['is_active' => !$record->is_active]);

                            Notification::make()
                                ->title($record->is_active ? __('admin.user.user_activated') : __('admin.user.user_deactivated'))
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('activate')
                        ->label(__('admin.user.activate_selected'))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label(__('admin.user.deactivate_selected'))
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone'];
    }
}
