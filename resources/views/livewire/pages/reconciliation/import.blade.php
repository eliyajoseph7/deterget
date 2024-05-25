<div class="relative">
    <div class="absolute top-1 right-2 bg-red-500 rounded-full h-[25px] px-2 cursor-pointer items-center"
        wire:click="$dispatch('closeModal')">
        <span class="text-white" title="Close">
            x
        </span>
    </div>
    <div class="text-center bg-blue-50 rounded-xl py-5 mb-2 mx-2 font-bold text-gray-600">Import File</div>
    <div class="text-green-500 mx-2 my-0.5">
        <a href="{{ asset('assets/templates/transaction_import_template.xlsx') }}" download class="flex space-x-2 text-sm bg-gray-100 rounded-full px-2.5 w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg><span>Download template</span>

        </a>
    </div>

    <form wire:submit.prevent="importFile">
        <div class="p-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="col-span-full">
                <div class="col-span-full mt-3">
                    <label for="file" class="block text-sm font-medium leading-6 text-gray-900">Excel File<span
                            class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <div class="flex">
                            <input type="file" id="file" wire:model.live="file"
                                class="block rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full mb-5 text-xs text-gray-900 border border-gray-300 cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 py-0.5"
                                id="default_size">
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('file')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 col-span-full p-2 rounded-lg text-white">
                <div wire:loading>
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
                <span>
                    Import
                </span>
            </button>
        </div>
    </form>
</div>
