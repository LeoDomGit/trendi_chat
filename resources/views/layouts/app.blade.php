<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    <?php if(str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true'){ ?> dir="rtl" <?php } ?>>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Quickl') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo-light-icon.png') }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
    <link href="{{ asset('css/colors/blue.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/summernote/summernote.css')}}" rel="stylesheet">
    <?php if(str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true'){ ?>
    	<link href="{{asset('assets/plugins/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet">
    <?php } ?>
    <?php if(str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true'){ ?>
    	<link href="{{asset('css/style_rtl.css')}}" rel="stylesheet">
    <?php } ?>
    @yield('style')
</head>

<body>

<div id="app" class="fix-header fix-sidebar card-no-border">
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                @include('layouts.header')
            </nav>
        </header>

        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                @include('layouts.menu')
            </div>
        </aside>
    </div>
    <main class="py-4">
        @yield('content')
        @include('layouts.footer')
    </main>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/waves.js') }}"></script>
<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote/summernote.js')}}"></script>

<script type="text/javascript">
    
    var doNotDeleteAlert = '{{trans("lang.do_not_delete")}}';
    var doNotChangeAlert = '{{trans("lang.do_not_change")}}';

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    
    $(document).ready(function () {
        
        var url = "{{ route('language.header') }}";
        
        $.ajax({
            url: url,
            type: "GET",
            data: {
                _token: '{{csrf_token()}}',
            },
            dataType: 'json',
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#language_dropdown').append($("<option></option>").attr("value", value.code).text(value.name));
                });
                <?php if(session()->get('locale')){ ?>
                    $("#language_dropdown").val("<?php echo session()->get('locale'); ?>");
                <?php } ?>
            }
        });    

        var url1 = "{{ route('language.change') }}";

        $(".changeLang").change(function () {
            var slug = $(this).val();
            var url = "{{ route('language.code',':slugid') }}";
            url = url.replace(':slugid', slug);
            if (slug) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (key, value) {
                            if (value.code == slug) {
                                if (value.is_rtl == false) {
                                    setCookie('is_rtl', 'false', 365);
                                } else {
                                    setCookie('is_rtl', value.is_rtl.toString(), 365);
                                }
                                window.location.href = url1 + "?lang=" + value.code;
                            }
                        });
                    }
                });
            }
        });

    });
    </script>      

@yield('scripts')

</body>
</html>
