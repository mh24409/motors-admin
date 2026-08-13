<div class="relative" x-data="{ open: false }" @click.away="open = false">
    @if($current)
        <button @click="open = !open" type="button"
            class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-white/5">
            <span class="text-base">{{ $current->flag }}</span>
            <span class="hidden sm:inline">{{ $current->native_name }}</span>
            <svg class="h-4 w-4 transition" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd" />
            </svg>
        </button>

        <div x-show="open" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute end-0 z-50 mt-2 w-48 origin-top-end rounded-xl bg-white shadow-lg ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
            style="display: none;">
            <div class="p-1">
                @foreach($languages as $language)
                    <button wire:click="switchLanguage('{{ $language->code }}')" @click="open = false" class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm transition
                                    {{ $language->code === $currentLocale
                    ? 'bg-primary-50 text-primary-600 dark:bg-primary-400/10 dark:text-primary-400'
                    : 'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-white/5' }}">
                        <span class="text-base">{{ $language->flag }}</span>
                        <span class="flex-1 text-start">{{ $language->native_name }}</span>
                        @if($language->code === $currentLocale)
                            <svg class="h-4 w-4 text-primary-600 dark:text-primary-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                       
                    </button>
                @endforeach
            </div>
        </div>
    @endif
</div>