<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    {{-- <title>{{ $title ? $title : '' }} | {{ $web_config['web_name'] ? $web_config['web_name'] : 'Siomay' }} --}}
    <title>{{ $title ? $title : '' }} | {{ $web_config ? $web_config['web_name'] : '' }}
    </title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <meta property="og:url" content="" />
    <link rel="canonical" href="" />
    <link rel="shortcut icon" href="{{ asset('/assets/img/web.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    {{-- <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&amp;l='+l:'';j.async=true;j.src= '/assets/www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-5FS8GGP');
    </script> --}}
    @yield('css')
    @livewireStyles
    @stack('css')

    <style>
        tr.no-data {
            position: relative;
            height: 35vh;
        }

        .no-data td {
            position: absolute;
            width: 100%;
        }

    </style>
</head>

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="loading" id="loading">Loading&#8230;</div>
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            @include('dashboard.layouts.partials._sidebar')
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('dashboard.layouts.partials._header')
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="toolbar d-md-none d-sm-block" id="kt_toolbar">
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">{{
                                    strtoupper($active) }}
                                    <span class="h-20px border-1 border-gray-200 border-start ms-3 mx-2 me-1"></span>
                                    <span class="text-muted fs-7 fw-bold mt-2"></span>
                            </div>
                        </div>
                    </div>
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <div id="kt_content_container" class="container-xxl">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    <div
                        class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted fw-bold me-1">2022©</span>
                            {{-- <a href="#" class="text-gray-800 text-hover-primary">siomaymasnur.com</a> --}}
                        </div>
                        <ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
                            <li class="menu-item">
                                <a href="javascript:" target="_blank" class="menu-link px-2">About</a>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:" target="_blank" class="menu-link px-2">Support</a>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:" target="_blank" class="menu-link px-2">Purchase</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Demo Right Bar Metronic -->
    {{-- @include('admin.layouts.partials._rightBar') --}}
    <script>
        var hostUrl = "{{ asset('/assets/index.html') }}";
    </script>
    <script src="{{ asset('/assets/plugins/global/plugins.bundle.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('/assets/js/scripts.bundle.js') }}"></script>
    {{-- <script src="{{ asset('/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}
    <script src="{{ asset('/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/intro.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script src="{{ asset('/assets/js/custom.js') }}"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

    {!! Toastr::message() !!}

    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script>
        $(document).ready(function() {

        });
            $(document).ready(function () {
                loading(false)
                if("{{ session('success') }}"){
                    toastr.success("{{ session('success') }}")
                }

                if("{{ session('fail') }}"){
                    toastr.error("{{ session('fail') }}")
                }

                toastr.options.timeOut = 10000;
                    @if (Session::has('error'))
                        toastr.error('{{ Session::get('error') }}');
                    @elseif(Session::has('success'))
                        toastr.success('{{ Session::get('success') }}');
                    @endif
                });

            function loading(action){
                if(action === false){
                    $('#loading').addClass('d-none')
                }else{
                    $('#loading').removeClass('d-none')
                }
            }
    </script>
    @yield('js')
    @livewireScripts
    @stack('js')
</body>

</html>
