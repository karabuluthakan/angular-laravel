<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />

    <title>{{config('app.name')}} | @yield('title')</title>
    <meta name="description" content="Inner page example page">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->

    <!--begin::Base Styles -->
    <link href="{{ asset('css/bundle.css')  }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Base Styles -->

    <link href="{{ asset('css/toastr.min.css')  }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('js/backend.angular/styles.css')  }}" rel="stylesheet" type="text/css" />

    {{--<link rel="shortcut icon" href="" />--}}

    <script type="text/javascript">
        var sherlock = {
            token: "{{ csrf_token() }}",
            ajax_url: "{{ route('admin_ajax') }}",
            users: [
                {
                    value: 1,
                    label: "Hakan Karabulut"
                },
                {
                    value: 2,
                    label: "Halil İbrahim Özdemir"
                }
            ]
        };
    </script>

    <base href="/">

    @yield('style')
</head>
<!-- end::Head -->


<!-- begin::Body -->
<body  class="m-page--fluid m--skin- m-content--skin-light2{{ !isset($header) || $header ? ' m-header--fixed m-header--fixed-mobile' : '' }} m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >

@yield('content')

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->		    <!-- begin::Quick Nav -->
<!-- begin::Quick Nav -->
<!--begin::Base Scripts -->
<script src="{{ asset('js/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/scripts.bundle.js') }}" type="text/javascript"></script>
<!--end::Base Scripts -->

<script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    toastr.options = {
        "positionClass": "toast-bottom-right",
    };

    (function ($) {
        $.startLoader = function () {
            $("body").addClass("sloading");
        };

        $.stopLoader = function () {
            $("body").removeClass("sloading");
        };
    })(jQuery);
</script>

<div id="sherlock-loader"><img src="{{ asset('images/loading-bubbles.svg') }}" alt="" width="80"></div>

<script type="text/javascript">
    sherlock.post = {
        statuses: [
            {
                value: "1",
                label: "Yayımla"
            },
            {
                value: "0",
                label: "Yayımda Değil"
            },
            {
                value: "2",
                label: "Taslak"
            }
        ]
    };
</script>

<script type="text/javascript">
    sherlock.page = {
        statuses: [
            {
                value: "1",
                label: "Yayımla"
            },
            {
                value: "0",
                label: "Yayımda Değil"
            },
            {
                value: "2",
                label: "Taslak"
            }
        ]
    };
</script>

<script type="text/javascript">
    sherlock.user = {
        statuses: [
            {
                value: "1",
                label: "Aktif"
            },
            {
                value: "0",
                label: "Pasif"
            }
        ],
        roles: [
            {
                value: "1",
                label: "Admin"
            }
        ]
    };
</script>

<script type="text/javascript" src="{{ asset('js/backend.angular/runtime.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/backend.angular/polyfills.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/backend.angular/scripts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/backend.angular/main.js') }}"></script>

@yield('script')
</body>
<!-- end::Body -->
</html>
