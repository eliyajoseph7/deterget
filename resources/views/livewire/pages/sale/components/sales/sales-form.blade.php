<div class="bg-white rounded-lg shadow-md relative">
    <div class="pb-1"></div>
    <div class="text-center bg-red-50 rounded-xl py-5 mx-2 font-bold text-gray-600">Sold Product's Form</div>
    @if ($product_id)
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
    <form wire:submit.prevent="{{ $action }}Sale">
        <div class="p-5 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">

            <div class="col-span-full">
                <label for="seller_id" class="block text-sm font-medium leading-6 text-gray-900">Seller<span
                        class="text-red-500">*</span></label></label>
                <div class="mt-2">
                    <div wire:ignore
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <select type="text" id="seller_id"
                            class="block select2 w-screen border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                            <option value="">Select..</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('seller')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-span-full">
                <label for="sale_product_id" class="block text-sm font-medium leading-6 text-gray-900">Product<span
                        class="text-red-500">*</span></label></label>
                <div class="mt-2">
                    <div wire:ignore
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <select type="text" id="sale_product_id"
                            class="block select2 w-screen border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                            <option value="">Select..</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product?->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('product_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- <div class="col-span-full">
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
            </div> --}}
            <div class="col-span-full">
                <label for="quantity" class="block text-sm font-medium leading-6 text-gray-900">Quantity <span
                        class="text-red-500">*</span></label>
                <div class="mt-2">
                    <div
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <input type="number" step="0.01" id="quantity" wire:model.live="quantity"
                            class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            placeholder="Enter quantity">
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('quantity')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-span-full">
                <label for="selling_type" class="block text-sm font-medium leading-6 text-gray-900">Selling Type<span
                        class="text-red-500">*</span></label></label>
                <div class="mt-2">
                    <div
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <select type="text" id="selling_type" wire:model="selling_type"
                            class="block w-screen border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                            <option value="">Select..</option>
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                        </select>
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('selling_type')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-span-full {{ $selling_type == 'credit' ? '' : 'hidden' }}" id="creditdays">
                <label for="credit_days" class="block text-sm font-medium leading-6 text-gray-900">Credit Days<span
                        class="text-red-500">*</span></label>
                <div class="mt-2">
                    <div
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <select type="text" id="credit_days" wire:model="credit_days"
                            class="block w-screen border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                            <option value="">Select..</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                            <option value="90">90</option>
                        </select>
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('credit_days')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-span-full">
                <label for="client_id" class="block text-sm font-medium leading-6 text-gray-900">Client </label></label>
                <div class="mt-2">
                    <div wire:ignore
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <select type="text" id="client_id"
                            class="block select2 w-screen border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                            <option value="">Select..</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">
                                    {{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('client_id')
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

            // Livewire.on('reset_product_id', (e) => {
            //     $('#product_id').val('').trigger('change')
            // });

            // Livewire.on('update_product_id_field', (data) => {
            //     $('#product_id').val(data).trigger('change')
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
            Livewire.on('reset_product_id', () => {
                $('#product_id').val('').trigger('change')
            })
        });
    </script>
</div>
