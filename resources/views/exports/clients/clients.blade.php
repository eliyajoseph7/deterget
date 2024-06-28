<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 dark:bg-gray-700">
    <thead class="text-xs text-gray-700 dark:text-gray-100 bg-gray-100 dark:bg-gray-800">
        <tr>
            <th colspan="9" rowspan="2"
                style="text-transform: uppercase; text-align: center; font-size: 16; font-weight: bold;">CLIENTS</th>
        </tr>
    </thead>
    <tbody class="">
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <th style="font-weight: 500;">S/No.</th>
            <th style="font-weight: 500;">Name</th>
            <th style="font-weight: 500;">Phone</th>
            <th style="font-weight: 500;">TIN Number</th>
            <th style="font-weight: 500;">VRN</th>
            <th style="font-weight: 500;">Account Number</th>
            <th style="font-weight: 500;">Bank Name</th>
            <th style="font-weight: 500;">Address</th>
            <th style="font-weight: 500;">Created At</th>
        </tr>
        @forelse ($data as $dt)
            <tr class="">
                <th scope="row"
                    class="px-4 py-3 w-[50px] font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $loop->iteration }}</th>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->name }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->phone }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->tin_number }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->vrn_number }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->bank_account }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->bank_name }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->address }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $dt->created_at->format('Y-m-d') }}</td>
            </tr>
        @empty
        @endforelse

    </tbody>
</table>
