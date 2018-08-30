<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="img/favicon.ico">
        <title>@yield('pageTitle') - theBroCode</title>

        <!-- CSS-->
      <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
      <link href="{{ URL::asset('css/custom/custom.min.css') }}" rel="stylesheet" type="text/css">
      <link href="{{ URL::asset('css/custom/broCode.css') }}" rel="stylesheet" type="text/css">
      <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

      <!--JS-->
      <script type="text/javascript"  src="{{ URL::asset('js/jquery-1.12.4.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>       
      <script type="text/javascript" src="{{ URL::asset('js/impl.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('js/typeahead.bundle.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('js/k/custom.js') }}"></script>

      @yield('js-libs')

        <script>
            var APP_URL = "<?php echo config('app.url'); ?>";
            var APP_PUBLIC_URL = "<?php echo config('app.url'); ?>";
        </script>

    </head>

    <body class="login">

        <div>
            <div class="login_wrapper">

                <div class="animate form login_form">

                    <section class="login_content"> 
                        @yield('content')
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>