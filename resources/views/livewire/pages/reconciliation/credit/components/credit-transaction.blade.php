<div>
    <form wire:submit.prevent="save(Object.fromEntries(new FormData($event.target)))">
        <div class="overflow-x-auto bg-white shadow-sm rounded-md">
            <div class="py-2 px-1 font-bold text-lg text-sky-900">Transactions</div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 dark:bg-gray-700">
                <thead class="text-xs text-gray-700 dark:text-gray-100 bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-4 py-3 w-[20px]">S/No.</th>
                        <th scope="col" class="px-4 py-3">Date</th>
                        <th scope="col" class="px-4 py-3">Client</th>
                        <th scope="col" class="px-4 py-3">Invoice No.</th>
                        <th scope="col" class="px-4 py-3">Amount</th>
                        <th scope="col" class="px-4 py-3">Pay Mode</th>
                        <th scope="col" class="px-4 py-3">Remained</th>
                        <th scope="col" class="px-4 py-3">Reconcile</th>

                    </tr>
                </thead>
                <tbody class="[&>*:nth-child(even)]:bg-[#F6F9FF] [&>*:nth-child(even)]:dark:bg-gray-600">
                    @forelse ($data as $dt)
                        <tr wire:key="{{ $dt->id }}" class="border-b border-gray-100 dark:border-gray-700">
                            <th scope="row"
                                class="px-4 py-3 w-[50px] font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->iteration }}</th>
                            <td class="px-4 py-3 whit espace-nowrap">
                                {{ $dt->date->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $dt->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $dt->invoiceno }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ number_format($dt->amount, 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $dt->paymode }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ number_format($dt->balance, 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap" wire:ignore>
                                <div class="flex space-x-2 items-center">
                                    @if ($dt->balance == 0)
                                        <input name="invoice"
                                            class="w-5 h-5 cursor-pointer text-blue-600 border-gray-300 rounded-xl focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                            type="checkbox" value="{{ $dt->invoiceno }}" id="{{ $dt->id }}">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 hover:text-red-500 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-gray-50">
                            <td class="py-2" colspan="50">
                                <div class="flex justify-center">There is nothing currently
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <tr class="">
                        <td colspan="3" class="px-4 py-2 font-bold">Total</td>
                        <td colspan="" class="px-4 py-2 font-bold text-right">TSHs.</td>
                        <td class="px-4 py-2 font-bold" id="cash_transaction">
                            {{ number_format($data->sum('amount'), 2) }}
                        </td>
                        <td colspan="3" class="px-4 py-2 font-bold"></td>
                    </tr>

                </tbody>
            </table>
        </div>
        <button type="submit" id="submit"></button>
    </form>

    <script data-navigate-once>
        document.addEventListener('livewire:init', () => {
            // add
            Livewire.on('submit_reconciliation', (message) => {
                $('#submit').click();
            });

        })
    </script>
</div>
