<div class="py-4 px-3 dark:bg-gray-700">
    <div class="flex dark:bg-gray-700">
        <div class="flex space-x-4 items-center mb-3">
            <label class="w-32 text-sm font-medium text-gray-900 dark:text-gray-100">Per Page</label>
            <select wire:model.live="perPage"
                class="bg-gray-50 dark:bg-gray-700 border border-gray-300 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-1 cursor-pointer ">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="100">500</option>
            </select>
        </div>
    </div>
    {{ $data->links() }}
</div>