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
                    <p class="text-md text-gray-600 dark:text-gray-300 max-w-xl mt-1">
                        This platform facilitates the collection and processing of internal data, presented on a public-facing page. Use the button to view the live preview.
                    </p>
                </div>
            </div>

            <x-filament::button 
                :href="route('dashboard')"
                tag="a"
                target="_blank"
                rel="noopener"
                size="lg"
                color="primary"
                icon="heroicon-m-eye"
            >
                View
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
