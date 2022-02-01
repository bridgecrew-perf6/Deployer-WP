<head>
  @php $gtm = App::options()['gtm']; @endphp
  @if ($gtm)
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $gtm }}');</script>
    <!-- End Google Tag Manager -->
  @endif

  @php $analytics = App::options()['analytics']; @endphp
  @if ($analytics)
    <!-- Google Analytics -->
      <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '{{$analytics}}', 'auto');
        ga('send', 'pageview');
      </script>
    <!-- End Google Analytics -->
  @endif

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" X-Content-Type-Options="nosniff">

  <link href="@asset('images/favicons/apple-touch-icon-57x57.png')" rel="apple-touch-icon-precomposed" sizes="57x57">
  <link href="@asset('images/favicons/apple-touch-icon-114x114.png')" rel="apple-touch-icon-precomposed" sizes="114x114">
  <link href="@asset('images/favicons/apple-touch-icon-72x72.png')" rel="apple-touch-icon-precomposed" sizes="72x72">
  <link href="@asset('images/favicons/apple-touch-icon-144x144.png')" rel="apple-touch-icon-precomposed" sizes="144x144">
  <link href="@asset('images/favicons/apple-touch-icon-60x60.png')" rel="apple-touch-icon-precomposed" sizes="60x60">
  <link href="@asset('images/favicons/apple-touch-icon-120x120.png')" rel="apple-touch-icon-precomposed" sizes="120x120">
  <link href="@asset('images/favicons/apple-touch-icon-76x76.png')" rel="apple-touch-icon-precomposed" sizes="76x76">
  <link href="@asset('images/favicons/apple-touch-icon-152x152.png')" rel="apple-touch-icon-precomposed" sizes="152x152">
  <link href="@asset('images/favicons/favicon-196x196.png')" rel="icon" type="image/png" sizes="196x196">
  <link href="@asset('images/favicons/favicon-96x96.png')" rel="icon" type="image/png" sizes="96x96">
  <link href="@asset('images/favicons/favicon-32x32.png')" rel="icon" type="image/png" sizes="32x32">
  <link href="@asset('images/favicons/favicon-16x16.png')" rel="icon" type="image/png" sizes="16x16">
  <link href="@asset('images/favicons/favicon-128.png')" rel="icon" type="image/png" sizes="128x128">
  <meta name="msapplication-TileImage" content="@asset('images/favicons/mstile-144x144.png')">
  <meta name="msapplication-square70x70logo" content="@asset('images/favicons/mstile-70x70.png')">
  <meta name="msapplication-square150x150logo" content="@asset('images/favicons/mstile-150x150.png')">
  <meta name="msapplication-wide310x150logo" content="@asset('images/favicons/mstile-310x150.png')">
  <meta name="msapplication-square310x310logo" content="@asset('images/favicons/mstile-310x310.png')">

  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="application-name" content="">
  <meta name="theme-color" content="#ffffff">

  @php wp_head() @endphp

  @if ($gtm)
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtm }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
  @endif
</head>
