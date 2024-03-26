<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-3 mb-5 bg-gray-200/20 py-3 px-2 rounded-md">
    <div
        class=" bg-white dark:bg-gray-800 rounded-lg min-h-40 shadow-sm hover:shadow-lg hover:-translate-y-3 duration-700 ease-in-out">
        <div class="flex justify-between px-2 py-2">
            <div class="font-bold">Sales</div>
            <div class="bg-gray-100 px-2">Today</div>
        </div>
        <div class="flex space-x-4 px-5 py-8">
            <div class="font-bold">Tsh.</div>
            <div class="text-3xl font-bold text-blue-900">{{ number_format($totalSale) }}</div>
        </div>
    </div>
    <div
        class=" bg-white dark:bg-gray-800 rounded-lg min-h-40 shadow-sm hover:shadow-lg hover:-translate-y-3 duration-700 ease-in-out">
        <div class="flex justify-between px-2 py-2">
            <div class="font-bold">Raw Materials (Count)</div>
            <div class="bg-gray-100 px-2">Last 7 days</div>
        </div>
        <div class="flex justify-between item-center px-2">
            <div class="">
                <div class="bg-gray-200 rounded-full w-16 h-16 py-5 px-0 text-center">{{ $receivedMat }}</div>
                <div class="py-2">Received</div>
            </div>
            <div class="">
                <div class="bg-gray-200 rounded-full w-16 h-16 py-5 text-center">{{ $dispatchedMat }}</div>
                <div class="py-2">Dispatched</div>
            </div>
        </div>
    </div>
    <div
        class=" bg-white dark:bg-gray-800 rounded-lg min-h-40 shadow-sm hover:shadow-lg hover:-translate-y-3 duration-700 ease-in-out">
        <div class="flex justify-between px-2 py-2">
            <div class="font-bold">Finished Goods (Count)</div>
            <div class="bg-gray-100 px-2">Last 7 days</div>
        </div>
        <div class="flex justify-between item-center px-2">
            <div class="">
                <div class="bg-gray-200 rounded-full w-16 h-16 py-5 px-0 text-center">{{ $receivedProd }}</div>
                <div class="py-2">Received</div>
            </div>
            <div class="">
                <div class="bg-gray-200 rounded-full w-16 h-16 py-5 text-center">{{ $dispatchedProd }}</div>
                <div class="py-2">Dispatched</div>
            </div>
        </div>
    </div>
    <div
        class=" bg-white dark:bg-gray-800 rounded-lg min-h-40 shadow-sm hover:shadow-lg hover:-translate-y-3 duration-700 ease-in-out">
        <div class="flex justify-between px-2 py-2">
            <div class="font-bold">Running out of Stock</div>
            <div class="bg-gray-100 px-2">(Warehouse)</div>
        </div>
        <div class="px-2">
            <div class="flex justify-between px-2 py-1 bg-blue-50">
                <div class="text-gray-600 font-bold">Product</div>
                <div class="">Remain</div>
            </div>
            @forelse ($outofstock as $stock)
                @if ($stock->remain <= 100)
                    <div class="flex justify-between px-2 py-1 mb-1 bg-gray-100">
                        <div class="text-red-500 font-bold">{{ $stock->product }}</div>
                        <div class="">{{ $stock->remain < 0 ? 0 : $stock->remain }}</div>
                    </div>
                @endif
            @empty
                <div class="">Nothing to show!</div>
            @endforelse
        </div>
    </div>
</div>
