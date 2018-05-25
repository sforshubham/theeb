		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="author" content="Scotch">

		<title>Theeb - @yield('title')</title>

	@if (App::getLocale() == 'en')
        <link rel='stylesheet' id='theeb-lingual-style-css'  href='http://theeb.com.sa/wp-content/themes/theeb/style-en.css?ver=4.9.5' type='text/css' media='all' />
        <link rel="stylesheet" href="{{ asset('css/theeb-en.css') }}">
    @else
        <link rel='stylesheet' id='theeb-lingual-style-css'  href='http://theeb.com.sa/wp-content/themes/theeb/style-en.css?ver=4.9.5' type='text/css' media='all' />
        <link rel="stylesheet" href="{{ asset('css/theeb-ar.css') }}">
    @endif
		
		<script type="text/javascript" src="{{ asset('js/jquery.js') }}">
    		var $ = jQuery;
		</script>
		<script type="text/javascript" src="{{ asset('js/notify.min.js') }}"></script>

