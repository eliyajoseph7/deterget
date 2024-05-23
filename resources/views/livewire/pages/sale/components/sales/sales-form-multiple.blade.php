<div>
    <div class="relative">
        <x-slot name="header">
            @include('includes.breadcrumb', [
                'main' => 'Sales',
                'menu' => 'Record Sale(s)',
            ])
        </x-slot>
        <div class="fixed top-40 right-8 z-50">
            <a href="{{ route('distributions') }}" class="bg-red-500 px-2 py-0.5 text-white rounded-md"
                title="close">x</a>
        </div>
    </div>
    <div class="bg-white rounded-md border-t-2 border-gray-50 px-5 md:w-3/4 mx-auto relative">
        <a class="absolute top-3 md:top-3/4 right-1.5 md:right-2 cursor-pointer flex space-x-2 items-center text-xl px-3 py-1 bg-gradient-to-r from-blue-500 to-sky-800 text-white font-bold rounded-full transition-transform transform-gpu hover:-translate-y-0.5 hover:shadow-xl"
            wire:click="addField">+</a>
        <form wire:submit.prevent="{{ $action }}Sale">
            <div class="p-5 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">

                <div class="col-span-3 mb-1">
                    <label for="seller_id" class="block text-sm font-medium leading-6 text-gray-900">Seller<span
                            class="text-red-500">*</span></label>
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
                            @error('seller_id')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-span-3 mb-1">
                    <label for="client_id" class="block text-sm font-medium leading-6 text-gray-900">Client<span
                            class="text-red-500">*</span>
                    </label>
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
                <div class="col-span-3 mb-1">
                    <label for="selling_type" class="block text-sm font-medium leading-6 text-gray-900">Selling
                        Type<span class="text-red-500">*</span></label></label>
                    <div class="mt-2">
                        <div
                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                            <select type="text" id="selling_type" wire:model.live="selling_type"
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
                <div class="col-span-3 mb-1 {{ $selling_type == 'credit' ? '' : 'hidden' }}" id="creditdays">
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
                <div class="col-span-full grid grid-cols-5 gap-2">
                    @foreach ($items as $index => $item)
                        <div class="col-span-4 grid grid-cols-2 gap-2">
                            <div class="">
                                @unless ($loop->iteration != 1)
                                    <label for="sale_product_id"
                                        class="block text-sm font-medium leading-6 text-gray-900">Product<span
                                            class="text-red-500">*</span></label></label>
                                @endunless
                                <div class="mt-2">
                                    <div wire:igno re
                                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                                        <select type="text" id="items.{{ $index }}.product_id" wire:model.lazy="items.{{ $index }}.product_id"
                                            class="block product select2 w-screen border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                            <option value="">Select..</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->name . ' ' . $product->quantity . ' ' . $product->uom->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="text-red-500 text-sm">
                                        @error('items.' . $index . '.product_id')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                @unless ($loop->iteration != 1)
                                    <label for="quantity" class="block text-sm font-medium leading-6 text-gray-900">Quantity
                                        <span class="text-red-500">*</span></label>
                                @endunless
                                <div class="mt-2">
                                    <div
                                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                                        <input type="number" step="0.01" id="quantity"
                                            wire:model.live="items.{{ $index }}.quantity"
                                            class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                            placeholder="Enter quantity">
                                    </div>
                                    <div class="text-red-500 text-sm">
                                        @error('items.' . $index . '.quantity')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        @unless ($index == 0)
                            <div class="">

                                <div wire:click="removeField({{ $index }})"
                                    class="text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 p-2 cursor-pointer h-10 w-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </div>
                            </div>
                        @endunless
                    @endforeach
                </div>

            </div>
            <button type="submit" class="bg-red-500 hover:bg-red-600 px-8 py-1.5 mx-5 rounded-lg text-white">
                <div wire:loading>
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
                <span>
                    {{ $action == 'add' ? 'Submit' : 'Update' }}
                </span>
            </button>
        </form>
    </div>

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


            // clear wire ignored select fields on form reset
            Livewire.on('reset_product_id', () => {
                $('#product_id').val('').trigger('change')
            })
            Livewire.on('set_seller_select_field', (val) => {
                $('#seller_id').val(val[0]).trigger('change')
            })
            Livewire.on('set_client_select_field', (val) => {
                $('#client_id').val(val[0]).trigger('change')
            })
            Livewire.on('set_product_field', (val) => {
                console.log(val[0][0]);
                console.log($('#items.'+ val[0][0] +'.product_id').val());
                $('#items.'+ val[0][0] +'.product_id').val(val[0][1]).trigger('change')
            })
        });


        $(document).on('change', '.product', function(e) {
            //when ever the value of changes this will update your PHP variable 
            var id = $(this).attr('id');
            @this.set($(this).attr('id'), $(this).val());
        });


        $(document).on('change', '#client_id', function(e) {
            //when ever the value of changes this will update your PHP variable 
            @this.set('client_id', $(this).val());
        });

        $(document).on('change', '#seller_id', function(e) {
            //when ever the value of changes this will update your PHP variable 
            @this.set('seller_id', $(this).val());
        });
    </script>
</div>
