<table>
    <thead class="text-xs text-gray-700 dark:text-gray-100 uppercase bg-gray-100 dark:bg-gray-800">
        <tr>
            <th colspan="7" rowspan="2"
                style="text-transform: uppercase; text-align: center; font-size: 16; font-weight: bold;">Detailed Sale
                Report {{ $date->format('F Y') }}</th>
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
            <th style="font-weight: 500;">Selling Price</th>
            <th style="font-weight: 500;">Category</th>
            <th style="font-weight: 500;">Quantity Sold</th>
            <th style="font-weight: 500;">Price (+ VAT)</th>
            <th style="font-weight: 500;">Quantity Remained</th>
        </tr>
        @forelse ($data as $key=>$dt)
            <tr>
                <td colspan="8" style="font-weight: bold;">{{ $key }}</td>
            </tr>
            @foreach ($dt as $dt)
                <tr class="border-b border-gray-100 dark:border-gray-700">
                    <th scope="row"
                        class="px-4 py-3 w-[50px] font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $loop->iteration }}</th>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $dt['date'] }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $dt['product']?->name }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $dt['product']?->selling_price }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $dt['product']?->category?->name }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $dt['sold'] }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-right">
                        {{ number_format($dt['price'], 2) }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $dt['remain'] }}</td>
                </tr>
            @endforeach
        @empty
        @endforelse

    </tbody>
</table>
