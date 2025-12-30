<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=9">
    <meta name="Description" content="APP">
    <meta name="Keywords" content="Movilidad de Manta EP, Manta, Movilidad, EP, Transito">
    <!-- Title -->
    <title> Movilidad-EP</title>
    <!-- Favicon -->
    <link rel="icon" href="/valex/assets/img/logo-movilidad.png" type="image/x-icon">
    <!-- Icons css -->
    <link href="/valex/assets/css/icons.css" rel="stylesheet">
    <!-- Bootstrap css -->
    <link href="/valex/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- style css -->
    <link href="/valex/assets/css/style.css" rel="stylesheet">
    <!--- Animations css-->
    <link href="/valex/assets/css/animate.css" rel="stylesheet">
    <!-- CSS | Datatables-->
    <link href="/valex/assets/css/datatable/datatables.min.css" rel="stylesheet">
    <link href="/valex/assets/css/dropify.css" rel="stylesheet">
    <link href="/valex/assets/css/dropify.min.css" rel="stylesheet">
    <!-- home css -->
    <link href="/valex/assets/css/home.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- custom css -->
    <link href="/css/custom/tooltip.css" rel="stylesheet">

    <script src="https://use.fontawesome.com/4072ce3273.js"></script>
    @yield('css')
</head>

<body class="main-body app sidebar-mini ltr ">
    <!-- Loader -->
    <div id="global-loader">
        <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
        <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
    </div>
    <!-- /Loader -->
    <!-- Page -->
    <div class="page custom-index">
        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="csrf-token">
        <div>
            <!-- main-header -->
            <div class="main-header side-header sticky nav nav-item">
                <div class="container-fluid main-container ">
                    <div class="main-header-left ">
                        <div class="responsive-logo">
                            <a href="index.html" class="header-logo">
                                <img src="/valex/assets/img/logo-movilidad.png" class="logo-1" alt="logo">
                                <img src="/valex/assets/img/logo-movilidad.png" class="dark-logo-1" alt="logo">
                            </a>
                        </div>
                        <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                            <a class="open-toggle" href="javascript:void(0);">
                                <i class="header-icon fe fe-align-left"></i>
                            </a>
                            <a class="close-toggle" href="javascript:void(0);">
                                <i class="header-icons fe fe-x"></i>
                            </a>
                        </div>
                        <div class="main-header-center ms-3 d-sm-none d-md-none d-lg-block none">
                            <input class="form-control" placeholder="Search for anything..." type="search">
                            <button class="btn">
                                <i class="fas fa-search d-none d-md-block"></i>
                            </button>
                        </div>
                    </div>
                    <div class="main-header-right">
                        <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon fe fe-more-vertical "></span>
                        </button>
                        <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
                            <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                <ul class="nav nav-item  navbar-nav-right ms-auto">
                                    <li class="">
                                        <div class="dropdown  nav-item">
                                            <a href="javascript:void(0);" class="d-flex  nav-item nav-link country-flag1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="avatar country-Flag me-0 align-self-center bg-transparent">
                                                    <img src="https://m.media-amazon.com/images/I/51sMyQo0kAL._AC_SX679_.jpg" alt="img">
                                                </span>
                                                <div class="my-auto">
                                                    <strong class="me-2 ms-2 my-auto">English</strong>
                                                </div>
                                            </a>

                                        </div>
                                    </li>
                                    <li class="dropdown nav-item main-layout">
                                        <a class="new nav-link theme-layout nav-link-bg layout-setting">
                                            <span class="dark-layout">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24">
                                                    <path d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z" />
                                                </svg>
                                            </span>
                                            <span class="light-layout">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24">
                                                    <path d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122 1.415 1.414-2.12 2.122zM16.24 6.344l2.122-2.122 1.414 1.414-2.122 2.122zM6.342 7.759 4.22 5.637l1.415-1.414 2.12 2.122zm13.434 10.605-1.414 1.414-2.122-2.122 1.414-1.414z" />
                                                </svg>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-link search-icon d-lg-none d-block">
                                        <form class="navbar-form" role="search">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search">
                                                <span class="input-group-btn">
                                                    <button type="reset" class="btn btn-default">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button type="submit" class="btn btn-default nav-link resp-btn">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" class="header-icon-svgs" viewBox="0 0 24 24" width="24px" fill="#000000">
                                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                                        </svg>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </li>
                                    <!-- <li class="dropdown nav-item main-header-message ">
                                        <a class="new nav-link" href="javascript:void(0);">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                <polyline points="22,6 12,13 2,6"></polyline>
                                            </svg>
                                            <span class=" pulse-danger"></span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <div class="menu-header-content bg-primary text-start">
                                                <div class="d-flex">
                                                    <h6 class="dropdown-title mb-1 tx-15 text-white fw-semibold">
                                                        Messages
                                                    </h6>
                                                    <span class="badge rounded-pill bg-warning ms-auto my-auto float-end">
                                                        Mark
                                                        All Read
                                                    </span>
                                                </div>
                                                <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">
                                                    You have 4 unread messages
                                                </p>
                                            </div>
                                            <div class="main-message-list chat-scroll">
                                                <a href="javascript:void(0);" class="p-3 d-flex border-bottom">
                                                    <div class="  drop-img  cover-image  " data-bs-image-src="/valex/assets/img/faces/3.jpg">
                                                        <span class="avatar-status bg-teal"></span>
                                                    </div>
                                                    <div class="wd-90p">
                                                        <div class="d-flex">
                                                            <h5 class="mb-1 name">Petey Cruiser</h5>
                                                        </div>
                                                        <p class="mb-0 desc">
                                                            I'm sorry but i'm not sure how to help you
                                                            with that......
                                                        </p>
                                                        <p class="time mb-0 text-start float-start ms-2 mt-2">
                                                            Mar 15
                                                            3:55 PM
                                                        </p>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0);" class="p-3 d-flex border-bottom">
                                                    <div class="drop-img cover-image" data-bs-image-src="/valex/assets/img/faces/2.jpg">
                                                        <span class="avatar-status bg-teal"></span>
                                                    </div>
                                                    <div class="wd-90p">
                                                        <div class="d-flex">
                                                            <h5 class="mb-1 name">Jimmy Changa</h5>
                                                        </div>
                                                        <p class="mb-0 desc">
                                                            All set ! Now, time to get to you
                                                            now......
                                                        </p>
                                                        <p class="time mb-0 text-start float-start ms-2 mt-2">
                                                            Mar 06
                                                            01:12 AM
                                                        </p>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0);" class="p-3 d-flex border-bottom">
                                                    <div class="drop-img cover-image" data-bs-image-src="/valex/assets/img/faces/9.jpg">
                                                        <span class="avatar-status bg-teal"></span>
                                                    </div>
                                                    <div class="wd-90p">
                                                        <div class="d-flex">
                                                            <h5 class="mb-1 name">Graham Cracker</h5>
                                                        </div>
                                                        <p class="mb-0 desc">
                                                            Are you ready to pickup your Delivery...
                                                        </p>
                                                        <p class="time mb-0 text-start float-start ms-2 mt-2">
                                                            Feb 25
                                                            10:35 AM
                                                        </p>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0);" class="p-3 d-flex border-bottom">
                                                    <div class="drop-img cover-image" data-bs-image-src="/valex/assets/img/faces/12.jpg">
                                                        <span class="avatar-status bg-teal"></span>
                                                    </div>
                                                    <div class="wd-90p">
                                                        <div class="d-flex">
                                                            <h5 class="mb-1 name">Donatella Nobatti</h5>
                                                        </div>
                                                        <p class="mb-0 desc">Here are some products ...</p>
                                                        <p class="time mb-0 text-start float-start ms-2 mt-2">
                                                            Feb 12
                                                            05:12 PM
                                                        </p>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0);" class="p-3 d-flex border-bottom">
                                                    <div class="drop-img cover-image" data-bs-image-src="/valex/assets/img/ faces/5.jpg">
                                                        <span class="avatar-status bg-teal"></span>
                                                    </div>
                                                    <div class="wd-90p">
                                                        <div class="d-flex">
                                                            <h5 class="mb-1 name">Anne Fibbiyon</h5>
                                                        </div>
                                                        <p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
                                                        <p class="time mb-0 text-start float-start ms-2 mt-2">
                                                            Jan 29
                                                            03:16 PM
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="text-center dropdown-footer">
                                                <a href="text-center">VIEW ALL</a>
                                            </div>
                                        </div>
                                    </li>-->
                                    <!-- <li class="dropdown nav-item main-header-notification">
                                        <a class="new nav-link" href="javascript:void(0);">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                            </svg>
                                            <span class=" pulse"></span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <div class="menu-header-content bg-primary text-start">
                                                <div class="d-flex">
                                                    <h6 class="dropdown-title mb-1 tx-15 text-white fw-semibold">
                                                        Notificaciones
                                                    </h6>
                                                    <span class="badge rounded-pill bg-warning ms-auto my-auto float-end">
                                                        Marcar
                                                        todas las leidas
                                                    </span>
                                                </div>
                                                <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">
                                                    Tu tienes 4 notificaciones sin leer
                                                </p>
                                            </div>
                                            <div class="main-notification-list Notification-scroll">
                                                <a class="d-flex p-3 border-bottom" href="javascript:void(0);">
                                                    <div class="notifyimg bg-pink">
                                                        <i class="la la-file-alt text-white"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5 class="notification-label mb-1">
                                                            Se agrego a Martha Lorem
                                                        </h5>
                                                        <div class="notification-subtext">2 horas</div>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <i class="las la-angle-right text-end text-muted"></i>
                                                    </div>
                                                </a>
                                                <a class="d-flex p-3 border-bottom" href="javascript:void(0);">
                                                    <div class="notifyimg bg-purple">
                                                        <i class="la la-gem text-white"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5 class="notification-label mb-1">Updates Available</h5>
                                                        <div class="notification-subtext">2 days ago</div>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <i class="las la-angle-right text-end text-muted"></i>
                                                    </div>
                                                </a>
                                                <a class="d-flex p-3 border-bottom" href="javascript:void(0);">
                                                    <div class="notifyimg bg-success">
                                                        <i class="la la-shopping-basket text-white"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5 class="notification-label mb-1">New Order Received</h5>
                                                        <div class="notification-subtext">1 hour ago</div>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <i class="las la-angle-right text-end text-muted"></i>
                                                    </div>
                                                </a>
                                                <a class="d-flex p-3 border-bottom" href="javascript:void(0);">
                                                    <div class="notifyimg bg-warning">
                                                        <i class="la la-envelope-open text-white"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5 class="notification-label mb-1">New review received</h5>
                                                        <div class="notification-subtext">1 day ago</div>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <i class="las la-angle-right text-end text-muted"></i>
                                                    </div>
                                                </a>
                                                <a class="d-flex p-3 border-bottom" href="javascript:void(0);">
                                                    <div class="notifyimg bg-danger">
                                                        <i class="la la-user-check text-white"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5 class="notification-label mb-1">
                                                            22 verified registrations
                                                        </h5>
                                                        <div class="notification-subtext">2 hour ago</div>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <i class="las la-angle-right text-end text-muted"></i>
                                                    </div>
                                                </a>
                                                <a class="d-flex p-3 border-bottom" href="javascript:void(0);">
                                                    <div class="notifyimg bg-primary">
                                                        <i class="la la-check-circle text-white"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5 class="notification-label mb-1">
                                                            Project has been approved
                                                        </h5>
                                                        <div class="notification-subtext">4 hour ago</div>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <i class="las la-angle-right text-end text-muted"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="dropdown-footer">
                                                <a href="">VIEW ALL</a>
                                            </div>
                                        </div>
                                    </li>-->
                                    <!--<li class="nav-item full-screen fullscreen-button">
                                        <a class="new nav-link full-screen-link" href="javascript:void(0);">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize">
                                                <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                                            </svg>
                                        </a>
                                    </li>-->
                                    <li class="dropdown main-profile-menu nav nav-item nav-link">
                                        <a class="profile-user d-flex" href="">
                                            <img alt="" src="/imagenes_empleados/{{ Session::get('ruta_foto') }}">
                                        </a>
                                        <div class="dropdown-menu">
                                            <div class="main-header-profile bg-primary p-3">
                                                <div class="d-flex wd-100p">
                                                    <div class="main-img-user">
                                                        <img alt="" src="/imagenes_empleados/{{ Session::get('ruta_foto') }}" class="">
                                                    </div>
                                                    <div class="ms-3 my-auto">
                                                        <h6>{{ Session::get('nombre') }}</h6>
                                                        <span>{{ Session::get('nombres') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<a class="dropdown-item" href=""><i class="bx bx-user-circle"></i>Profile</a>
                                            <a class="dropdown-item" href=""><i class="bx bx-cog"></i> Edit Profile</a>
                                            <a class="dropdown-item" href=""><i class="bx bxs-inbox"></i>Inbox</a>
                                            <a class="dropdown-item" href=""><i class="bx bx-envelope"></i>Messages</a>
                                            <a class="dropdown-item" href=""><i class="bx bx-slider-alt"></i> Account Settings</a>-->
                                            <a class="dropdown-item" href="/cerrar-sesion">
                                                <i class="bx bx-log-out"></i>
                                                Salir
                                            </a>
                                            <a class="dropdown-item" href="/reset-password">
                                                <i class="mdi mdi-account-key"></i>
                                                Cambiar contraseña
                                            </a>
                                        </div>
                                    </li>
                                    <!--<li class="dropdown main-header-message right-toggle">
                                        <a class="nav-link pe-0" data-bs-toggle="sidebar-right" data-bs-target=".sidebar-right">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                                <line x1="3" y1="18" x2="21" y2="18"></line>
                                            </svg>
                                        </a>
                                    </li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /main-header -->
            <!-- main-sidebar -->
            <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
            <div class="sticky">
                <aside class="app-sidebar sidebar-scroll">
                    <div class="main-sidebar-header active">
                        <a class="desktop-logo logo-light active" href="/home">
                            <img src="/valex/assets/img/logo-movilidad.png" class="img-logo main-logo" alt="logo">
                        </a>
                        <a class="desktop-logo logo-dark active" href="/home">
                            <!--<img src="/valex/assets/img/brand/logo-white.png" class="main-logo" alt="logo">-->
                            <img src="/valex/assets/img/logo-movilidad.png" class="img-logo main-logo" alt="logo">

                        </a>
                        <a class="logo-icon mobile-logo icon-light active" href="/home">
                            <img src="/valex/assets/img/brand/favicon.png" alt="logo">
                        </a>
                        <a class="logo-icon mobile-logo icon-dark active" href="/home">
                            <img src="/valex/assets/img/brand/favicon-white.png" alt="logo">
                        </a>
                    </div>
                    <div class="main-sidemenu">
                        <div class="app-sidebar__user clearfix">
                            <div class="dropdown user-pro-body">
                                <div class="">
                                    <img alt="user-img" class="avatar avatar-xl brround" src="/imagenes_empleados/{{ Session::get('ruta_foto') }}">
                                    <span class="avatar-status profile-status bg-green"></span>
                                </div>
                                <div class="user-info">
                                    <h4 class="fw-semibold mt-3 mb-0">{{ Session::get('nombres') }}</h4>
                                    <span class="mb-0 text-muted">{{ Session::get('apellidos') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="slide-left disabled" id="slide-left">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                            </svg>
                        </div>
                        <ul class="side-menu">
                            <li class="side-item side-item-category">Inicio</li>
                            <li class="slide">
                                <a class="side-menu__item" href="/home">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                                        <path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                                    </svg>
                                    <span class="side-menu__label">Inicio</span>
                                    <span class="badge bg-success text-light" id="bg-side-text">1</span>
                                </a>
                            </li>

                            @foreach(json_decode($menus_) as $m)
                            <li class="slide">
                                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                        <path d="M0 0h24v24H0V0z" fill="none" />
                                        <path d="M5 9h14V5H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5S7.83 8.5 7 8.5 5.5 7.83 5.5 7 6.17 5.5 7 5.5zM5 19h14v-4H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5z" opacity=".3" />
                                        <path d="M20 13H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1zm-1 6H5v-4h14v4zm-12-.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zM20 3H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zm-1 6H5V5h14v4zM7 8.5c.83 0 1.5-.67 1.5-1.5S7.83 5.5 7 5.5 5.5 6.17 5.5 7 6.17 8.5 7 8.5z" />
                                    </svg>
                                    <span class="side-menu__label">{{$m->menu}}</span>
                                    <i class="angle fe fe-chevron-down"></i>
                                </a>
                                <ul class="slide-menu">
                                    @foreach($m->submenu as $sm)
                                    <li>
                                        <a class="slide-item" href="{{$sm->sme_link}}">{{$sm->sme_submenu}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach


                        </ul>
                        </li>
                        </ul>
                        <div class="slide-right" id="slide-right">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                            </svg>
                        </div>
                    </div>
                </aside>
            </div>
            <!-- main-sidebar -->
        </div>
        <!-- main-content -->
        <div class="main-content app-content">
            <!-- container -->
            <div class="main-container container-fluid">
                @yield('content')
            </div>
            <!-- /Container -->
        </div>
        <!-- /main-content -->
        <!-- Footer opened -->
        <div class="footer-section footer footer-dark">
            <div class="container-fluid pd-t-0 ht-100p">
                <span>
                    Copyright © 2023
                    <a href="www.sgi.movilidadmanta.gob.ec" class="text-primary">
                        Movilidad EP
                    </a>
                    <span class="fa fa-heart text-danger"> Diseñado</span>
                    por
                    <a href="www.movilidadmanta.gob.ec">
                        TIC Movilidad EP
                    </a>
                    Todos los derechos reservados.
                </span>
            </div>
        </div>
        <!-- Footer closed -->
    </div>
    <!-- End Page -->
    <!-- Back-to-top -->
    <a href="#top" id="back-to-top">
        <i class="las la-angle-double-up"></i>
    </a>
    <!-- JQuery min js -->
    <script src="/valex/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/valex/assets/plugins/jquery-ui/ui//widgets/datepicker.js"></script>
    <script src="/valex/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap Bundle js -->
    <script src="/valex/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="/valex/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <script src="/valex/assets/plugins/jquery.flot/jquery.flot.js"></script>
    <script src="/valex/assets/plugins/jquery.flot/jquery.flot.pie.js"></script>
    <script src="/valex/assets/plugins/jquery.flot/jquery.flot.resize.js"></script>
    <!--Internal  Chart.bundle js -->
    <script src="/valex/assets/plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Bootstrap Autocomplete js -->
    <script src="/valex/assets/js/custom/input-search-custom.js"></script>
    <script src="/valex/assets/js/custom/input-values-types.js"></script>
    <script src="/valex/assets/js/custom/input-validation.js"></script>
    <script src="/valex/assets/js/custom/input-select-two-dates.js"></script>
    <script src="/valex/assets/js/custom/construct-table.js"></script>
    <!--Internal  Chart.bundle js
    <script src="/valex/assets/plugins/chart.js/Chart.bundle.min.js"></script>-->
    <!-- Moment js -->
    <script src="/valex/assets/plugins/moment/moment.js"></script>
    <!--Internal Sparkline js -->
    <script src="/valex/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- Moment js -->
    <script src="/valex/assets/plugins/raphael/raphael.min.js"></script>
    <!--Internal Apexchart js
    <script src="/valex/assets/js/apexcharts.js"></script>-->
    <!-- Rating js-->
    <script src="/valex/assets/plugins/ratings-2/jquery.star-rating.js"></script>
    <script src="/valex/assets/plugins/ratings-2/star-rating.js"></script>
    <!--Internal  Perfect-scrollbar js -->
    <script src="/valex/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/valex/assets/plugins/perfect-scrollbar/p-scroll.js"></script>
    <!-- Eva-icons js -->
    <script src="/valex/assets/js/eva-icons.min.js"></script>
    <!-- right-sidebar js -->
    <script src="/valex/assets/plugins/sidebar/sidebar.js"></script>
    <script src="/valex/assets/plugins/sidebar/sidebar-custom.js"></script>
    <!-- Sticky js -->
    <script src="/valex/assets/js/sticky.js"></script>
    <script src="/valex/assets/js/modal-popup.js"></script>
    <!-- Left-menu js-->
    <script src="/valex/assets/plugins/side-menu/sidemenu.js"></script>
    <!-- Internal Map -->
    <script src="/valex/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/valex/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!--Internal  index js -->
    <script src="/valex/assets/js/index.js"></script>
    <!--themecolor js-->
    <script src="/valex/assets/js/themecolor.js"></script>
    <!-- Apexchart js
    <script src="/valex/assets/js/apexcharts.js"></script>
    <script src="/valex/assets/js/jquery.vmap.sampledata.js"></script>-->
    <!-- custom js -->
    <script src="/valex/assets/js/custom.js"></script>
    <!-- P-scroll js
    <script src="/valex/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/valex/assets/plugins/perfect-scrollbar/p-scroll.js"></script>-->
    <!--Internal  Notify js -->
    <script src="/valex/assets/plugins/notify/js/notifIt.js"></script>
    <script src="/valex/assets/plugins/notify/js/notifit-custom.js"></script>
    <!-- Datatables -->
    <script src="/valex/assets/js/datatable/datatables.min.js"></script>
    <!--Internal Fileuploads js-->
    <script src="/valex/assets/js/dropify.js"></script>
    <script src="/valex/assets/js/dropify.min.js"></script>
    <script src="/valex/assets/js/form-validation.js"></script>
    <script src="/valex/assets/js/sweetalert2.js"></script>
    <!--<script src='/server.js'></script>-->
    <!--<script src='http://localhost/movilidad-web/app-web/server.js'></script>
    <script src='http://164.92.149.114/app-web/server.js'></script>-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @yield('js')
</body>

</html>