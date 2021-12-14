<template>
    <div id="app">
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
                                                <li><a href="#" class="btn btn-main-menu-custom d-block d-sm-block d-md-block d-xl-none d-lg-none"><i class="fa fa-search"></i></a></li>
                                                <li><a href="https://berny.mx/pages/login" class="btn btn-main-menu-custom"><i class="fa fa-shopping-cart"></i> $0.00</a></li>
                                                <li><a href="#" class="modal-video" title="Como realizar tu primera compra." data-toggle="modal" data-target="#modal-video"><i style="color:#f2b02c;" class="fa fa-2x fa-play-circle"></i></a></li>
                                                <li><a href="https://berny.mx/tienda" class="btn btn-main-menu-custom">Tienda</a></li>
                                                <li><a href="#" onclick="openRightMenu()" class="btn btn-main-menu-custom">Menú</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="icon-nav d-none d-xl-block">
                                            <!-- Horizontal menu -->
                                            <ul>
                                                <li class="mobile-account">                                                    
                                                     <router-link :to="{ path: '/pages/distributed' }" class="btn btn-orange">Quiero ser distribuidor</router-link>
                                                </li>
                                                <li class="onhover-div">
                                                    <router-link :to="{ path: '/pages/login' }" class="btn btn-main-menu-custom">  <i class="fa fa-user"></i> Ingresar</router-link>
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
                                    <ul id="main-menu" class="sm dark pixelstrap sm-horizontal">
                                        <li>                                            
                                            <router-link :to="{ path: '/' }"  class="main-menu-item ">Inicio</router-link>
                                        </li>
                                        <li><a href="https://berny.mx/tienda" class="main-menu-item ">Tienda</a></li>

                                        <li>
                                            <router-link :to="{ path: '/pages/empresa' }">Nosotros</router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{ path: '/pages/contacto' }">Contacto</router-link>
                                        </li>
                                        <li><a href="https://berny.mx/info/blog" class="main-menu-item ">Blog</a></li>
                                        <li><a href="https://berny.mx/info/faq" class="main-menu-item ">Ayuda</a></li>                                
                                        <li class="d-block d-xl-none">                                            
                                            <router-link :to="{ path: '/pages/distributed' }">Quiero ser distribuidor</router-link>
                                        </li>                                
                                        <li><a href="https://berny.mx/pages/login" class="main-menu-item "><i class="fa fa-shopping-cart"></i> $0.00</a></li>
                                        <li class="d-xl-none d-lg-none d-md-block d-sm-block">
                                            <router-link :to="{ path: '/pages/login' }"  class="main-menu-item ">Ingresar</router-link>
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
                                                <li><a href="#" class="modal-video" data-toggle="modal" data-target="#modal-video" title="Como realizar tu primera compra."><i style="color:#f2b02c;" class="fa fa-2x fa-play-circle"></i></a></li>
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
                                        <a href="#" title="Producto a buscar..." name="nav-submit-button" class="btn-search" style="position:relative; right:2px; width: 30px; height: 28px; vertical-align: middle;">
                                            <i class="fa fa-close"></i>
                                        </a>
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
                <a href="#" class="overlay"></a>
                <nav>
                    <ul id="sub-menu" class="sm pixelstrap sm-vertical" style="background-color: black; margin-top: 24px;">
                        <li>                            
                            <router-link :to="{ path: '/' }"  class="main-menu-item ">Inicio</router-link>
                        </li>
                        <li><a href="https://berny.mx/tienda" class="main-menu-item ">Tienda</a></li>
                        <li>                            
                            <router-link :to="{ path: '/pages/nosotros' }"  class="main-menu-item ">Nosotros</router-link>
                        </li>
                        <li>                            
                            <router-link :to="{ path: '/pages/contacto' }"  class="main-menu-item ">Contacto</router-link>
                        </li>
                        <li><a href="https://berny.mx/info/blog" class="main-menu-item ">Blog</a></li>
                        <li><a href="https://berny.mx/info/faq" class="main-menu-item ">Ayuda</a></li>
                        <li class="d-block d-xl-none">                            
                            <router-link :to="{ path: '/pages/distributed' }">Quiero ser distribuidor</router-link>
                        </li>
                        <li><a href="https://berny.mx/pages/login/general" class="main-menu-item "><i class="fa fa-shopping-cart"></i> $0.00</a></li>
                        <li>                            
                            <router-link :to="{ path: '/pages/login' }"  class="main-menu-item ">Ingresar</router-link>
                        </li>
                    </ul>
                    <div>
                        <div class="sidebar-back text-left">
                            <i class="fa fa-angle-left pr-2" aria-hidden="true"></i> Volver
                        </div>
                    </div>
                </nav>
            </div>
        </div>

       <router-view/>

        <!-- Footer -->
        <footer>
            <section class="section-b-space darken-layout">
                <div class="container">
                    <div class="row footer-theme">
                        <div class="col-lg-4 col-md-4 mt-4">
                            <div class="footer-contant">
                                <div class="footer-logo">
                                    <img width="160" src="https://berny.mx/assets/img/logo-black.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-12 mt-4">
                            <div class="sub-title">
                                <div class="footer-title">
                                    <h4>Navegación</h4>
                                </div>
                                <div class="footer-contant">
                                    <ul>
                                        <li>
                                            <router-link :to="{ path: '/' }">Inicio</router-link>
                                        </li>
                                        <li><a href="https://berny.mx/tienda">Tienda</a></li>
                                        <li><a href="https://berny.mx/info/blog">Blog</a></li>
                                        <li><a href="https://berny.mx/info/faq">Ayuda</a></li>
                                        <li><a href="https://berny.mx/cuestions">Ventas</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-12 mt-4">
                            <div class="sub-title">
                                <div class="footer-title">
                                    <h4>Información</h4>
                                </div>
                                <div class="footer-contant">
                                    <ul>
                                        <li><a href="https://berny.mx/pages/privacidad" target="_blank">Aviso de Privacidad</a></li>
                                        <li>
                                            <router-link :to="{ path: '/pages/contacto' }">Contacto</router-link>
                                        </li>
                                        <li>                                            
                                            <router-link :to="{ path: '/pages/empresa' }">Empresa</router-link>
                                        </li>
                                        <li><a href="https://berny.mx/pages/folleto">Catálogo</a></li>
                                        <li><a href="https://webmail1.hostinger.mx/">Webmail</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-12 mt-4">
                            <div class="sub-title">
                                <div class="footer-title">
                                    <h4>Contacto</h4>
                                </div>
                                <div class="footer-contant">
                                    <ul class="contact-list">
                                        <li><i class="fa fa-map-marker"></i>Calle 21 No. 93 Avenida Alemán, CP 97100 Mérida, Yucatán, México</li>
                                        <li><i class="fa fa-phone"></i>(999) 926 3207</li>
                                        <li><i class="fa fa-envelope-o"></i><a href="#">servicioalcliente@berny.mx</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-12 mt-4">
                            <div class="sub-title">
                                <div class="footer-title">
                                    <h4>Sociales</h4>
                                </div>
                                <div class="footer-contant">
                                    <div class="footer-social">
                                        <ul>
                                            <li><a href="https://www.facebook.com/BernyDistribuidoraMX"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                            <li><a href="https://wa.me/529999263207"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="sub-footer dark-subfooter">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="footer-end">
                                <p><i class="fa fa-copyright" aria-hidden="true"></i>2014 © Berny Distribuidora | Todos los derechos reservados </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </footer>

        <!-- Whatsapp -->
        <div class="tap-whatsapp">
            <a target="_blank" href="https://wa.me/529999263207 "><i class="fa fa-whatsapp" style="margin-top:9px;"></i></a>
        </div>
    </div>  
</template>

<script>

import Logotype from '@/assets/img/logo-black-b.png'

export default {
    data () {
        return  {
            logoBerny: Logotype
        }
        
    },
    setup() {
        
    },
}
</script>

<style>
 #nav{
background: whitesmoke;
}

#nav {
  padding: 30px;
  text-align: center;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: whitesmoke;
  background: crimson;
  border-radius: .5rem;
}
</style>