
<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>

    <div x-data="{
        state: $wire.entangle('{{ $getStatePath() }}'),
        isOpen: false,
        selectedTab: 'library',
    }">
        <x-filament::button x-on:click="isOpen = !isOpen">
            Open
        </x-filament::button>

        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="isOpen"
             x-on:keydown.window.escape="isOpen = false">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                 x-on:click="isOpen = false"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"></div>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-full p-4 text-center sm:p-0 mx-4">
                    <div x-show="isOpen"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="relative bg-white rounded-xl w-full mx-auto max-w-4xl p-2 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 dark:bg-gray-800">

                        <div class="px-4 py-2 filament-modal-header">
                            <h2 class="text-xl font-bold tracking-tight filament-modal-heading">
                                Aanmaken
                            </h2>
                        </div>
                        <div aria-hidden="true" class="border-t filament-hr dark:border-gray-700"></div>
                        <div class="space-y-2 filament-modal-content">
                            <div class="px-4 py-2 space-y-4">
                                <div class="border-b border-gray-200 dark:border-gray-700">
                                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                        <a x-on:click="selectedTab = 'library'" :class="selectedTab === 'library' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 dark:text-gray-200 dark:hover:text-gray-300 hover:text-gray-700 hover:border-gray-600'"
                                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer	">
                                            Media bibliotheek
                                        </a>

                                        <a x-on:click="selectedTab = 'upload'" :class="selectedTab === 'upload' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 dark:text-gray-200 dark:hover:text-gray-300 hover:text-gray-700 hover:border-gray-600'"
                                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer	">
                                            Media uploaden
                                        </a>
                                    </nav>
                                </div>
                            </div>

                            <ul x-show="selectedTab === 'library'" class="grid grid-cols-3 gap-4 sm:grid-cols-4 md:grid-cols-6 2xl:grid-cols-8 px-4">
                                <li
                                    class="relative aspect-square">
                                    <button type="button"
                                            class="block w-full h-full overflow-hidden bg-gray-700 rounded-sm">
                                        <img src="https://via.placeholder.com/640x480.png/00dd00?text=ut"
                                             width="300"
                                             height="300"
                                             class="block w-full h-full checkered" />
                                    </button>
                                    <button
                                            style="display: none;"
                                            class="absolute inset-0 flex items-center justify-center w-full h-full rounded shadow text-primary-600 bg-primary-500/20 ring-2 ring-primary-500">
                                        <div
                                            class="flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary-500 drop-shadow">
                                            <x-heroicon-s-check class="w-5 h-5" />
                                        </div>
                                        <span class="sr-only">{{ __('Deselect') }}</span>
                                    </button>
                                </li>

                            </ul>
                            <div x-show="selectedTab === 'upload'" class="px-4">
                                @livewire('media-picker.upload-media')
                            </div>
                        </div>
                        <div aria-hidden="true" class="border-t filament-hr dark:border-gray-700"></div>
                        <div class="px-4 py-2 filament-modal-footer">
                            <div class="filament-modal-actions flex flex-wrap items-center gap-4 rtl:space-x-reverse">
                                <x-filament::button :outlined="true" :color="'secondary'" x-on:click="isOpen = false">
                                    Annuleren
                                </x-filament::button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Interact with the `state` property in Alpine.js -->
    </div>
</x-forms::field-wrapper>
