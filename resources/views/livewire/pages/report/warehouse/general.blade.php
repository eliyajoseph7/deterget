<div>
    <x-slot name="header">
        @include('includes.breadcrumb', [
            'main' => 'Reports',
            'menu' => 'Warehouse Transactions',
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
                                </div>
                                <div class="overflow-x-auto">
                                    <table
                                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400 dark:bg-gray-700">
                                        <thead
                                            class="text-xs text-gray-700 dark:text-gray-100 uppercase bg-gray-100 dark:bg-gray-800">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 w-[50px]">S/No.</th>
                                                @include('includes.table-header-sort', [
                                                    'name' => 'product_id',
                                                    'displayName' => 'Product',
                                                ])
                                                <th scope="col" class="px-4 py-3 normal-case">Category</th>
                                                <th scope="col" class="px-4 py-3 normal-case">Received Amount</th>
                                                <th scope="col" class="px-4 py-3 normal-case">Dispatched Amount</th>
                                                <th scope="col" class="px-4 py-3 normal-case">Remained Balance</th>
                                                <th scope="col" class="px-4 py-3 w-[100px] float-end">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="[&>*:nth-child(even)]:bg-[#F6F9FF] [&>*:nth-child(even)]:dark:bg-gray-600">
                                            @forelse ($data as $dt)
                                                <tr wire:key="{{ $dt->id }}"
                                                    class="border-b border-gray-100 dark:border-gray-700">
                                                    <th scope="row"
                                                        class="px-4 py-3 w-[50px] font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $loop->iteration }}</th>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        {{ $dt->product?->name }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        {{ $dt->product?->category?->name }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        {{ $dt->received }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        {{ $dt->dispatched }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        {{ $dt->received - $dt->dispatched }}</td>
                                                        <td>
                                                            <div class="shadow-sm hover:shadow-lg bg-gray-50 px-2 w-10 rounded-lg"
                                                                title="View Movement by Date">
    
                                                                <a href="{{ route('warehouse_report_by_date', [$dt->product_id]) }}"
                                                                    class="">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" class="w-6 h-6 bg-inherit">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>
                                                                </a>
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

                                        </tbody>
                                    </table>
                                </div>

                                @include('includes.table_pages', [
                                    'data' => $data,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
