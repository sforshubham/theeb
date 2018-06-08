<!doctype html>
<html>
    <head id="Head1">
        @include('includes.head')
    </head>
    <body style="background: #ededed;
        @if (App::getLocale() == 'ar')
            direction: rtl; 
        @endif
    ">
        @if (App::getLocale() == 'en')
            @include('includes.header-en')
        @else
            @include('includes.header-ar')
        @endif
        <div id="DivBody">
            @if (session('success'))
                <script>
                    $.notify("{!! session('success') !!}", {globalPosition: "top right", className: "success"});
                </script>
            @endif
            @if (session('error') && is_array(session('error')))
                <script>
                    @foreach (session('error') as $err)
                    $.notify("{!! $err !!}", {globalPosition: "top right", className: "error"});
                    @endforeach
                </script>
            @elseif (session('error'))
                <script>
                    $.notify("{!! session('error') !!}", {globalPosition: "top right", className: "error"});
                </script>
            @endif

            @yield('content')
            <script>
            jQuery(function() {
                jQuery.notify.defaults({ autoHideDelay: 7000 });
            });
            </script>
        </div>
        <footer>
            @yield('jquery_script')
            @yield('daterangepicker_script')
            @yield('custom_script')
            @yield('custom_script_new')

            @if (App::getLocale() == 'en')
                @include('includes.footer-en')
            @else
                @include('includes.footer-ar')
            @endif
        </footer>
    </body>
</html>