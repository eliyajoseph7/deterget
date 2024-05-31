<div class="relative">
    <div class="absolute top-1 right-2 bg-red-500 rounded-full h-[25px] px-2 cursor-pointer items-center"
        wire:click="$dispatch('closeModal')">
        <span class="text-white" title="Close">
            x
        </span>
    </div>
    <div class="text-center bg-blue-50 rounded-xl py-5 mb-2 mx-2 font-bold text-gray-600">Record Transaction</div>

    <form wire:submit.prevent="addTransaction">
        <div class="p-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="col-span-full">
                <div class="col-span-full mt-3">
                    <label for="date" class="block text-sm font-medium leading-6 text-gray-900">Date Paid<span
                            class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <div class="flex">
                            <input type="date" id="date" wire:model.live="date"
                                class="block rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full mb-5 text-xs text-gray-900 border border-gray-300 cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 py-2.5"
                                id="default_size">
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-span-full">
                    <label for="invoiceno" class="block text-sm font-medium leading-6 text-gray-900">Invoice No.<span
                            class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <div class="flex" wire:ignore>
                            <select type="text" id="sale_invoice"
                            class="select2 w-screen block rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 mb-5 text-xs text-gray-900 border border-gray-300 cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 py-2.5">
                            <option value="">Select..</option>
                            @foreach ($invoices as $invoice)
                                <option value="{{ $invoice->invoiceno }}">
                                    {{ $invoice->invoiceno }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('invoiceno')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-span-full">
                    <label for="amount" class="block text-sm font-medium leading-6 text-gray-900">Amount Paid<span
                            class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <div class="flex">
                            <input type="number" step="0.01" id="amount" wire:model.live="amount"
                                class="block rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full mb-5 text-xs text-gray-900 border border-gray-300 cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 py-2.5"
                                id="default_size">
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('amount')
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
                    Save
                </span>
            </button>
        </div>
    </form>
</div>
