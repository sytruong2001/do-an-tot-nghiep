<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ asset('') }}">
    <title>Đặt phòng khách sạn</title>
    <link rel="apple-touch-icon" sizes="76x76" href="asset/img/apple-icon.png">
    <link rel="icon" type="image/png" href="https://clipground.com/images/sn-logo-png.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- CSS Files -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/material-kit.css?v=1.2.1" rel="stylesheet" />
    <link href="css/user-app.css" rel="stylesheet" />
    <link href="css/payment.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


</head>

<body class="profile-page">
    <nav class="navbar navbar-primary navbar-transparent navbar-fixed-top navbar-color-on-scroll">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Khách sạn SN</a>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/login">
                            <i class="material-icons">login</i> Login
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>


    <div class="page-header header-filter" data-parallax="true"
        style="background-image: url('https://th.bing.com/th/id/R.4392402f3c32723b3939bee3d9e53f06?rik=brbYJLhwbJp8fw&riu=http%3a%2f%2ftuongvihotel.com%2fhaiphong%2fthemes%2fsachnoi%2fimg%2fpage_banner.jpg&ehk=U1%2bnP9ovvOl%2flE2GmukZhorzI9k9NJ3%2bi4OyUSJ3vqg%3d&risl=&pid=ImgRaw&r=0');">
    </div>
    {{-- content space --}}
    @yield('content')
    {{-- end content space --}}



    <footer class="footer">
        <div class="container">
            <div class="container">
                <a class="footer-brand" href="#sn">Khách sạn SN</a>
                <ul class="pull-center">
                    <li>
                        <a href="#sn">
                            Payment(MOMO)
                        </a>
                    </li>
                    <li>
                        <a href="#sn">
                            Contact Us(0359241554)
                        </a>
                    </li>
                </ul>

                <ul class="social-buttons pull-right">
                    <li>
                        <a href="https://www.facebook.com/groups/331749904461028" target="_blank"
                            class="btn btn-just-icon btn-facebook btn-simple">
                            <i class="fa fa-facebook-square"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/blackpinkofficial/" target="_blank"
                            class="btn btn-just-icon btn-google btn-simple">
                            <i class="fa fa-google"></i>
                        </a>
                    </li>
                </ul>

            </div>
            <nav class="pull-left">
                <ul>
                    <li>
                        <a href="#">
                            Đồ án tốt nghiệp
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="copyright pull-right">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>, made with <i class="fa fa-heart heart"></i> by SN
            </div>
        </div>
    </footer>


</body>
<!--   Core JS Files   -->
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/material.min.js"></script>

<!--    Plugin for Date Time Picker and Full Calendar Plugin   -->
<script src="js/moment.min.js"></script>

<!--	Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/   -->
<script src="js/nouislider.min.js" type="text/javascript"></script>

<!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker   -->
<script src="js/bootstrap-datetimepicker.js" type="text/javascript"></script>

<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select   -->
<script src="js/bootstrap-selectpicker.js" type="text/javascript"></script>

<!--	Plugin for Tags, full documentation here: http://xoxco.com/projects/code/tagsinput/   -->
<script src="js/bootstrap-tagsinput.js"></script>

<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput   -->
<script src="js/jasny-bootstrap.min.js"></script>

<!--    Plugin For Google Maps   -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

<!--    Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc    -->
<script src="js/material-kit.js?v=1.2.1" type="text/javascript"></script>

<!--  Date Time Picker Plugin is included in this js file -->
<script src="js/dashboard/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Wizard Plugin    -->
<script src="js/dashboard/jquery.bootstrap.wizard.min.js"></script>

<!-- Sweet Alert 2 plugin -->
<script src="js/dashboard/sweetalert2.js"></script>

<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="js/dashboard/moment.min.js"></script>
@stack('js')

</html>
