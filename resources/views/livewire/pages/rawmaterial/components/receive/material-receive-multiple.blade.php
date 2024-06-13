<div>
    <div class="relative">
        <x-slot name="header">
            @include('includes.breadcrumb', [
                'main' => 'Raw Materials',
                'menu' => 'Multiple Receiving',
            ])
        </x-slot>

        <div class="fixed top-40 right-8 z-50">
            <a href="{{ route('raw_materials') }}" class="bg-red-500 px-2 py-0.5 text-white rounded-md"
                title="close">x</a>
        </div>
    </div>
    <div class="relative bg-white p-5 shadow-sm rounded-md">

        <a class="absolute top-1/3 right-4 cursor-pointer flex space-x-2 items-center text-xl px-3 py-1 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-bold rounded-full transition-transform transform-gpu hover:-translate-y-0.5 hover:shadow-xl"
            wire:click="addField">+</a>
        <form wire:submit.prevent="{{ $action }}ReceiveMaterial">
            <div class="">
                @foreach ($fields as $index => $field)
                    <div class="grid gap-6 mb-6 md:grid-cols-5">
                        <div class="grid gap-6 mb-6 md:grid-cols-3 col-span-4">
                            <div>
                                <label for="raw_material_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Material
                                    <span class="text-red-500">*</span></label>
                                <select id="raw_material_id"
                                    wire:model.live="fields.{{ $index }}.raw_material_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select..</option>
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                                    @endforeach
                                </select>

                                <div class="text-red-500 text-sm">
                                    @error('fields.' . $index . '.raw_material_id')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="date"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date
                                    <span class="text-red-500">*</span></label>
                                <input type="date" id="date" wire:model="fields.{{ $index }}.date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="" />

                                <div class="text-red-500 text-sm">
                                    @error('fields.' . $index . '.date')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="quantity"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity
                                    <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" id="quantity"
                                    wire:model="fields.{{ $index }}.quantity"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="" />

                                <div class="text-red-500 text-sm">
                                    @error('fields.' . $index . '.quantity')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-span-3">
                                <label for="invoice"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice
                                    <span class="text-red-500">*</span></label>
                                <input wire:model.lazy="fields.{{ $index }}.invoice"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    id="invoice" type="file" />

                                <div class="text-red-500 text-sm">
                                    @error('fields.' . $index . '.invoice')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}
                        </div>
                        <div>
                            @if ($loop->iteration != 1)
                                <div class="mt-7">

                                    <div wire:click="removeField({{ $index }})"
                                        class="dark:text-gray-300 rounded-md hover:bg-gray-500 p-2 cursor-pointer h-10 w-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="mb-2 grid grid-cols-5">
                    <div class="col-span-4">
                        <label for="invoice"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice
                            <span class="text-red-500">*</span></label>
                        <input wire:model.lazy="invoice"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="invoice" type="file" />

                        <div class="text-red-500 text-sm">
                            @error('invoice')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="block bg-blue-500 hover:bg-blue-600 col-span-full px-14 py-2 rounded-lg text-white">
                    <div wire:loading>
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <span>
                        {{ $action == 'add' ? 'Submit' : 'Update' }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
