<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Detergents') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- flowbite --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" data-turbolinks-track="true"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @livewire('wire-elements-modal')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="font-sans antialiased w-screen overflow-x-hidden">
    <div
        class="relative min-h-screen bg-dots-darker bg-center bg-gray-200 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white overflow-x-hidden bg-[url('{{ asset('assets/images/bg.jpg') }}')] bg-cover bg-blend-overlay">
        <livewire:layout.navigation />

        @include('livewire.layout.sidenav')

        <div class="p-4 sm:ml-64">
            <!-- Page Heading -->
            @if (isset($header))
                <header
                    class="bg-white flex justify-between z-30 shadow mt-24 rounded-lg border-l-4 border-blue-400 md:fixed md:left-[18.5rem] md:right-8 -top-2 py-2 pr-2">
                    <div class="mx-a uto px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                    <div class="hidden items-center z-50 md:flex">
                        <div class="flex items-center ms-3">
                            <div>
                                <button type="button"
                                    class="flex text-sm bg-gray-100 p-2 w-18 h-18 items-center rounded-full focus:ring-0 focus:ring-gray-300 dark:focus:ring-gray-600"
                                    aria-expanded="false" data-dropdown-toggle="dropdown-user2">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="flex items-center space-x-1 px-1 py-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 border-2 rounded-full">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>

                                        <div class="hidden md:flex">{{ auth()->user()->name }}</div>
                                    </div>
                                </button>
                            </div>
                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                                id="dropdown-user2">
                                <div class="px-4 py-3" role="none">
                                    <p class="text-sm text-gray-900 dark:text-white" role="none">
                                        {{ auth()->user()->name }}
                                    </p>
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300"
                                        role="none">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                                <ul class="py-1" role="none">
                                    <li>
                                        <a href="{{ route('dashboard') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                            role="menuitem">Dashboard</a>
                                    </li>
                                    <li>

                                        <a href="{{ route('profile') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                            role="menuitem">Profile</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            class="block cursor-pointer px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                            role="menuitem">Sign out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>
            @endif
            <div class="p-4 border-2 border-gray-50 border-dashed rounded-lg dark:border-gray-700 mt-5 md:mt-40">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
{{-- Highchart --}}
<script src="https://code.highcharts.com/highcharts.js"></script>

<script data-navigate-once>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'green',
        customClass: {
            popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
    });

    document.addEventListener('DOMContentLoaded', () => {
        $('.select2').select2({
            minimumResultsForSearch: 6,
            placeholder: "select...",
        });
        // console.log('loaded')
    });

    Livewire.on('initialize_scripts', () => {
        $('.select2').select2({
            minimumResultsForSearch: 6,
            placeholder: "select...",
        });

        // const datepickerEl = document.getElementsByClassName('datepicker');
        // new Datepicker(datepickerEl, {
        //     // options
        // });
    })
</script>

</html>
