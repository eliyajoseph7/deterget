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
                    class="bg-white z-30 shadow mt-24 rounded-lg border-l-4 border-blue-400 md:fixed md:left-[18.5rem] md:right-8 -top-2 py-2">
                    <div class="mx-auto px-4 sm:px-6 lg:px-8">
                        {{ $header }}
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
