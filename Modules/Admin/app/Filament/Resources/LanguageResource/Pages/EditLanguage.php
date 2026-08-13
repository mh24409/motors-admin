<?php

namespace Modules\Admin\Filament\Resources\LanguageResource\Pages;

use Modules\Admin\Filament\Resources\LanguageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Language;

class EditLanguage extends EditRecord
{
    protected static string $resource = LanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->hidden(fn () => $this->record->is_default),
        ];
    }

    protected function afterSave(): void
    {
        // If this language is set as default, unset others
        if ($this->record->is_default) {
            Language::where('id', '!=', $this->record->id)
                ->where('is_default', true)
                ->update(['is_default' => false]);

            // Default must be active
            $this->record->update(['is_active' => true]);
        }
    }
}
