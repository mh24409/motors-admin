<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('admin.widgets.system_overview') }}
        </x-slot>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            @foreach ($items as $item)
                <div class="flex items-center gap-3 rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg {{ $item['bg'] }}">
                        <x-filament::icon
                            :icon="$item['icon']"
                            class="h-5 w-5 {{ $item['color'] }}"
                        />
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-sm text-gray-500 dark:text-gray-400">
                            {{ $item['label'] }}
                        </p>
                        <p class="text-xl font-bold text-gray-950 dark:text-white">
                            {{ $item['value'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
