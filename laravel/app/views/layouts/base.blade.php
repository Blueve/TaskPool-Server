<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Pool - {{{ $title }}}</title>

    <!-- Bootstrap -->
    <link href="{{{ asset('css/bootstrap.min.css') }}}" rel="stylesheet">
    <link href="{{{ asset('css/icheck/all.css') }}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="row clearfix">
        <div class="col-md-12 column">
          @include('layouts.navbar')
        </div>
      </div>

      <div class="row clearfix">
        @yield('content')
      </div>

      <div class="row clearfix">
        <div class="col-md-12 column">
          <hr />
          @include('layouts.footer')
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{{ asset('js/jquery-2.1.1.min.js') }}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{{ asset('js/bootstrap.min.js') }}}"></script>
    <script src="{{{ asset('js/icheck.min.js') }}}"></script>
    <script src="{{{ asset('js/ready.js') }}}"></script>
  </body>
</html>