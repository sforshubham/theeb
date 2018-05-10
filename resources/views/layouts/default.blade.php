<!doctype html>
<html>
    <head id="Head1">
        @include('includes.head')
    </head>
    <body style="background: #ededed;">
        <header>
            @include('includes.header')
        </header>
        <div id="DivBody">
            @yield('content')
        </div>
        <footer>
            @include('includes.footer')
        </footer>
    </body>
</html>