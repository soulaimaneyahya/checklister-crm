<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://pngimg.com/uploads/circle/circle_PNG36.png" type="image/png">

    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.4.0/dist/css/coreui.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" integrity="sha512-n+g8P11K/4RFlXnx2/RW1EZK25iYgolW6Qn7I0F96KxJibwATH3OoVCQPh/hzlc4dWAwplglKX8IVNVMWUUdsw==" crossorigin="anonymous" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        tr {
            background-color: #fff !important;
            cursor: pointer !important;
            filter: drop-shadow(0 -0.0625rem 0 #e1e3e5) !important;
        }
        td {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
        }
        .IndexTable {
            width: 4% !important;
        }

        .page-footer {
            left: 0;
            bottom: 0;
            width: 100%;
            position: fixed;
            z-index: 5;
            box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.23);
            border-top: 1px solid rgba(0, 0, 0, 0.1176470588);
        }
        a {
            color: rgb(51, 51, 51)
        }
        .c-active {
            text-decoration: underline !important;
        }
    </style>
</head>
<body class="c-app">

    @auth @include('partials.sidebar') @endauth
    
    <div class="c-wrapper c-fixed-components">
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
            @auth
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                <svg class="c-icon c-icon-lg">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
                </svg>
            </button>
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
                <svg class="c-icon c-icon-lg">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
                </svg>
            </button>
            <ul class="c-header-nav ml-auto mr-4">
                <li class="c-header-nav-item">
                    <a class="c-header-nav-link" href="">{{ __('Get Consultation') }}</a>
                </li>
                <li class="c-header-nav-item d-md-down-none mx-2">
                    <a class="c-header-nav-link" href="">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-settings') }}"></use>
                        </svg>
                    </a>
                </li>
                <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <svg class="c-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                    </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pt-0">
                        <div class="dropdown-header bg-light py-2"><strong>Account :</strong> {{ ucwords(auth()->user()->name) }}</div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
                            </svg> <span>{{ __('Logout') }}</span></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            @else
                @guest
                    <div class="c-header-nav">
                        <p class="c-header-nav-link p-0 m-0 ml-4">{{ env('APP_NAME') }}</p>
                    </div>
                    <ul class="c-header-nav ml-auto mr-4">
                        @if (Route::has('login'))
                            <li class="c-header-nav-item">
                                <a class="c-header-nav-link" href="{{ route('login') }}">
                                    {{ __('Login') }}
                                </a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="c-header-nav-item">
                                <a class="c-header-nav-link" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                @endguest
            @endauth
        </header>
        <main class="c-main p-5 m-0">
            @yield('content')
        </main>
    </div>
    <!-- Optional JavaScript -->
    <!-- Popper.js first, then CoreUI JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js" integrity="sha512-yUNtg0k40IvRQNR20bJ4oH6QeQ/mgs9Lsa6V+3qxTj58u2r+JiAYOhOW0o+ijuMmqCtCEg7LZRA+T4t84/ayVA==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/@coreui/coreui@3.4.0/dist/js/coreui.min.js"></script>
</body>
</html>