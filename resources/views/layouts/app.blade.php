<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ URL::to('assets/img/fav.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/custom_style.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/toastr.min.css') }}">

    <script src="{{ URL::to('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/moment.js') }}"></script>
    <script src="{{ URL::to('assets/js/toastr.min.js') }}"></script>
</head>
<body>
    <div id="app">
        @include('layouts.navbar')

        <div class="d-flex">
            @auth
                @include('layouts.slidbar')
            @endauth
            <div class="flex-grow-1 p-3" style="min-height: 100vh;">
                <main>
                    @yield('content')
                    @include('layouts.toaster')
                </main>
            </div>
        </div>
    </div>

    @stack('scripts')

    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>
@auth
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://unpkg.com/laravel-echo/dist/echo.iife.js"></script>

<script>
  window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'your-pusher-key',
    cluster: 'your-cluster',
    forceTLS: true
});

window.Echo.channel('stock-channel')
    .listen('.StockUpdated', (e) => {
        console.log('Stock Updated:', e);
        // Update the UI accordingly
        // For example:
        const stockElem = document.querySelector(`#stock-quantity-${e.id}`);
        if (stockElem) {
            stockElem.textContent = e.quantity;
        }

        // Optional: show a toast notification
        toastr.info(`Stock updated for ${e.name}: ${e.quantity}`);
    });
</script>
@endauth
</body>

</html>