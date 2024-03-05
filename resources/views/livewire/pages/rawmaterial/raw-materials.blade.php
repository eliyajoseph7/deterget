<div>
    <x-slot name="header">
        @include('includes.breadcrumb', [
            'main' => '',
            'menu' => 'Raw Materials',
        ])
    </x-slot>


    <div class="border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
            <li class="me-2">
                <a wire:click="$dispatch('switch_material_tab', {'name':'receive'})"
                    class="cursor-pointer inline-flex items-center justify-center p-4 border-b-2 {{ $actvtab == 'receive' ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }} rounded-t-lg group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                    </svg>
                    Receive
                </a>
            </li>
            <li class="me-2">
                <a wire:click="$dispatch('switch_material_tab', {'name':'dispatch'})"
                    class="cursor-pointer inline-flex items-center justify-center p-4 border-b-2 {{ $actvtab == 'dispatch' ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }} rounded-t-lg group"
                    aria-current="page">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15m0-3-3-3m0 0-3 3m3-3V15" />
                    </svg>
                    Dispatch
                </a>
            </li>
        </ul>
    </div>

    @if ($actvtab == 'receive')
        @livewire('pages.rawmaterial.components.receive')
    @else
        @livewire('pages.rawmaterial.components.dispatch')
    @endif

    <script data-navigate-once>
        document.addEventListener('livewire:init', () => {
            var actv = localStorage.getItem('material_tab');
            if (actv) {
                Livewire.dispatch('set_actvtab', {
                    'name': actv
                });
            }

            // store active tab
            Livewire.on('switch_material_tab', (value) => {
                localStorage.setItem("material_tab", value.name);
            });
        })
    </script>

</div>
