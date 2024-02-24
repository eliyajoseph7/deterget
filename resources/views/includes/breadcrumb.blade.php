@if ($menu ?? '')

<div class="p-2 bg-white text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
    <div class="mt-0 p-4 rounded-lg flex flex-wrap">
        @if ($main ?? '')
            <div class="text-gray-400 flex pr-1 whitespace-nowrap">
                <span class="pr-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                      </svg>                      
                      
                </span>
                {{ $main }} / 
            </div>
        @else
            
        @endif
        <div class="text-gray-600">{{ $menu }} Management</div>
    </div>
</div>
@endif