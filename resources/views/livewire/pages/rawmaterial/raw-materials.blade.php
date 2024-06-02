<div>
    <x-slot name="header">
        @include('includes.breadcrumb', [
            'main' => '',
            'menu' => 'Raw Materials',
        ])
    </x-slot>


    <div class="border-b border-gray-200/50 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
            <li class="me-2">
                <a wire:click="$dispatch('switch_material_tab', {'name':'receive'})" name="receive"
                    class="cursor-pointer myTab inline-flex items-center justify-center p-4 border-b-2 {{ $actvtab == 'receive' ? 'text-blue-600 border-blue-600 font-bold' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }} rounded-t-lg group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                    </svg>
                    Receive
                </a>
            </li>
            <li class="me-2">
                <a wire:click="$dispatch('switch_material_tab', {'name':'dispatch'})" name="dispatch"
                    class="cursor-pointer myTab inline-flex items-center justify-center p-4 border-b-2 {{ $actvtab == 'dispatch' ? 'text-blue-600 border-blue-600 font-bold' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }} rounded-t-lg group"
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
        @livewire('pages.rawmaterial.components.receive.receive')
    @else
        @livewire('pages.rawmaterial.components.dispatch.dispatch')
    @endif

    @if (session()->has('alert'))
        <script>
            document.addEventListener('livewire:init', () => {
                Toast.fire({
                    icon: '{{ session('alert.type') }}',
                    title: '{{ session('alert.message') }}',
                });
            })
        </script>
    @endif
    <script data-navigate-once>
        $(document).ready(function() {
            var actv = localStorage.getItem('material_tab');
            console.log(actv);
            if (actv) {
                Livewire.dispatch('set_actvtab', {
                    'name': actv
                });
            }
            // store active tab
            $('.myTab').on('click', function() {
                localStorage.setItem("material_tab", $(this).attr('name'));
            });
        })
        document.addEventListener('livewire:init', () => {})
    </script>

    <script data-navigate-once>
        document.addEventListener('livewire:init', () => {
            // add
            Livewire.on('show_success', (message) => {
                Toast.fire({
                    icon: 'success',
                    title: message,
                });
            });

            // delete
            Livewire.on('confirm_delete', (id) => {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (localStorage.getItem('material_tab') == 'dispatch') {
                            Livewire.dispatch('delete_material_dispatch', {
                                'id': id
                            });
                        } else {
                            Livewire.dispatch('delete_material_receive', {
                                'id': id
                            });
                        }
                    }
                });
            });

            Livewire.on('material_deleted', () => {
                Toast.fire({
                    icon: 'success',
                    title: 'Record deleted successfully!',
                });
            });

        });
    </script>

    {{-- receive modal component --}}
    <script data-navigate-once>
        $(document).on('change', '#raw_material_id', function(e) {
            console.log(e.target.value);
            @this.set('raw_material_id', e.target.value);
            Livewire.dispatch('set_raw_material_id', {
                'id': e.target.value
            });
        });

        document.addEventListener('livewire:init', () => {

            Livewire.on('reset_raw_material_id', (e) => {
                $('#raw_material_id').val('').trigger('change')
            });

            Livewire.on('update_raw_material_id_field', (data) => {
                $('#raw_material_id').val(data).trigger('change')
            });
        })
    </script>

    {{-- dispatch modal component --}}
    <script data-navigate-once>
        $(document).on('change', '#dispatch_raw_material_id', function(e) {
            console.log(e.target.value);
            @this.set('raw_material_id', e.target.value);
            Livewire.dispatch('set_dispatch_raw_material_id', {
                'id': e.target.value
            });
        });

        document.addEventListener('livewire:init', () => {

            Livewire.on('reset_raw_material_id', (e) => {
                $('#dispatch_raw_material_id').val('').trigger('change')
            });

            Livewire.on('update_raw_material_id_field', (data) => {
                $('#dispatch_raw_material_id').val(data).trigger('change')
            });
        })
    </script>
</div>
