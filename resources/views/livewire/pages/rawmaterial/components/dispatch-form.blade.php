<div class="bg-white rounded-lg shadow-md relative">
    <div class="pb-1"></div>
    <div class="text-center bg-red-50 rounded-xl py-5 mx-2 font-bold text-gray-600">Dispatch Material's Form</div>
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
    <form wire:submit.prevent="{{ $action }}DispatchMaterial">
        <div class="p-5 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">

            <div class="col-span-full">
                <label for="dispatch_raw_material_id" class="block text-sm font-medium leading-6 text-gray-900">Raw
                    Material <span class="text-red-500">*</span></label></label>
                <div class="mt-2">
                    <div wire:ignore
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <select type="text" id="dispatch_raw_material_id"
                            class="dispatch_raw_material_id block select2 w-screen border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
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
                <label for="purpose" class="block text-sm font-medium leading-6 text-gray-900">Purpose <span
                        class="text-red-500">*</span></label>
                <div class="mt-2">
                    <div
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <textarea rows="2" id="purpose" wire:model.live="purpose"
                            class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            placeholder="Enter purpose"></textarea>
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('purpose')
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
</div>
