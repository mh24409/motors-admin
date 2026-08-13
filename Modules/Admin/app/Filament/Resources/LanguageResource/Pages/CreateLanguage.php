<?php

namespace Modules\Admin\Filament\Resources\LanguageResource\Pages;

use Modules\Admin\Filament\Resources\LanguageResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Language;

class CreateLanguage extends CreateRecord
{
    protected static string $resource = LanguageResource::class;

    protected function afterCreate(): void
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
