<div>
    <x-slot name="header">
        @include('includes.breadcrumb', [
            'main' => 'Reports',
            'menu' => 'Debtors Report',
        ])
    </x-slot>

    <div>
        <div class="py-0">
            <div class="max-w-full mx-auto sm:px-6 lg:px-0">
                <div class="w-full">
                    <div class="flex flex-col-reverse md:flex-row md:space-x-3">
                        <div
                            class="min-h-[20vh] dark:bg-gray-800 overflow-hidden sm:rounded-lg items-center w-full float-right">

                            <div class="bg-white shadow-lg border-t-2 border-gray-100 rounded-lg px-2 py-3">
                                <div class="flex items-center justify-between d p-4 dark:bg-gray-700">
                                    <div class="flex">
                                        <div class="relative w-full">
                                            <input type="text" wire:model.live.debounce.300ms="search"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                                placeholder="Search" required="">
                                        </div>
                                    </div>
                                    <div class="flex">
                                        {{-- <button wire:click="exportExcel"
                                        class="flex space-x-1 items-center text-green-500 bg-gray-50 hover:bg-grey-100 hover:text-green-700 px-3 py-0.5 rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                                <span>Export Excel</span>
                                        </button> --}}
                                    </div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table
                                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400 dark:bg-gray-700">
                                        <thead
                                            class="text-xs text-gray-700 dark:text-gray-100 uppercase bg-gray-100 dark:bg-gray-800">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 w-[50px]">S/No.</th>
                                                <th scope="col" class="px-4 py-3 normal-case">Invoice Date</th>
                                                <th scope="col" class="px-4 py-3 normal-case">Invoice No.</th>
                                                <th scope="col" class="px-4 py-3 normal-case">Invoice Amount</th>
                                                <th scope="col" class="px-4 py-3 normal-case">Amount Paid</th>
                                                <th scope="col" class="px-4 py-3 normal-case">Amount Remained</th>
                                                <th scope="col" class="px-4 py-3 normal-case">Credit Days</th>
                                                <th scope="col" class="px-4 py-3 normal-case">Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="[&>*:nth-child(even)]:bg-[#F6F9FF] [&>*:nth-child(even)]:dark:bg-gray-600">
                                            @forelse ($data as $key=>$dt)
                                                <tr>
                                                    <td colspan="8" class="p-2 font-bold bg-blue-100 text-gray-700">
                                                        {{ $key }}</td>
                                                </tr>
                                                @foreach ($dt as $dt)
                                                    <tr wire:key=""
                                                        class="border-b border-gray-100 dark:border-gray-700">
                                                        <th scope="row"
                                                            class="px-4 py-3 w-[50px] font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            {{ $loop->iteration }}</th>
                                                        <td class="px-4 py-3 whitespace-nowrap">
                                                            {{ $dt->date->format('M d, Y') }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap">
                                                            {{ $dt?->invoiceno }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap">
                                                            {{ $dt->items?->sum('price') }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap">
                                                            {{ $dt->transactions?->amount ?? 0 }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap">
                                                            {{ $dt->balance }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap">
                                                            {{ $dt->credit_days }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap">
                                                            <span class="px-3 py-1 rounded-md {{ $dt->overdue ? 'bg-red-50 text-red-500' : 'bg-gray-100' }}">
                                                                {{ $dt->due_date->format('M d, Y') }}</td>

                                                            </span>
                                                    </tr>
                                                @endforeach
                                            @empty
                                                <tr class="bg-gray-50">
                                                    <td class="py-2" colspan="50">
                                                        <div class="flex justify-center">There is nothing currently
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
