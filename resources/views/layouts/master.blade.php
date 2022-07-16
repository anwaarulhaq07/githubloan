<!DOCTYPE html>
<html lang="en">

<head>
    <style>

    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('./assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('./assets/images/favicon.png') }}" type="image/x-icon">
    <title>Loan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@3.2/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css"
        rel="stylesheet" />

    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/fontawesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/feather-icon.css')}}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/chartist.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/date-picker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/prism.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/vector-map.css')}}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{asset('./assets/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{asset('./assets/css/responsive.css')}}">
    <link href="{{ asset('./css/custom.css') }}" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="theme-loader">
            <div class="loader-p"></div>
        </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start       -->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-main-header">
            <div class="main-header-right row m-0">
                <div class="main-header-left">
                    <div class="logo-wrapper"><a href="{{route('admin.home')}}"><img class="img-fluid"
                                src="{{asset('./assets/images/logo/png logo.png')}}" alt=""></a></div>
                    <div class="toggle-sidebar ml-4"><i class="status_toggle middle" data-feather="align-center"
                            id="sidebar-toggle"></i></div>
                </div>
                <div class="left-menu-header col">
                    <!-- <ul>
                        <li>
                            <form class="form-inline search-form">
                                <div class="search-bg"><i class="fa fa-search"></i>
                                    <input class="form-control-plaintext" placeholder="Search here.....">
                                </div>
                            </form><span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
                        </li>
                    </ul> -->
                </div>
                <div class="nav-right col pull-right right-menu p-0">
                    <ul class="nav-menus">
                        <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i
                                    data-feather="maximize"></i></a></li>

                        <li class="onhover-dropdown p-0">
                            <button class="btn btn-primary-light" type="button"><a
                                    href="{{route('logout') }}">Logout</a></button>
                        </li>
                        <button type="button" class="btn btn-primary-light" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item btn btn-warning" href="#">
                                    @php
                                    $user = Auth::user();
                                    $user_role_id = Illuminate\Support\Facades\DB::table('role_user')->where('user_id',$user->id)->pluck('role_id')->first();
                                    $user = App\Models\Role::where('id',$user_role_id)->pluck('title')->first();
                                    @endphp
                                    {{$user}}
                                </a></li>
                        </ul>
                    </ul>

                </div>
                <div class="btn-group">

                </div>
                <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
            </div>
        </div>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper sidebar-icon">
            <!-- Page Sidebar Start-->
            <header class="main-nav">
                <div class="sidebar-user text-center">


                </div>
                <nav>
                    <div class="main-navbar">
                        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                        <div id="mainnav">
                            <ul class="nav-menu custom-scrollbar">
                                <li class="back-btn">
                                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                            aria-hidden="true"></i></div>
                                </li>

                                <li class="dropdown"><a class="nav-link menu-title"><i
                                            data-feather="home"></i><span>Dashboard</span></a>
                                    <!-- <ul class="nav-submenu menu-content">
                                        <li><a href="{{route('admin.bank_index') }}">Bank</a></li>
                                    </ul> -->
                                </li>
                                <li class="dropdown"><a class="nav-link menu-title"
                                        href="{{route('admin.bank_index') }}"><i
                                            data-feather="airplay"></i><span>Bank</span></a></li>

                                {{-- @if(auth()->user()->Role == 'Admin')
                                { --}}
                                <li class="dropdown"><a class="nav-link menu-title"><i
                                            data-feather="airplay"></i><span>Management</span></a>
                                    <ul class="nav-submenu menu-content">

                                        <li><a href="{{route('admin.permissions.index') }}">Permissions</a></li>
                                        <li><a href="{{route('admin.roleindex') }}">Roles</a></li>

                                        <li><a href="{{route('admin.usersindex') }}">User</a></li>
                                    </ul>
                                </li>
                                {{-- } --}}
                                {{-- @endif --}}
                                <li class="dropdown"><a class="nav-link menu-title"
                                        href="{{route('admin.customer_index') }}"><i
                                            data-feather="airplay"></i><span>Customer</span></a></li>
                                <li class="dropdown"><a class="nav-link menu-title"
                                        href="{{route('admin.mortageindex') }}"><i
                                            data-feather="layout"></i><span>Mortgage</span></a></li>
                                <!-- <li class="dropdown"><a class="nav-link menu-title" href="{{route('admin.loancustomerindex') }}"><i data-feather="airplay"></i><span>Loan Customer</span></a></li> -->
                                {{-- <li class="dropdown"><a class="nav-link menu-title" href="{{route('admin.loanindex') }}"><i
                                    data-feather="layout"></i><span>Loan</span></a></li> --}}
                                <li class="dropdown"><a class="nav-link menu-title"
                                        href="{{route('admin.balloon_index') }}"><i
                                            data-feather="layout"></i><span>Commercial Loan</span></a></li>
                                <li class="dropdown"><a class="nav-link menu-title"
                                        href="{{url('profile/password') }}"><i
                                            data-feather="log-out"></i></i></i><span>Change Password</span></a></li>
                                <li class="dropdown"><a class="nav-link menu-title" href="{{route('logout') }}"><i
                                            data-feather="log-out"></i><span>Logout</span></a></li>


                            </ul>
                        </div>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </div>
                </nav>
            </header>
            <!-- Page Sidebar Ends-->
            <div class="page-body">

                @yield('content')

            </div>
            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 footer-copyright">
                            <p class="mb-0"></p>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js">
    </script>
    <script src="https://unpkg.com/@coreui/coreui@3.2/dist/js/coreui.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- latest jquery-->
    <script src="{{asset('./assets/js/jquery-3.5.1.min.js')}}"></script>
    <!-- feather icon js-->
    <script src="{{asset('./assets/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{asset('./assets/js/icons/feather-icon/feather-icon.js')}}"></script>
    <!-- Sidebar jquery-->
    <script src="{{asset('./assets/js/sidebar-menu.js')}}"></script>
    <script src="{{asset('./assets/js/config.js')}}"></script>
    <!-- Bootstrap js-->
    <script src="{{asset('./assets/js/bootstrap/popper.min.js')}}"></script>
    <script src="{{asset('./assets/js/bootstrap/bootstrap.min.js')}}"></script>
    <!-- Plugins JS start-->
    <script src="{{asset('./assets/js/chart/chartist/chartist.js')}}"></script>
    <script src="{{asset('./assets/js/chart/chartist/chartist-plugin-tooltip.js')}}"></script>
    <script src="{{asset('./assets/js/chart/knob/knob.min.js')}}"></script>
    <script src="{{asset('./assets/js/chart/knob/knob-chart.js')}}"></script>
    <script src="{{asset('./assets/js/chart/apex-chart/apex-chart.js')}}"></script>
    <script src="{{asset('./assets/js/chart/apex-chart/stock-prices.js')}}"></script>
    <script src="{{asset('./assets/js/prism/prism.min.js')}}"></script>
    <script src="{{asset('./assets/js/clipboard/clipboard.min.js')}}"></script>
    <script src="{{asset('./assets/js/counter/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('./assets/js/counter/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('./assets/js/counter/counter-custom.js')}}"></script>
    <script src="{{asset('./assets/js/custom-card/custom-card.js')}}"></script>
    <script src="{{asset('./assets/js/notify/bootstrap-notify.min.js')}}"></script>
    <script src="{{asset('./assets/js/vector-map/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('./assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{asset('./assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js')}}"></script>
    <script src="{{asset('./assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js')}}"></script>
    <script src="{{asset('./assets/js/vector-map/map/jquery-jvectormap-au-mill.js')}}"></script>
    <script src="{{asset('./assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js')}}"></script>
    <script src="{{asset('./assets/js/vector-map/map/jquery-jvectormap-in-mill.js')}}"></script>
    <script src="{{asset('./assets/js/vector-map/map/jquery-jvectormap-asia-mill.js')}}"></script>
    <script src="{{asset('./assets/js/dashboard/default.js')}}"></script>
    <script src="{{asset('./assets/js/notify/index.js')}}"></script>
    <script src="{{asset('./assets/js/datepicker/date-picker/datepicker.js')}}"></script>
    <script src="{{asset('./assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
    <script src="{{asset('./assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{asset('./assets/js/script.js')}}"></script>
    <!-- <script src="{{asset('../assets/js/theme-customizer/customizer.js')}}"></script> -->
    <!-- login js-->
    <!-- Plugin used-->
</body>

</html>