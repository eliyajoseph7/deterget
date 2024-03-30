<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 dark:bg-gray-700">
    <thead class="text-xs text-gray-700 dark:text-gray-100 bg-gray-100 dark:bg-gray-800">
        <tr>
            <th colspan="7" rowspan="2"
                style="text-transform: uppercase; text-align: center; font-size: 16; font-weight: bold;">PRODUCTS PENDING CONFIRMATION</th>
        </tr>
    </thead>
    <tbody class="">
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <th style="font-weight: 500;">S/No.</th>
            <th style="font-weight: 500;">Date</th>
            <th style="font-weight: 500;">Product</th>
            <th style="font-weight: 500;">Unit Price</th>
            <th style="font-weight: 500;">Quantity</th>
            <th style="font-weight: 500;">Received By</th>
        </tr>
        @forelse ($data as $dt)
            <tr class="">
                <th scope="row"
                    class="px-4 py-3 w-[50px] font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $loop->iteration }}</th>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->date }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->product?->name }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->product?->unit_price }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->quantity }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->user?->name }}</td>
            </tr>
        @empty
        @endforelse

    </tbody>
</table>
