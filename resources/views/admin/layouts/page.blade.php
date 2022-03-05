<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>    
    <link rel="stylesheet" href="/themes/adminlte/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/themes/adminlte/vendor/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">    
    <link rel="stylesheet" href="/themes/adminlte/vendor/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">.hide { display: none !important; }</style>
    @yield('css')
</head>

<body class="sidebar-mini" >
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#">
                        <i class="fas fa-bars"></i>
                        <span class="sr-only">Basculer la navigation</span>
                    </a>
                </li>        
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('admin') }}" class="brand-link">
                <span class="brand-text font-weight-light ">
                {{ config('app.name') }}
                </span>
            </a>
            <div class="sidebar">
                <nav class="pt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li>
                            <div class="form-inline my-2">
                            </div>
                        </li>
                        @include('admin.layouts.menu')
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    @if(View::hasSection('content_header'))
                        @yield('content_header')
                    @else
                        <h1>@yield('title')</h1>
                    @endif
                </div>
            </div>
            <div class="content">
               <div class="container-fluid">
                    @include('admin.layouts.error')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/themes/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/themes/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/themes/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/themes/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/themes/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/themes/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/themes/adminlte/plugins/jszip/jszip.min.js"></script>
<script src="/themes/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/themes/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/themes/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/themes/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/themes/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" ></script>
@yield('js')
</html>