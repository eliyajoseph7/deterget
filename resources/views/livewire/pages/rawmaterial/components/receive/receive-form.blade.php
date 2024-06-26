<div class="bg-white rounded-lg shadow-md relative">
    <div class="pb-1"></div>
    <div class="text-center bg-red-50 rounded-xl py-5 mx-2 font-bold text-gray-600">Receive Material's Form</div>
    @if ($raw_material_id)
        <div class="absolute top-1 right-2 bg-red-500 rounded-full h-[25px] px-1 py-1 cursor-pointer"
            wire:click="resetForm">
            <span class="pr-1 text-white" title="Reset form">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" data-slot="icon" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </span>
        </div>
    @endif
    <form wire:submit.prevent="{{ $action }}ReceiveMaterial">
        <div class="p-5 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">

            <div class="col-span-full">
                <label for="raw_material_id" class="block text-sm font-medium leading-6 text-gray-900">Raw
                    Material<span class="text-red-500">*</span></label></label>
                <div class="mt-2">
                    <div wire:ignore
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <select type="text" id="raw_material_id"
                            class="block select2 w-screen border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                            <option value="">Select..</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('raw_material_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-span-full">
                <label for="quantity" class="block text-sm font-medium leading-6 text-gray-900">Quantity <span
                        class="text-red-500">*</span></label>
                <div class="mt-2">
                    <div
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <input type="number" step="0.01" id="quantity" wire:model.live="quantity"
                            class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            placeholder="Enter received quantity">
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('quantity')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            @if ($action == 'add')
                <div class="col-span-full">
                    <label for="invoice" class="block text-sm font-medium leading-6 text-gray-900">Invoice
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <div
                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">

                            <input wire:model.lazy="invoice"
                                class="block w-full border-0 bg-transparent py-0.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                id="invoice" type="file" />
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('invoice')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            @else
                <div class="col-span-full">
                    <label for="new_invoice" class="block text-sm font-medium leading-6 text-gray-900">Invoice ( click
                        <a href="{{ $invoice }}" target="_blank" class="text-blue-500"
                            rel="noopener noreferrer">HERE</a> to view previous invoice)
                    </label>
                    <div class="mt-2">
                        <div
                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">

                            <input wire:model.lazy="new_invoice"
                                class="block w-full border-0 bg-transparent py-0.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                id="new_invoice" type="file" />
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('new_invoice')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-span-full">
                <label for="date" class="block text-sm font-medium leading-6 text-gray-900">Date <span
                        class="text-red-500">*</span></label>
                <div class="mt-2">
                    <div
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-format="yyyy-mm-dd"
                            type="date" id="date" wire:model.live="date"
                            class="datepicker block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            placeholder="Select date">
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('date')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>


            <button type="submit" class="bg-red-500 hover:bg-red-600 col-span-full p-2 rounded-lg text-white">
                <div wire:loading>
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
                <span>
                    {{ $action == 'add' ? 'Submit' : 'Update' }}
                </span>
            </button>
        </div>

        {{-- <div class="flex mt-3 w-full">
            @if ($invoice)
                <object data="{{ $invoice->temporaryUrl() }}" type="application/pdf" width="100%" height="500px">
                    <p>Unable to display PDF file. <a href="{{ $invoice->temporaryUrl() }}">Download</a> instead.</p>
                </object>
            @endif
        </div> --}}
    </form>

    @section('scripts')
        <script data-navigate-once>
            document.addEventListener('livewire:init', () => {

                Livewire.on('edit_product', (id) => {
                    Livewire.dispatch('update_product', {
                        'id': id
                    });
                })


            })
        </script>
    @endsection
    <script>
        document.addEventListener('livewire:init', () => {

            // Livewire.on('reset_raw_material_id', (e) => {
            //     $('#raw_material_id').val('').trigger('change')
            // });

            // Livewire.on('update_raw_material_id_field', (data) => {
            //     $('#raw_material_id').val(data).trigger('change')
            // });

            // add
            // Livewire.on('initialize_select2', (message) => {
            //     $('.select2').select2({
            //         minimumResultsForSearch: 6,
            //         placeholder: "select...",
            //     });
            //     console.log('loaded')
            // });


            // clear wire ignored select fields on form reset
            Livewire.on('reset_raw_material_id', () => {
                $('#raw_material_id').val('').trigger('change')
            })
        });
    </script>
</div>
