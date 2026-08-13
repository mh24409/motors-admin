<?php

namespace Modules\Admin\Http\Livewire;

use App\Models\Language;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $currentLocale;

    public function mount(): void
    {
        $this->currentLocale = session('locale', config('app.locale'));
    }

    public function switchLanguage(string $code): void
    {
        $language = Language::where('code', $code)->where('is_active', true)->first();

        if ($language) {
            session(['locale' => $language->code]);
            app()->setLocale($language->code);

            $this->currentLocale = $language->code;
            $this->dispatch('language-switched', code: $language->code);

            // Full page reload to apply locale everywhere
            $this->redirect(request()->header('Referer', '/admin'), navigate: true);
        }
    }

    public function render()
    {
        $languages = Language::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $current = $languages->firstWhere('code', $this->currentLocale)
            ?? $languages->first();

        return view('admin::livewire.language-switcher', [
            'languages' => $languages,
            'current' => $current,
        ]);
    }
}
