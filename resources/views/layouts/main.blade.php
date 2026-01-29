@include('layouts.header')
@include('layouts.load_js')
<body class="g-sidenav-show">

@include('layouts.sidebar')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    @include('layouts.nav')

    @yield('content')
</main>
<!-- JavaScript Libraries -->
</body>
<script src="{{ asset('js/soft-ui-dashboard.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</html>
