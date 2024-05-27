<div class="bg-white rounded-lg shadow-md relative">
    <div class="pb-1"></div>
    <div class="text-center bg-red-50 rounded-xl py-5 mx-2 font-bold text-gray-600">Client Form</div>
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
    <form wire:submit.prevent="{{ $action }}Client">
        <div class="p-5 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">

            <div class="grid grid-flow-col grid-cols-1 gap-2 w-full col-span-full">
                <div class="">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name <span
                            class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <div
                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                            <input type="text" id="name" wire:model.live="name"
                                class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="Enter new client">
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-flow-col grid-cols-1 gap-2 w-full col-span-full">
                <div class="">
                    <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone <span
                            class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <div
                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                            <input type="tel" id="phone" wire:model.live="phone"
                                class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="0XXXXXXXXX">
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('phone')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-flow-col grid-cols-2 gap-2 w-full col-span-full">
                <div class="">
                    <label for="tin_number" class="block text-sm font-medium leading-6 text-gray-900">Tin Number <span
                            class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <div
                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                            <input type="tel" id="tin_number" wire:model.live="tin_number"
                                class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="1XXXXXXXXX">
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('tin_number')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="">
                    <label for="vr_number" class="block text-sm font-medium leading-6 text-gray-900">VR Number</label>
                    <div class="mt-2">
                        <div
                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                            <input type="tel" id="vr_number" wire:model.live="vr_number"
                                class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="1XXXXXXXXX">
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('vr_number')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-flow-col grid-cols-2 gap-2 w-full col-span-full">
                <div class="">
                    <label for="bank_account" class="block text-sm font-medium leading-6 text-gray-900">Bank Account</label>
                    <div class="mt-2">
                        <div
                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                            <input type="tel" id="bank_account" wire:model.live="bank_account"
                                class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="1XXXXXXXXX">
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('bank_account')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="">
                    <label for="bank_name" class="block text-sm font-medium leading-6 text-gray-900">Bank Name</label>
                    <div class="mt-2">
                        <div
                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                            <input type="tel" id="bank_name" wire:model.live="bank_name"
                                class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="1XXXXXXXXX">
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('bank_name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-flow-col grid-cols-1 gap-2 w-full col-span-full">
                <div class="">
                    <label for="address" class="block text-sm font-medium leading-6 text-gray-900">Address <span
                            class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <div
                            class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                            <input type="tel" id="address" wire:model.live="address"
                                class="block w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="1XXXXXXXXX">
                        </div>
                        <div class="text-red-500 text-sm">
                            @error('address')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
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

                Livewire.on('edit_client', (id) => {
                    Livewire.dispatch('update_client', {
                        'id': id
                    });
                })

            })
        </script>
    @endsection
</div>
