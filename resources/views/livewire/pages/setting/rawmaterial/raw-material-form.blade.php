<div class="bg-white rounded-lg shadow-md relative">
    <div class="pb-1"></div>
    <div class="text-center bg-red-50 rounded-xl py-5 mx-2 font-bold text-gray-600">Raw material's Form</div>
    @if ($name)
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
    <form wire:submit.prevent="{{ $action }}RawMaterial">
        <div class="p-5 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">

            <div class="col-span-full">
                <label for="uom_id" class="block text-sm font-medium leading-6 text-gray-900">Unit of Measure</label>
                <div class="mt-2">
                    <div wire:ignore
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <select type="text" id="uom" wire:model="uom_id"
                            class="block select2 w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                            <option value="">Select..</option>
                            @foreach ($measures as $uom)
                                <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('uom_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-span-full">
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Material Name <span
                        class="text-red-500">*</span></label>
                <div class="mt-2">
                    <div
                        class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                        <input type="text" id="name" wire:model.live="name"
                            class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            placeholder="Enter new material">
                    </div>
                    <div class="text-red-500 text-sm">
                        @error('name')
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

                Livewire.on('edit_material', (id) => {
                    Livewire.dispatch('update_material', {
                        'id': id
                    });
                })

            })
        </script>
    @endsection
    <script>
        document.addEventListener('livewire:init', () => {

            Livewire.on('reset_uom', (e) => {
                $('#uom').val('').trigger('change')
            });

            Livewire.on('update_uom_field', (data) => {
                $('#uom').val(data[0].uom_id).trigger('change')
            });


            // clear wire ignored select fields on form reset
            Livewire.on('reset_uom', () => {
                $('#uom_id').val('').trigger('change')
            })
        });
        $(document).on('change', '#uom_id', function(e) {
            //when ever the value of changes this will update your PHP variable 
            @this.set('uom_id', e.target.value);
        });

    </script>
</div>
