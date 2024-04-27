<div>
    <x-slot name="header">
        @include('includes.breadcrumb', [
            'main' => 'Reports / Raw Materials',
            'menu' => 'Materials Movement',
        ])
    </x-slot>
    <div class="relative">
        <a href="{{ route('rm_report_by_date', $material->id) }}" class="absolute -top-2 right-2 px-2 bg-red-500 text-white rounded-full">x</a>
        <div class="bg-gray-50 rounded-t-2xl md:flex justify-start md:space-x-8 py-5 px-2">
            <div class="text-lg"><strong class="mr-2 text-blue-900">Material:</strong> {{ $material->name }}</div>
            <div class="text-lg"><strong class="mr-2 text-blue-900">Measure:</strong> {{ $material->uom?->name }}</div>
            <div class="text-lg"><strong class="mr-2 text-blue-900">Date:</strong> {{ $date }}</div>
        </div>
        <div class="grid grid-flow-row md:grid-flow-col md:grid-cols-2 gap-4">
            <div class="">
                <div class="bg-gray-50 py-5 font-bold text-lg shadow-sm rounded-t-lg px-2">Received</div>
                <div class="overflow-x-auto bg-white">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 dark:bg-gray-700">
                        <thead class="text-xs text-gray-700 dark:text-gray-100 uppercase bg-gray-100 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-4 py-3 w-[50px]">S/No.</th>
                                <th scope="col" class="px-4 py-3 normal-case">Received Amount</th>
                                <th scope="col" class="px-4 py-3 normal-case">Received By</th>
                            </tr>
                        </thead>
                        <tbody class="[&>*:nth-child(even)]:bg-[#F6F9FF] [&>*:nth-child(even)]:dark:bg-gray-600">
                            @forelse ($received as $dt)
                                <tr wire:key="{{ $dt->id }}"
                                    class="border-b border-gray-100 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-4 py-3 w-[50px] font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $loop->iteration }}</th>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $dt->quantity }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $dt->user?->name }}</td>
                                </tr>
                            @empty
                                <tr class="bg-gray-50">
                                    <td class="py-2" colspan="50">
                                        <div class="flex justify-center">There is nothing currently
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            @if ($totalReceived > 0)
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-4 py-3 w-[50px] font-bold text-gray-900 whitespace-nowrap dark:text-white">
                                        Total</th>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $totalReceived }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="">
                <div class="bg-gray-50 py-5 font-bold text-lg shadow-sm rounded-t-lg px-2">Dispatched</div>
                <div class="overflow-x-auto bg-white">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 dark:bg-gray-700">
                        <thead class="text-xs text-gray-700 dark:text-gray-100 uppercase bg-gray-100 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-4 py-3 w-[50px]">S/No.</th>
                                <th scope="col" class="px-4 py-3 normal-case">Dispatched Amount</th>
                                <th scope="col" class="px-4 py-3 normal-case">Dispatched By</th>
                            </tr>
                        </thead>
                        <tbody class="[&>*:nth-child(even)]:bg-[#F6F9FF] [&>*:nth-child(even)]:dark:bg-gray-600">
                            @forelse ($dispatched as $dt)
                                <tr wire:key="{{ $dt->id }}"
                                    class="border-b border-gray-100 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-4 py-3 w-[50px] font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $loop->iteration }}</th>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $dt->quantity }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $dt->user?->name }}</td>
                                </tr>
                            @empty
                                <tr class="bg-gray-50">
                                    <td class="py-2" colspan="50">
                                        <div class="flex justify-center">There is nothing currently
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            @if ($totalDispatched > 0)
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-4 py-3 w-[50px] font-bold text-gray-900 whitespace-nowrap dark:text-white">
                                        Total</th>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $totalDispatched }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="flex w-1/2 mt-5 mx-auto">
            <div class=""></div>
            <div class="w-full">
                @include('livewire.pages.report.rm.include.rm-movement-chart', [
                    'data' => $series,
                ])
            </div>
        </div>
    </div>
</div>
