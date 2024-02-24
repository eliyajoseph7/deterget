<div>
    <x-slot name="header">
        @include('includes.breadcrumb', [
            'main' => 'Settings',
            'menu' => 'Roles / Role Permissions',
        ])
    </x-slot>
    <div class="bg-blue-100 pb-1 rounded-md">

        <form class="w-full pb-0 bg-white rounded-lg border-t-gray-200 border-t-2"
            wire:submit.prevent="save(Object.fromEntries(new FormData($event.target)))">
            <div class="mb-0 w-full pb-4 bg-white shadow-sm rounded-t-lg">
                <div class="bg-gray-50 rounded-t-lg text-lg py-4 px-2.5 mb-2 shadow-md text-center uppercase font-bold">Role: {{ $role->name }}</div>
                <div class="flex items-center my-4 px-2.5">
                    <input id="select_all" type="checkbox" value="" class="w-4 h-4 text-blue-600 cursor-pointer border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="select_all"  id="select_text" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Select All</label>
                </div>
                <div class="items-center px-2.5 [&>*:nth-child(even)]:bg-[#F6F9FF] [&>*:nth-child(even)]:dark:bg-gray-600">
                    @forelse($classes as $class)
                        <h3 class="text-md font-semibold text-gray-600 hover:text-gray-700 uppercase pt-4">{{ $class->name }}</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 py-2.5 px-2" wire:ignore>
                            @forelse($class->permissions as $permission)
                                <div class="py-1">
                                    <div class="flex space-x-2 items-center">
                                        @if (count($role->permissions) > 0)
                                            <input class="w-5 h-5 cursor-pointer text-blue-600 border-gray-300 rounded-xl focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked="checked"' : '' }}
                                                type="checkbox" name="{{ $permission->name }}"
                                                value="{{ $permission->id }}" id="{{ $permission->id }}">
                                        @else
                                            <input name="{{ $permission->slug }}" class="w-5 h-5 cursor-pointer text-blue-600 border-gray-300 rounded-xl focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                type="checkbox"
                                                value="{{ $permission->id }}" id="{{ $permission->id }}">
                                        @endif
                                        <label class="form-check-label mt-0.5" for="{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>

                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    @empty
                    @endforelse
                    <div class="bg-gray-50 md:flex justify-end -mx-3 mr-3 -mb-5 mt-5">
                        <div class="md:flex justify-between space-x-0 md:space-x-3 space-y-2 md:space-y-0">
                            <a href="{{ route('roles') }}" type="button"
                                class="items-center w-full md:w-1/2 px-16 py-2.5 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                Close
                            </a>
                            <div wire:loading.remove wire:target="save" class=" w-full md:w-1/2">
                                <button type="submit"
                                    class="saving items-center w-full px-16 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">
                                    Save
                                </button>
                            </div>
                            <div wire:loading wire:target="save">
                                <button disabled type="button"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center">
                                    <svg aria-hidden="true" role="status"
                                        class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="#E5E7EB" />
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentColor" />
                                    </svg>
                                    Saving...
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).on('change', '#select_all', function() {
            if($(this).prop("checked") == true) {
                $('input[type="checkbox"]').prop('checked', true)
            } else {
                $('input[type="checkbox"]').prop('checked', false)
            }
        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {
                // add
                Livewire.on('attached', (message) => {
                    Toast.fire({
                        icon: 'success',
                        title: message,
                    });
                });
        })
    </script>
</div>
