<div>
    <x-slot name="header">
        @include('includes.breadcrumb', [
            'main' => '',
            'menu' => 'Product Distribution',
        ])
    </x-slot>

    <div class="border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
            <li class="me-2">
                <a wire:click="$dispatch('switch_distribution_tab', {'name':'sales'})" name="sales"
                    class="cursor-pointer myTab inline-flex items-center justify-center p-4 border-b-2 {{ $actvtab == 'sales' ? 'text-blue-600 border-blue-600 font-bold' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }} rounded-t-lg group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                    </svg>
                    Sales
                </a>
            </li>
            {{-- <li class="me-2">
                <a wire:click="$dispatch('switch_distribution_tab', {'name':'remain'})" name="remain"
                    class="cursor-pointer myTab inline-flex items-center justify-center p-4 border-b-2 {{ $actvtab == 'remain' ? 'text-blue-600 border-blue-600 font-bold' : 'border-transparent hover:text-gray-600 hover:border-gray-300' }} rounded-t-lg group"
                    aria-current="page">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15m0-3-3-3m0 0-3 3m3-3V15" />
                    </svg>
                    Remains
                </a>
            </li> --}}
        </ul>
    </div>

    @if ($actvtab == 'sales')
        @livewire('pages.sale.components.sales.sales')
    @else
        {{-- @livewire('pages.sale.components.remain.remains') --}}
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
            var actv = localStorage.getItem('distribution_tab');
            console.log(actv);
            if (actv) {
                Livewire.dispatch('set_distribution_actvtab', {
                    'name': actv
                });
            }
            // store active tab
            $('.myTab').on('click', function() {
                localStorage.setItem("distribution_tab", $(this).attr('name'));
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
                        if (localStorage.getItem('distribution_tab') == 'remain') {
                            Livewire.dispatch('delete_distribution_remain', {
                                'id': id
                            });
                        } else {
                            Livewire.dispatch('delete_distribution_sales', {
                                'id': id
                            }); 
                        }
                    }
                });
            });

            Livewire.on('distribution_deleted', () => {
                Toast.fire({
                    icon: 'success',
                    title: 'Record deleted successfully!',
                });
            });

        });
    </script>

    {{-- sales modal component --}}
    <script data-navigate-once>
        $(document).on('change', '#sale_product_id', function(e) {
            console.log(e.target.value);
            @this.set('sale_product_id', e.target.value);
            Livewire.dispatch('set_sale_product_id', {
                'id': e.target.value
            });
        });

        document.addEventListener('livewire:init', () => {

            Livewire.on('reset_sale_product_id', (e) => {
                $('#sale_product_id').val('').trigger('change')
            });

            Livewire.on('update_sale_product_id_field', (data) => {
                $('#sale_product_id').val(data).trigger('change')
            });


            Livewire.on('reset_seller_id', (e) => {
                $('#seller_id').val('').trigger('change')
            });

            Livewire.on('update_seller_id_field', (data) => {
                $('#seller_id').val(data).trigger('change')
            });


            Livewire.on('reset_client_id', (e) => {
                $('#client_id').val('').trigger('change')
            });

            Livewire.on('update_client_id_field', (data) => {
                $('#client_id').val(data).trigger('change')
            });
        })

        $(document).on('change', '#seller_id', function(e) {
            console.log(e.target.value);
            @this.set('seller_id', e.target.value);
            Livewire.dispatch('set_seller_id', {
                'id': e.target.value
            });
        });

        $(document).on('change', '#client_id', function(e) {
            console.log(e.target.value);
            @this.set('client_id', e.target.value);
            Livewire.dispatch('set_client_id', {
                'id': e.target.value
            });
        });

        $(document).on('change', '#selling_type', function(e) {
            if($(this).val() == 'credit') {
                $('#creditdays').removeClass('hidden');
            } else {
                $('#creditdays').addClass('hidden');
                $('#credit_days').val('');
            }
        });
    </script>

    {{-- remain modal component --}}
    <script data-navigate-once>
        $(document).on('change', '#remain_product_id', function(e) {
            console.log(e.target.value);
            @this.set('remain_product_id', e.target.value);
            Livewire.dispatch('set_remain_product_id', {
                'id': e.target.value
            });
        });

        document.addEventListener('livewire:init', () => {

            Livewire.on('reset_remain_product_id', (e) => {
                $('#remain_product_id').val('').trigger('change')
            });

            Livewire.on('update_remain_product_id_field', (data) => {
                $('#remain_product_id').val(data).trigger('change')
            });
        })
    </script>
</div>