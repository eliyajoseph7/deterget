<div>
    <div class="overflow-x-auto bg-white shadow-sm rounded-md">
        <div class="py-4 px-2 font-bold text-lg text-sky-900">Best 10 Performing Clients</div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 dark:bg-gray-700">
            <thead class="text-xs text-gray-700 dark:text-gray-100 bg-gray-100 dark:bg-gray-800">
                <tr>
                    {{-- <th scope="col" class="px-4 py-3 w-[50px]">S/No.</th> --}}
                    <th scope="col" class="px-4 py-3">Client</th>
                    <th scope="col" class="px-4 py-3">Paid Invoices</th>
                    <th scope="col" class="px-4 py-3">Not Paid Invoices</th>
                    <th scope="col" class="px-4 py-3">Difference</th>
                    <th scope="col" class="px-4 py-3">Rank</th>

                </tr>
            </thead>
            <tbody class="[&>*:nth-child(even)]:bg-[#F6F9FF] [&>*:nth-child(even)]:dark:bg-gray-600">
                @forelse ($data as $dt)
                    <tr wire:key="{{ $dt->id }}" class="border-b border-gray-100 dark:border-gray-700">
                        {{-- <th scope="row"
                            class="px-4 py-3 w-[50px] font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $loop->iteration }}</th> --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $dt->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $dt->paid }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $dt->not_paid }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $dt->difference }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $loop->iteration }}</td>
                    </tr>
                @empty
                    <tr class="bg-gray-50">
                        <td class="py-2" colspan="50">
                            <div class="flex justify-center">There is nothing currently
                            </div>
                        </td>
                    </tr>
                @endforelse
                {{-- <tr class="">
                    <td colspan="4" class="px-4 py-2 font-bold">Total</td>
                    <td class="px-4 py-2 font-bold" id="cash_sale">{{ number_format($data->sum('amount'), 2) }}</td>
                </tr> --}}
            </tbody>
        </table>
    </div>
</div>
