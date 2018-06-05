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
                    $.notify("{!! session('success') !!}", {globalPosition: "top right", className: "success", autoHide: false});
                </script>
            @endif
            @if (session('error') && is_array(session('error')))
                <script>
                    @foreach (session('error') as $err)
                    $.notify("{!! $err !!}", {globalPosition: "top right", className: "error", autoHide: false});
                    @endforeach
                </script>
            @elseif (session('error'))
                <script>
                    $.notify("{!! session('error') !!}", {globalPosition: "top right", className: "error", autoHide: false});
                </script>
            @endif

            <script type="text/javascript">
                var fname = "{!! session('user.FirstName') ?? '' !!}";
                if (localStorage) {
                    localStorage.setItem('name', fname);
                    console.log(localStorage.getItem('name'));
                }

            </script>
            @yield('content')
        </div>
        <footer>
            @yield('jquery_script')
            @yield('daterangepicker_script')
            @yield('custom_script')

            @if (App::getLocale() == 'en')
                @include('includes.footer-en')
            @else
                @include('includes.footer-ar')
            @endif
        </footer>
    </body>
</html>