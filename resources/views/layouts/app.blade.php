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
        textarea {
            min-height: 35px !important;
            max-height: 120px !important;
        }
    </style>
</head>
<body class="c-app">
    @auth @include('partials.sidebar') @endauth 
    <div class="c-wrapper c-fixed-components">
        @include('partials.header')
        <main class="c-main p-5 m-0">
            @include('components.alert')
            @yield('content')
        </main>
    </div>
    <!-- Optional JavaScript -->
    <!-- Popper.js first, then CoreUI JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js" integrity="sha512-yUNtg0k40IvRQNR20bJ4oH6QeQ/mgs9Lsa6V+3qxTj58u2r+JiAYOhOW0o+ijuMmqCtCEg7LZRA+T4t84/ayVA==" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@coreui/coreui@3.4.0/dist/js/coreui.min.js"></script>
    @yield('scripts')
</body>
</html>