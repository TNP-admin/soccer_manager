<!DOCTYPE HTML>
<html lang="ja" dir="ltr" prefix="og: //ogp.me/ns# fb: //www.facebook.com/2008/fbml">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-K3330DB3CN"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-K3330DB3CN');
  </script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  @yield('metatags')
  <!-- 軽量化
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@100;300;500&family=Noto+Sans+JP&family=Noto+Serif+JP:wght@500&display=swap" rel="stylesheet"> -->
  <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" /> 
  <link href="{{ asset('/css/paper-dashboard.css?v=2.0.0') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link rel="stylesheet" type="text/css" href="css/basic.css">
  <link rel="stylesheet" type="text/css" href="css/match_contents.css">

  <!--
  <link rel='stylesheet' href='fullcalendar/fullcalendar.css' />

  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon"/>
  <link rel="apple-touch-icon" href="images/favicon.png" type="image/x-icon"/>
  -->
</head>

<body>
@yield('header')

<section id="main-block">
  <div class="main-column">

    @yield('contents')

  </div>
</section><!--main-block-->

<footer class="footer footer-black  footer-white ">
  <div class="container-fluid">
    <div class="row">
      <div class="credits ml-auto">
        <span class="copyright">
          © 2023- murata hajime
        </span>
      </div>
    </div>
  </div>
</footer>
</div>
</div>

@yield('modal')

<!--   Core JS Files   -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="{{ asset('/js/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('js/basic.js') }}"></script>
<script src="{{ asset('js/match_contents.js') }}"></script>
<!-- <script src="{{ asset('js/cal.js') }}"></script> -->
<script src="{{ asset('js/doubleStop.js') }}"></script>
<!--  Google Maps Plugin    -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
<!-- Chart JS
<script src="{{ asset('js/chartjs.min.js') }}"></script> -->
<!--  Notifications Plugin    -->
<!-- <script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script> -->
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('js/paper-dashboard.min.js?v=2.0.0') }}" type="text/javascript"></script>
<!-- fullcalendar
  <script src="{{ asset('/fullcalendar/lib/moment.min.js') }}"></script>
  <script src="{{ asset('/fullcalendar/fullcalendar.js') }}"></script>
  <script src="{{ asset('/fullcalendar/locale/ja.js') }}"></script>
-->
@yield('javascript')
</html>
