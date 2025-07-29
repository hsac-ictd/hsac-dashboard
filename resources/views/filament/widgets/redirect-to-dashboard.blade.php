<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            System Overview
        </x-slot>

        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <img
                    src="{{ asset('images/graph.png') }}"
                    alt="HSAC"
                    style="width: 6rem; height: 6rem;"
                />
                <div>
                    <h1 class="text-xl font-semibold">
                        Hello, {{ auth()->user()->name }}!
                    </h1>
                    <p class="text-md text-gray-600 dark:text-white max-w-xl mt-1">
                        This platform facilitates the collection and processing of internal data, presented on a public-facing page.
                    </p>
                </div>
            </div>

            <!-- Container for buttons and preview -->
            <div class="flex items-center gap-3" x-data="{ previewOpen: false }">
                <!-- Main View button as a link -->
                <x-filament::button 
                    :href="route('dashboard')"
                    tag="a"
                    target="_blank"
                    rel="noopener"
                    size="lg"
                    color="primary"
                    icon="heroicon-m-cursor-arrow-ripple"
                >
                    Redirect to Page
                </x-filament::button>

                <!-- Live Preview button to open modal -->
                <x-filament::button
                    type="button"
                    size="lg"
                    color="stone" 
                    icon="heroicon-m-eye"
                    @click="previewOpen = true"
                >
                    Live Preview
                </x-filament::button>


                <!-- Modal live preview overlay -->
                <div
                    x-show="previewOpen"
                    x-transition
                    @click="previewOpen = false"
                    class="fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center p-6"
                    style="backdrop-filter: blur(4px);"
                >
                    <div
                        @click.stop
                        class="relative bg-white dark:bg-gray-900 rounded-lg shadow-xl border border-gray-300 dark:border-gray-700"
                        style="max-width: 100vw; max-height: 90vh; width: 1250px; height: 720px; overflow: hidden;"
                    >
                        <iframe 
                            src="{{ route('dashboard') }}" 
                            class="w-full h-full border-0"
                            style="display: block;"
                        ></iframe>

                        <!-- Close button -->
                        <button
                            @click="previewOpen = false"
                            type="button"
                            class="absolute top-2 right-2 text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 text-3xl font-bold leading-none"
                            aria-label="Close preview"
                        >
                            &times;
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
