<div>
    <x-slot name="header">
        @include('includes.breadcrumb', [
            'main' => '',
            'menu' => 'Cash Reconciliation',
        ])
    </x-slot>
    <div class="min-h-[80vh] dark:bg-gray-800 overflow-hidden sm:rounded-lg items-center w-full relative">
        @if ($loading)
            <div class="fixed top-1/3 md:left-1/3 md:right-1/3 z-30">
                <div class="w-72 mx-auto z-40">
                    <img src="{{ asset('assets/images/loader.gif') }}" alt="">
                </div>
            </div>
        @endif
        <div class=" border-t-2 border-gray-100 rounded-lg px-4 py-3 z-50">
            @if (Helper::has_permission('import-transactions'))
                <div class="flex justify-end items-center">
                    <div class="flex items-center justify-end d p-4 dark:bg-gray-700">
                        <button
                            wire:click="$dispatch('openModal', { component: 'pages.reconciliation.add-transaction' })"
                            class="flex text-sm items-center text-sky-500 bg-gray-100 hover:text-sky-700 rounded-lg px-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Add Transaction</span>
                        </button>
                    </div>
                    {{-- <div class="flex items-center justify-end d p-4 dark:bg-gray-700">
                        <button wire:click="$dispatch('openModal', { component: 'pages.reconciliation.import' })"
                            class="flex text-sm items-center text-green-500 bg-gray-50 hover:text-green-700 rounded-lg px-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                            </svg>

                            <span>Import</span>
                        </button>
                    </div> --}}
                </div>
            @endif
            <div class="grid md:grid-cols-2 gap-4">
                @livewire('pages.reconciliation.cash.components.day-sales')
                @livewire('pages.reconciliation.cash.components.day-transactions')
            </div>
            <div class="py-5 float-end">
                @if ($reconciled)
                @else
                    @if (Helper::has_role('reconcile-cash'))
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded-md flex space-x-3"
                            {{-- wire:click="$dispatch('mark_reconciliation_done')" --}} id="mark_done">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                            </svg>
                            Mark as done</button>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <script data-navigate-once>
        document.addEventListener('livewire:init', () => {
            // add
            Livewire.on('show_success', (message) => {
                Toast.fire({
                    icon: 'success',
                    title: message,
                });
            });
            Livewire.on('show_error', (message) => {
                ToastErr.fire({
                    icon: 'error',
                    title: message,
                });
            });
            // delete
            Livewire.on('confirm_delete', (invoiceno) => {
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
                        Livewire.dispatch('delete_transaction', {
                            'invoiceno': invoiceno
                        });

                    }
                });
            });

            Livewire.on('data_added', (message) => {
                Livewire.dispatch('data_imported');
            });

        })

        $('#mark_done').on('click', function() {
            var sale = $('#cash_sale').text().replaceAll(',', '')
            // console.log(sale);
            var transaction = $('#cash_transaction').text().replaceAll(',', '')
            // console.log(transaction);
            Livewire.dispatch('mark_reconciliation', {
                'total_sale': sale,
                'total_transaction': transaction
            })
        })
    </script>
    <script>
        $(document).on('change', '#invoiceno', function() {
            console.log($(this).val());

            Livewire.dispatch('set_invoiceno', {
                'invoiceno': $(this).val()
            });
        })
    </script>
</div>
