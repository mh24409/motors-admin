<?php

namespace App\Traits;

use App\Models\Language;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Adds isolated translation table support to any Eloquent model.
 *
 * Convention:
 *   Model:       App\Models\GlobalSetting
 *   Translation: App\Models\GlobalSettingTranslation
 *   Table:       global_setting_translations
 *   FK:          global_setting_id
 *
 * Usage in model:
 *   use HasTranslations;
 *
 *   // Override if your translation model lives elsewhere:
 *   protected string $translationModel = MyCustomTranslation::class;
 *
 *   // Define which fields are translatable (used by helpers):
 *   public array $translatable = ['name', 'description'];
 */
trait HasTranslations
{
    /**
     * All translations for this model.
     */
    public function translations(): HasMany
    {
        return $this->hasMany($this->getTranslationModelClass());
    }

    /**
     * Single translation for a specific language.
     */
    public function translationFor(string|int $languageOrCode): HasOne
    {
        $languageId = $this->resolveLanguageId($languageOrCode);

        return $this->hasOne($this->getTranslationModelClass())
            ->where('language_id', $languageId);
    }

    /**
     * Get a single translated field value.
     * Falls back to default language if not found.
     */
    public function getTranslation(string $field, ?string $locale = null, ?string $fallbackLocale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $fallbackLocale = $fallbackLocale ?? Language::getDefault()?->code ?? 'en';

        $language = Language::where('code', $locale)->first();

        if ($language) {
            $translation = $this->translations
                ->where('language_id', $language->id)
                ->first();

            if ($translation && !is_null($translation->{$field})) {
                return $translation->{$field};
            }
        }

        // Fallback
        if ($fallbackLocale && $fallbackLocale !== $locale) {
            return $this->getTranslation($field, $fallbackLocale, null);
        }

        return null;
    }

    /**
     * Set translation values for a given language.
     *
     * @param string|int $languageOrCode  Language code ('en') or language ID
     * @param array      $values          ['field' => 'value', ...]
     */
    public function setTranslation(string|int $languageOrCode, array $values): void
    {
        $languageId = $this->resolveLanguageId($languageOrCode);

        $this->translations()->updateOrCreate(
            ['language_id' => $languageId],
            $values,
        );
    }

    /**
     * Get all translations as array keyed by language code.
     *
     * Returns: ['en' => ['name' => '...'], 'ar' => ['name' => '...']]
     */
    public function getTranslationsArray(): array
    {
        $result = [];

        $this->translations()->with('language')->get()->each(function ($translation) use (&$result) {
            $code = $translation->language->code;
            $translatable = $this->translatable ?? [];

            $values = [];
            foreach ($translatable as $field) {
                $values[$field] = $translation->{$field};
            }

            $result[$code] = $values;
        });

        return $result;
    }

    /**
     * Resolve language code or ID to language ID.
     */
    protected function resolveLanguageId(string|int $languageOrCode): int
    {
        if (is_numeric($languageOrCode)) {
            return (int) $languageOrCode;
        }

        return Language::where('code', $languageOrCode)->value('id')
            ?? throw new \InvalidArgumentException("Language '{$languageOrCode}' not found.");
    }

    /**
     * Get translation model class. Override via $translationModel property.
     */
    protected function getTranslationModelClass(): string
    {
        return $this->translationModel ?? get_class($this) . 'Translation';
    }
}
