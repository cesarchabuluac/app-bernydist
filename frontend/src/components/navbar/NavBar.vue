<template>
    <div>
        <header class="color-dark header-black">
            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-menu">
                                <div class="menu-left">
                                    <div class="brand-logo">
                                        <router-link to="/" class="nav-item nav-link">
                                           <img id="header-logo" src="https://berny.mx/assets/img/logo-black.png" class="img-fluid d-none d-sm-block" alt="Berny Distribuidora">
                                        </router-link>                                
                                        <router-link to="/" class="nav-item nav-link">
                                            <img id="header-logo" src="https://berny.mx/assets/img/logo-black-b.png" class="img-fluid_ d-xl-none d-xs-none d-sm-none" alt="" style="height: 32px!important; width:32px!important;">
                                        </router-link>
                                    </div>
                                </div>
                                <div class="d-none d-md-none d-lg-block d-xl-block">
                                    <form class="formulario-busqueda-2 form_search" role="form" id="formulario-busqueda-top">
                                        <input name="query" id="searchHeader" type="search" placeholder="Producto a buscar..." class="nav-search nav-search-field" aria-expanded="true">
                                        <button type="submit" name="nav-submit-button" class="btn-search">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="menu-right pull-right ">
                                    <div>
                                        <div class="icon-nav k d-block d-md-block d-lg-block d-xl-none">
                                            <ul>
                                                <li><a href="#" onclick="showTopSearchForm()" class="btn btn-main-menu-custom d-block d-sm-block d-md-block d-xl-none d-lg-none"><i class="fa fa-search"></i></a></li>
                                                                                            <li><a href="https://berny.mx/pages/login" class="btn btn-main-menu-custom"><i class="fa fa-shopping-cart"></i> $0.00</a></li>
                                                                                        <li>
                                                    <a href="#" class="modal-video" title="Como realizar tu primera compra." data-toggle="modal" data-target="#modal-video"><i style="color:#f2b02c;" class="fa fa-2x fa-play-circle"></i></a>
                                                </li>
                                                <li><a href="https://berny.mx/tienda" class="btn btn-main-menu-custom">Tienda</a></li>
                                                <li><a href="#" onclick="openRightMenu()" class="btn btn-main-menu-custom">Menú</a></li>

                                                <!--<li><a href="#" class='btn btn-main-menu-custom toggle-nav'>Menú</a></li>-->
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- <div class="toggle-nav">
                                        <i class="fa fa-bars sidebar-bar"></i>
                                    </div> -->

                                    <div>
                                        <div class="icon-nav d-none d-xl-block">
                                            <!-- Horizontal menu -->
                                            <ul>
                                                                                            <li class="mobile-account">
                                                        <a class="btn btn-orange" href="https://berny.mx/pages/distributed">Quiero ser distribuidor</a>
                                                    </li>
                                                    <li class="onhover-div">
                                                        <a href="https://berny.mx/pages/login" class="btn btn-main-menu-custom">
                                                            <i class="fa fa-user"></i> Ingresar
                                                        </a>
                                                    </li>

                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-nav-center">
                                <nav id="main-nav">
                                    <ul id="main-menu" class="sm dark pixelstrap sm-horizontal" data-smartmenus-id="16382126005065886">
                                        <li><a href="https://berny.mx/" class="main-menu-item ">Inicio</a></li>
                                        <li><a href="https://berny.mx/tienda" class="main-menu-item ">Tienda</a></li>

                                        <li><a href="https://berny.mx/pages/empresa" class="main-menu-item ">Nosotros</a></li>
                                                                        <li><a href="https://berny.mx/pages/contacto" class="main-menu-item ">Contacto</a></li>
                                        <li><a href="https://berny.mx/info/blog" class="main-menu-item ">Blog</a></li>
                                        <li><a href="https://berny.mx/info/faq" class="main-menu-item ">Ayuda</a></li>                                
                                        <li class="d-block d-xl-none">
                                            <a href="https://berny.mx/pages/distributed">Quiero ser distribuidor</a>
                                        </li>                                
                                                                            <li><a href="https://berny.mx/pages/login" class="main-menu-item "><i class="fa fa-shopping-cart"></i> $0.00</a></li>
                                            <li class="d-xl-none d-lg-none d-md-block d-sm-block">
                                                <a href="https://berny.mx/pages/login" class="main-menu-item "> Ingresar</a>
                                            </li>
                                                                                                        
                                                                            <li>
                                            <a href="#" class="modal-video" title="Como realizar tu primera compra." data-toggle="modal" data-target="#modal-video"><i class="fa fa-2x fa-play-circle"></i></a>
                                        </li>
                                        <li>
                                            <div class="mobile-back text-right">Volver<i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-nav-center">
                                <nav id="main-nav">


                                    <form class="form_search form_header_sticky formulario-busqueda-2 text-center" role="form" id="formulario-busqueda-top-sticky" style="display:none">
                                        <button onclick="hideTopSearchForm()" name="nav-submit-button" class="btn-search" style="position:relative; right:2px; width: 30px; height: 28px; vertical-align: middle;">
                                            <i class="fa fa-close"></i>
                                        </button>
                                        <!-- <input name="query" type="search" class="d-none select-hidden-input" aria-expanded="true">
                                        <input class="select2-busqueda " multiple  style="width:72%;" type="submit"> -->
                                        <input name="query" id="searchHeader" type="search" placeholder="Producto a buscar..." class="nav-search nav-search-field" aria-expanded="true" style="width:72%;">

                                        <button type="submit" name="nav-submit-button" class="btn-search" style="position:relative; left:2px; width: 30px; height: 28px; vertical-align: middle;">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>

                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <header id="custom-sticky-header" class="color-dark header-black fixed-top d-none">
            <div>
                <div class="container-fluid">
                    <div class="row p-2">
                        <div class="col-md-12">
                            <div class="main-menu">
                                <div class="menu-left">
                                    <div class="brand-logo-custom">
                                        <!-- <a href="https://berny.mx/"> <img id="header-logo" src="https://berny.mx/assets/img/logo-black.png" class="img-fluid d-block d-md-block d-lg-block d-xl-none d-xs-none" alt=""></a> -->
                                        <a href="https://berny.mx/"> <img id="header-logo" src="https://berny.mx/assets/img/logo-black.png" class="img-fluid_ d-none d-sm-block" height="50" alt="Berny Distribuidora"></a>
                                        <a href="https://berny.mx/"> <img id="header-logo" src="https://berny.mx/assets/img/logo-black-b.png" class="img-fluid_ d-xl-none d-xs-none d-sm-none" height="50" alt="Berny Distribuidora"></a>
                                    </div>
                                </div>
                                <div class="d-none d-md-none d-lg-block d-xl-block">
                                    <form class="formulario-busqueda-2 form_search" role="form" id="formulario-busqueda-top">
                                        <input name="query" id="searchHeader" type="search" placeholder="Producto a buscar..." class="nav-search nav-search-field" aria-expanded="true">
                                        <button type="submit" name="nav-submit-button" class="btn-search">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="menu-right pull-right">
                                    <div>
                                        <div class="icon-nav k p-0">
                                            <ul>
                                                <li><a href="#" onclick="showTopSearchForm()" class="btn btn-main-menu-custom d-block d-sm-block d-md-block d-xl-none d-lg-none"><i class="fa fa-search"></i></a></li>
                                                                                            <li><a href="https://berny.mx/pages/login/general" class="btn btn-main-menu-custom"><i class="fa fa-shopping-cart"></i> $0.00</a></li>
                                                                                        <li>
                                                    <a href="#" class="modal-video" data-toggle="modal" data-target="#modal-video" title="Como realizar tu primera compra."><i style="color:#f2b02c;" class="fa fa-2x fa-play-circle"></i></a>
                                                </li>
                                                <li><a href="https://berny.mx/tienda" class="btn btn-main-menu-custom">Tienda</a></li>
                                                <li><a href="#" onclick="openRightMenu()" class="btn btn-main-menu-custom">Menu</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-nav-center">
                                <nav id="main-nav">


                                    <form class="form_search form_header_sticky formulario-busqueda-2 text-center" role="form" id="formulario-busqueda-top-sticky-2" style="display:none">
                                        <!-- <input name="query" type="search" class="d-none select-hidden-input" aria-expanded="true">
                                        <input class="select2-busqueda " multiple  style="width:84%;" type="submit">
                                        <button type="submit" name="nav-submit-button" class="btn-search">
                                            <i class="fa fa-search"></i>
                                        </button> -->

                                        <a href="#" title="Producto a buscar..." onclick="hideTopSearchForm()" name="nav-submit-button" class="btn-search" style="position:relative; right:2px; width: 30px; height: 28px; vertical-align: middle;">
                                            <i class="fa fa-close"></i>
                                        </a>
                                        <!-- <input name="query" type="search" class="d-none select-hidden-input" aria-expanded="true">
                                        <input class="select2-busqueda " multiple  style="width:72%;" type="submit"> -->

                                        <input name="query" id="searchHeader" type="search" placeholder="Producto a buscar..." class="nav-search nav-search-field" aria-expanded="true" style="width:72%;">

                                        <button type="submit" name="nav-submit-button" class="btn-search" style="position:relative; left:2px; width: 30px; height: 28px; vertical-align: middle;">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>

                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="dark navbar" style="padding: 0px 0px 0px 0px;">
            <div id="customRightMenu" class="color-dark dark setting-box" style="background-color: black;">
                <a href="#" class="overlay" onclick="closeRightMenu()"></a>
                <nav>
                    <ul id="sub-menu" class="sm pixelstrap sm-vertical" style="background-color: black; margin-top: 24px;" data-smartmenus-id="16382126005070962">
                        <li><a href="https://berny.mx/" class="main-menu-item ">Inicio</a></li>
                        <li><a href="https://berny.mx/tienda" class="main-menu-item ">Tienda</a></li>
                        <li><a href="https://berny.mx/pages/empresa" class="main-menu-item ">Nosotros</a></li>
                                        <li><a href="https://berny.mx/pages/contacto" class="main-menu-item ">Contacto</a></li>
                        <li><a href="https://berny.mx/info/blog" class="main-menu-item ">Blog</a></li>
                        <li><a href="https://berny.mx/info/faq" class="main-menu-item ">Ayuda</a></li>
                        <li class="d-block d-xl-none">
                            <a href="pages/distributed">Quiero ser distribuidor</a>
                        </li>
                                            <li><a href="https://berny.mx/pages/login/general" class="main-menu-item "><i class="fa fa-shopping-cart"></i> $0.00</a></li>
                                                            <li>
                                <a href="https://berny.mx/pages/login" class="main-menu-item"><i class="fa fa-user"></i> Ingresar</a>
                            </li>
                                    </ul>
                    <div onclick="closeRightMenu()">
                        <div class="sidebar-back text-left">
                            <i class="fa fa-angle-left pr-2" aria-hidden="true"></i> Volver
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>

import Logotype from '@/assets/img/logo-black-b.png'
export default {
    data() {
        return {
            logoBerny: Logotype
        };
    },
};
</script>
