<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from vtdes.ru/demo/caspero/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Jan 2019 13:55:12 GMT -->
<head>

    <!-- Page title -->
    <title>CasperoBoard - Responsive HTML Backend Template</title>
    <!-- /Page title -->

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- /Meta -->

    <!-- SEO Meta -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- /SEO Meta -->

    <!-- OpenGraph meta -->
    <meta property="og:image" content="">
    <meta property="og:title" content="og title">
    <meta property="og:description" content="og description">
    <!-- /OpenGraph meta -->

    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <!-- Favicon -->
    <!-- <link rel="shortcut icon" src="{{url('../images/favicon.png')}}"> -->
    <link rel="shortcut icon" href="images/logoat.jpg">
    <!-- /Favicon -->

    <!-- AppleTouch Icons -->
    <link rel="apple-touch-icon" href="#">
    <link rel="apple-touch-icon" href="#" sizes="57x57">
    <link rel="apple-touch-icon" href="#" sizes="72x72">
    <link rel="apple-touch-icon" href="#" sizes="76x76">
    <link rel="apple-touch-icon" href="#" sizes="114x114">
    <link rel="apple-touch-icon" href="#" sizes="120x120">
    <link rel="apple-touch-icon" href="#" sizes="144x144">
    <link rel="apple-touch-icon" href="#" sizes="152x152">
    <link rel="apple-touch-icon" href="#" sizes="180x180">
    <!-- /AppleTouch Icons -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('../css/theme.css')}}">
    <link rel="stylesheet" href="{{asset('../css/demo.css')}}">
    <link rel="stylesheet" href="{{asset('../components/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('../css/jquery.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('../css/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('../css/jquery-confirm.css')}}" />
    
    <link rel="stylesheet" href="{{asset('../css/buttons.dataTables.min.css')}}" />
    <!-- /Styles -->
    
    <!-- Plugins -->
    <link rel="stylesheet" href="{{asset('../plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">   
    <!-- /Plugins -->

</head>
<body class="sidebar-style expanded">

    <!-- NAVIGATION: Top Menu -->
    <nav class="navbar navbar-fixed-top top-menu">
        <div class="container-fluid">

            <!-- Navigation header -->
            <div class="navbar-header">

                <!-- Collapse button -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- /Collapse button -->

                <!-- Brand -->
                <a href="#" class="navbar-brand navbar-brand-cover">
                    <div class="navbar-brand-big" style="text-align: center;width: 100%;">
                        <img src="{{url('../images/logo.png')}}" alt="logo apuesta total" style="height: 40px;padding-top:5px;">
                    </div>
                    <div class="navbar-brand-small">
                        <img src="{{url('../images/logoat.jpg')}}" alt="logo apuesa total" style="height: 49px;">
                    </div>
                </a>
                <!-- /Brand -->

            </div>
            <!-- /Navigation header -->

            <!-- Top Menu (Not Collapsed) -->
            <div class="navbar-top">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#" class="sidebar-collapse">
                            <i class="icon icon-inline fa fa-toggle-left muted"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /Top Menu (Not Collapsed) -->

            <!-- Top menu -->
            <div id="navbar" class="navbar-collapse collapse">

                <!-- Right menu -->
                <ul class="nav navbar-nav navbar-right">

                    <!-- Buttons -->                    
                    <!-- /Buttons -->

                    <!-- Profile -->
                    <li class="dropdown">

                        <!-- Profile avatar -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div class="profile-avatar circle">
                                <img src="{{url('../images/avatar-louis-hawkins.jpg')}}" alt="Louis Hawkins">
                            </div>
                            <span class="user-name userNAME"></span>
                        </a>
                        <!-- /Profile avatar -->

                        <!-- Profile dropdown menu -->
                        <ul class="dropdown-menu dropdown-menu-right">                        
                            <li><a href="{{ route('LogOutCC') }}"><i class="icon icon-inline fa fa-sign-out"></i> Salir</a></li>
                        </ul>
                        <!-- /Profile dropdown menu -->

                    </li>
                    <!-- /Profile -->

                </ul>
                <!-- /Right menu -->

            </div>
            <!-- /Top menu -->

        </div>
    </nav>
    <!-- /NAVIGATION: Top Menu -->
    

    <!-- MAIN CONTAINER -->
    <main class="main-container">

        <!-- SIDEBAR LEFT -->
        <div class="sidebar">

            <!-- Scrollable -->
            <div class="height100p custom-scroll">

                <!-- SIDEBAR PROFILE -->
                <div class="sidebar-profile">

                    <!-- Profile Avatar -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="avatar avatar-lg">
                            <img src="{{'../images/avatar-louis-hawkins.jpg'}}" alt="Louis Hawkins">                        

                        </div>
                    </a>
                    <!-- /Profile Avatar -->

                    <!-- User Information -->
                    <div class="user-info">
                        <div class="name userNAME"> </div>
                        <div class="post perfilNAME"></div>
                    </div>
                    <!-- /User Information -->
                    

                </div>
                <!-- /SIDEBAR PROFILE -->

                <!-- SIDEBAR NAVIGATION -->
                <ul class="nav-sidebar">

                    <li class="sub active">
                        <a href="#" class="sub-toggle">
                            <i class="icon icon-inline icon-inline fa fa-clock-o"></i> <span class="title"> Sorteos</span>
                        </a>
                        <ul class="sub-menu collapse" data-menu-title="Dashboard">
                            <li><a href="{{ url('ListadoSorteo') }}"><i class="icon icon-inline fa fa-circle-thin"></i> <span class="title">Listado Sorteos</span></a></li>
                            <li><a href="{{ url('NuevoSorteo') }}"><i class="icon icon-inline fa fa-circle-thin"></i> <span class="title">Nuevo Sorteo</span></a></li>
                        </ul>
                    </li>
                    <li class="sub">
                        <a href="#" class="sub-toggle">
                            <i class="icon icon-inline icon-inline fa fa-gears"></i> <span class="title"> Soporte</span>
                        </a>
                        <ul class="sub-menu collapse" data-menu-title="Dashboard">
                            <li><a href="{{ url('EditarClienteVista') }}"><i class="icon icon-inline fa fa-circle-thin"></i> <span class="title">Datos Cliente</span></a></li>
                        </ul>
                    </li>
                    <!-- <li><a href="{{ url('sorteos') }}"><i class="icon icon-inline fa fa-mail-forward"></i> <span class="title">Sorteos</span></a></li> -->

                    <li class="sub">
                        <a href="#" class="sub-toggle">
                            <i class="icon icon-inline fa fa-line-chart"></i> <span class="title">Reportes</span>
                        </a>
                        <ul class="sub-menu collapse" data-menu-title="Icons">
                            <li><a href="{{ url('ReporteClientes') }}"><i class="icon icon-inline fa fa-circle-thin"></i> <span class="title">Reporte Clientes</span></a></li>
                            <li><a href="{{ url('ReporteGanadores') }}"><i class="icon icon-inline fa fa-circle-thin"></i> <span class="title">Reporte Ganadores</span></a></li>
                            <li><a href="{{ url('ReporteClientesConsulta') }}"><i class="icon icon-inline fa fa-circle-thin"></i> <span class="title">Reporte Consulta Clientes</span></a></li>
                            <li><a href="{{ url('ReporteOpcionesSorteos') }}"><i class="icon icon-inline fa fa-circle-thin"></i> <span class="title">Reporte Sorteos</span></a></li>
                            <li><a href="{{ url('ReporteLocales') }}"><i class="icon icon-inline fa fa-circle-thin"></i> <span class="title">Reporte Locales</span></a></li>                            
                        </ul>
                    </li>
                    <li class="sub">
                        <a href="#" class="sub-toggle">
                            <i class="icon icon-inline fa fa-gear"></i> <span class="title">Seguridad</span>
                        </a>
                        <ul class="sub-menu collapse" data-menu-title="Icons">
                            <li><a href="{{ url('ListadoAuditoria') }}"><i class="icon icon-inline fa fa-eye"></i> <span class="title">Auditoria</span></a></li>
                            <li><a href="{{ url('ListdoPermisos') }}"><i class="icon icon-inline fa fa-exclamation"></i> <span class="title">Permisos</span></a></li>
                            <li><a href="{{ url('UsuarioListar') }}"><i class="icon icon-inline fa fa-exclamation"></i> <span class="title">Usuario</span></a></li>
                        </ul>
                    </li>                    
                    <li><a href="{{ url('EditarTerminosCondiciones') }}"><i class="icon icon-inline fa fa-commenting"></i> <span class="title">Terminos y Cond.</span></a></li>
                </ul>
                <!-- /SIDEBAR NAVIGATION -->

            </div>
            <!-- /Scrollable -->

            <!-- Bottom Bar -->
           

            <!-- /SIDEBAR PROFILE -->
            <!-- /Bottom Bar -->


        </div>
        <!-- /SIDEBAR LEFT -->

        <!-- CONTENT AREA -->
        <div class="content container-fluid">
            @yield('content')  
        </div>
        <!-- /CONTENT AREA -->

    </main>
    <!-- /MAIN CONTAINER -->


    <!-- SCRIPTS -->
    <script src="{{asset('../js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{asset('../components/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('../js/bootstrap.min.js')}}" ></script>
    <script src="{{asset('../js/moment-with-locales.js')}}" ></script>
    <script src="{{asset('../js/jquery.mCustomScrollbar.concat.min.js')}}" ></script>
    <script src="{{asset('../js/jquery.stellar.min.js')}}" ></script>
    <script src="{{asset('../js/jquery.magnific-popup.min.js')}}" ></script>
    <script src="{{asset('../js/pnotify.custom.min.js')}}" ></script>
    <script src="{{asset('../js/owl.carousel.min.js')}}" ></script>
    <script src="{{asset('../js/jquery.validate.min.js')}}" ></script>
    <script src="{{asset('../js/jquery.animateNumber.min.js')}}" ></script>
    <script src="{{asset('../js/Chart.min.js')}}" ></script>
    <script src="{{asset('../js/sweetalert.min.js')}}" ></script>
    <script src="{{asset('../js/circle-progress.min.js')}}" ></script>
    <script src="{{asset('../components/jstree/jstree.min.js')}}" ></script>
    <script src="{{asset('../components/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('../components/loadingoverlay/loadingoverlay.min.js')}}"></script>
    <script src="{{asset('../js/fullcalendar.min.js')}}" ></script>
    <script src="{{asset('../js/general.js')}}"></script>
    <script src="{{asset('../js/funciones.js')}}"></script>
    <script src="{{asset('../js/demo.js')}}" ></script>
    <script src="{{asset('../plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" ></script>
    <script src="{{asset('../js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('../js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('../js/select2.full.js')}}" ></script>
    <script src="{{asset('../js/jquery-confirm.js')}}"></script>
    
    <!-- datatables exportar-->
    <script src="{{asset('../js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('../js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('../js/jszip.min.js')}}"></script>
    <script src="{{asset('../js/pdfmake.min.js')}}"></script>
    <script src="{{asset('../js/vfs_fonts.js')}}"></script>
    <script src="{{asset('../js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('../js/buttons.print.min.js')}}"></script>
    <!-- fin datatables exportar-->  

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-91610825-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-91610825-2');
    </script>

    @yield('scripts')   
    <!-- /SCRIPTS -->

    <!-- Yandex.Metrika counter --> 
    <!-- <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter35435255 = new Ya.Metrika({ id:35435255, clickmap:true, trackLinks:true, accurateTrackBounce:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "../../../mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/35435255" style="position:absolute; left:-9999px;" alt="" /></div></noscript> /Yandex.Metrika counter -->

</body>

<!-- Mirrored from vtdes.ru/demo/caspero/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Jan 2019 13:57:04 GMT -->
</html>