<template>
    <div>
        <!-- Banner Sections  -->
        <section class="p-0 metro-slider">
            <div class="slide-1">
                <div class="home text-center">
                    <img
                        src="https://berny.mx/uploads/banners/banner-2020.png"
                        alt="Banner"
                        class="img-fluid"
                        style="width: 100%"
                    />
                </div>
            </div>
        </section>

        <!-- lines section start-->
        <section class="p-4">
            <div class="container">
                <div class="row">
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                    <div class="p-0 col-lg-6 col-md-10 col-sm-12">
                        <div class="title3">
                            <h2 class="title-inner3">¿TIENES UN NEGOCIO?</h2>
                            <h3 class="title-inner3">
                                Encuentra lo que necesites con nosotros
                            </h3>
                            <a
                                href="#"
                                data-toggle="tooltip"
                                title=""
                                data-original-title="Hooray!"
                            ></a>
                        </div>
                    </div>
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-0 category-tools ratio3_2">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div
                            id="lines-slides"
                            class="category-m slick-initialized slick-slider"
                        >
                            <button
                                class="slick-prev slick-arrow slick-disabled"
                                aria-label="Previous"
                                type="button"
                                aria-disabled="true"
                                style=""
                            >
                                Previous
                            </button>
                            <div class="slick-list draggable">
                                <div
                                    class="slick-track"
                                    style="
                                        opacity: 1;
                                        width: 3664px;
                                        transform: translate3d(0px, 0px, 0px);
                                    "
                                >
                                    <div
                                        v-for="(item, index) in lines"
                                        :key="index"
                                        class="
                                            slick-slide
                                            slick-current
                                            slick-active
                                        "
                                        data-slick-index="0"
                                        aria-hidden="false"
                                        style="width: 229px"
                                    >
                                        <div>
                                            <div
                                                style="
                                                    width: 100%;
                                                    display: inline-block;
                                                "
                                            >
                                                <div
                                                    class="category-wrapper p-1"
                                                >
                                                    <div>
                                                        <a
                                                            href="#"
                                                            tabindex="0"
                                                        >
                                                            <div
                                                                :style="`background-image: url(${item.image});`"
                                                                style="
                                                                    height: 160px;
                                                                    overflow: hidden;
                                                                    background-image: url(https://berny.mx/uploads/online-store/ALUMINIEROS.jpeg);
                                                                    background-size: cover;
                                                                    background-position: center
                                                                        center;
                                                                "
                                                            >
                                                                <img
                                                                    style="
                                                                        height: 100%;
                                                                        display: none;
                                                                    "
                                                                    :src="
                                                                        item.image
                                                                    "
                                                                    :alt="
                                                                        item.name
                                                                    "
                                                                />
                                                            </div>
                                                            <span
                                                                class="
                                                                    btn
                                                                    btn-classic
                                                                    btn-outline
                                                                "
                                                                >{{
                                                                    item.name
                                                                }}</span
                                                            >
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button
                                class="slick-next slick-arrow"
                                aria-label="Next"
                                type="button"
                                style=""
                                aria-disabled="false"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Lo más nuevo  -->
        <section class="section-b-space tools-grey ratio_square p-4">
            <div class="container">
                <div class="row">
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                    <div class="p-0 col-lg-6 col-md-10 col-sm-12">
                        <div class="title3">
                            <h2 class="title-inner3">Lo más nuevo</h2>
                        </div>
                    </div>
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div
                            id="most-new-products"
                            class="product-m slick-initialized slick-slider"
                        >
                            <div class="slick-list draggable">
                                <div
                                    class="slick-track"
                                    style="
                                        opacity: 1;
                                        width: 1400px;
                                        transform: translate3d(0px, 0px, 0px);
                                    "
                                >
                                    <div
                                        v-for="(item, index) in categories"
                                        :key="index"
                                        class="
                                            slick-slide
                                            slick-current
                                            slick-active
                                        "
                                        data-slick-index="0"
                                        aria-hidden="false"
                                        style="width: 280px"
                                    >
                                        <div>
                                            <div
                                                class="product-box product-wrap"
                                                style="
                                                    width: 100%;
                                                    display: inline-block;
                                                "
                                            >
                                                <a href="#" tabindex="0">
                                                    <div
                                                        :style="`background-image: url('${item.image}');`"
                                                        class="img-wrapper"
                                                        style="
                                                            height: 149px;
                                                            overflow: hidden;
                                                            background-size: cover;
                                                            background-position: center
                                                                center;
                                                        "
                                                    >
                                                        <div class="front">
                                                            <span
                                                                style="
                                                                    background-size: contain;
                                                                    background-repeat: no-repeat;
                                                                "
                                                                href="#"
                                                            >
                                                                <img
                                                                    :src="
                                                                        item.image
                                                                    "
                                                                    style="
                                                                        height: 100%;
                                                                        display: none;
                                                                    "
                                                                    :alt="
                                                                        item.category_name
                                                                    "
                                                                />
                                                            </span>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="product-info">
                                                    <a href="#" tabindex="0"></a
                                                    ><a href="#" tabindex="0">
                                                        <h6>
                                                            {{ item.name }}
                                                            <small>{{
                                                                item.number_products
                                                            }}</small>
                                                        </h6>
                                                    </a>
                                                    <div>
                                                        <small
                                                            >Precios Desde ${{
                                                                formatPrice(
                                                                    item.total
                                                                )
                                                            }}
                                                            IVA incluido*</small
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12 text-center">
                        <a
                            href="tienda/0/nuevos/true"
                            class="btn btn-classic btn-outline"
                            >Ver más</a
                        >
                    </div>
                </div>
            </div>
        </section>

        <!-- Lo más relevante -->
        <section class="section-b-space tools-grey ratio_square p-4">
            <div class="container">
                <div class="row">
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                    <div class="p-0 col-lg-6 col-md-10 col-sm-12">
                        <div class="title3">
                            <h2 class="title-inner3">Lo más relevante</h2>
                        </div>
                    </div>
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div
                            id="most-relevant-products"
                            class="product-m slick-initialized slick-slider"
                        >
                            <button
                                class="slick-prev slick-arrow slick-disabled"
                                aria-label="Previous"
                                type="button"
                                aria-disabled="true"
                                style=""
                            >
                                Previous
                            </button>
                            <div class="slick-list draggable">
                                <div
                                    class="slick-track"
                                    style="
                                        opacity: 1;
                                        width: 1800px;
                                        transform: translate3d(0px, 0px, 0px);
                                    "
                                >
                                    <div
                                        v-for="(item, index) in relevants"
                                        :key="index"
                                        class="
                                            slick-slide
                                            slick-current
                                            slick-active
                                        "
                                        data-slick-index="0"
                                        aria-hidden="false"
                                        style="width: 360px"
                                    >
                                        <div>
                                            <div
                                                class="product-box product-wrap"
                                                style="
                                                    width: 100%;
                                                    display: inline-block;
                                                "
                                            >
                                                <a
                                                    :href="item.url_title"
                                                    tabindex="0"
                                                >
                                                    <div
                                                        class="img-wrapper"
                                                        :style="`background-image: url('${item.image}');`"
                                                        style="
                                                            height: 149px;
                                                            overflow: hidden;
                                                            background-size: cover;
                                                            background-position: center
                                                                center;
                                                        "
                                                    >
                                                        <div class="front">
                                                            <span
                                                                style="
                                                                    background-size: contain;
                                                                    background-repeat: no-repeat;
                                                                "
                                                                :href="
                                                                    item.url_title
                                                                "
                                                            >
                                                                <img
                                                                    alt="104083589"
                                                                    :src="
                                                                        item.image
                                                                    "
                                                                    style="
                                                                        height: 100%;
                                                                        display: none;
                                                                    "
                                                                />
                                                            </span>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="product-info">
                                                    <a
                                                        :href="item.url_title"
                                                        tabindex="0"
                                                    >
                                                    </a
                                                    ><a
                                                        :href="item.url_title"
                                                        tabindex="0"
                                                    >
                                                        <h6>
                                                            {{
                                                                item.category_name
                                                            }}
                                                            <small>{{
                                                                item.number_products
                                                            }}</small>
                                                        </h6>
                                                    </a>
                                                    <div>
                                                        <small
                                                            >Precios Desde ${{
                                                                formatPrice(
                                                                    item.total
                                                                )
                                                            }}
                                                            IVA incluido*</small
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button
                                class="slick-next slick-arrow"
                                aria-label="Next"
                                type="button"
                                style=""
                                aria-disabled="false"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12 text-center">
                        <a href="tienda" class="btn btn-classic btn-outline"
                            >Ver más</a
                        >
                    </div>
                </div>
            </div>
        </section>

        <!-- More infomation -->
        <section class="p-4">
            <div class="container">
                <div class="row">
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                    <div class="p-0 col-lg-6 col-md-10 col-sm-12">
                        <div class="title3">
                            <h2 class="title-inner3">INFORMACIÓN</h2>
                        </div>
                    </div>
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="service section-b-space border-top-0 p-4">
            <div class="container">
                <div class="row partition4">
                    <div class="col-lg-3 col-md-6 service-block1">
                        <img
                            src="https://www.berny.mx/uploads/online-store/shipping.png"
                            alt="shipping"
                            height="80"
                        />
                        <h4>ENVÍO A TODA LA REPÚBLICA MEXICANA</h4>
                        <p style="color: black">
                            Nuestros precios incluyen envío a todo México,
                            aplican restricciones y mínimo de compra.
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-6 service-block1">
                        <img
                            src="https://www.berny.mx/uploads/online-store/support.png"
                            alt="support"
                            height="80"
                        />
                        <h4>
                            ATENCIÓN A CLIENTES DE 9 AM A 6 PM DE LUNES A
                            VIERNES
                        </h4>
                        <p style="color: black">
                            Estamos para apoyarte a crecer en tu negocio con la
                            calidad y servicio de Berny Distribuidora
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-6 service-block1">
                        <img
                            src="https://www.berny.mx/uploads/online-store/business.png"
                            alt="business"
                            height="80"
                        />
                        <h4>¡TODO PARA TU NEGOCIO!</h4>
                        <p style="color: black">
                            Contamos con un amplio catálogo a precio de mayoreo
                            y con increíbles descuentos para nuestros aliados en
                            todo México.
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-6 service-block1">
                        <img
                            src="https://www.berny.mx/uploads/online-store/payment.png"
                            alt="payment"
                            height="80"
                        />
                        <h4>FACILIDADES DE PAGO</h4>
                        <p style="color: black">
                            Queremos crecer contigo contamos con diferentes
                            formas de pago antes de finalizar tu pedido
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Groups  -->
        <section class="p-4">
            <div class="container">
                <div class="row">
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                    <div class="p-0 col-lg-6 col-md-10 col-sm-12">
                        <div class="title3">
                            <h2 class="title-inner3">GRUPOS DE PRODUCTOS</h2>
                        </div>
                    </div>
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-b-space p-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            id="groups-slider"
                            class="slick-initialized slick-slider slick-dotted"
                        >
                            <button
                                class="slick-prev slick-arrow"
                                aria-label="Previous"
                                type="button"
                                style=""
                            >
                                Previous
                            </button>
                            <div class="slick-list draggable">
                                <div
                                    class="slick-track"
                                    style="
                                        opacity: 1;
                                        width: 8244px;
                                        transform: translate3d(
                                            -1374px,
                                            0px,
                                            0px
                                        );
                                    "
                                >
                                    <div
                                        v-for="(item, index) in groups"
                                        :key="index"
                                        class="slick-slide slick-cloned"
                                        data-slick-index="-6"
                                        aria-hidden="true"
                                        tabindex="-1"
                                        style="width: 229px"
                                    >
                                        <div>
                                            <div
                                                style="
                                                    width: 100%;
                                                    display: inline-block;
                                                "
                                            >
                                                <div class="category-block">
                                                    <a href="#" tabindex="-1">
                                                        <div
                                                            class="
                                                                category-image
                                                            "
                                                        >
                                                            <img
                                                                height="40"
                                                                :alt="item.name"
                                                                :src="
                                                                    item.image
                                                                "
                                                            />
                                                        </div>
                                                    </a>
                                                    <div
                                                        class="category-details"
                                                    >
                                                        <a
                                                            href="#"
                                                            tabindex="-1"
                                                        >
                                                            <h5>
                                                                {{ item.name }}
                                                            </h5>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button
                                class="slick-next slick-arrow"
                                aria-label="Next"
                                type="button"
                                style=""
                            >
                                Next
                            </button>
                            <ul class="slick-dots" style="" role="tablist">
                                <li class="slick-active" role="presentation">
                                    <button
                                        type="button"
                                        role="tab"
                                        id="slick-slide-control20"
                                        aria-controls="slick-slide20"
                                        aria-label="1 of 3"
                                        tabindex="0"
                                        aria-selected="true"
                                    >
                                        1
                                    </button>
                                </li>
                                <li role="presentation">
                                    <button
                                        type="button"
                                        role="tab"
                                        id="slick-slide-control21"
                                        aria-controls="slick-slide26"
                                        aria-label="2 of 3"
                                        tabindex="-1"
                                    >
                                        2
                                    </button>
                                </li>
                                <li role="presentation">
                                    <button
                                        type="button"
                                        role="tab"
                                        id="slick-slide-control22"
                                        aria-controls="slick-slide212"
                                        aria-label="3 of 3"
                                        tabindex="-1"
                                    >
                                        3
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Brands -->
        <section class="p-4">
            <div class="container">
                <div class="row">
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                    <div class="p-0 col-lg-6 col-md-10 col-sm-12">
                        <div class="title3">
                            <h2 class="title-inner3">MARCAS AFILIADAS</h2>
                        </div>
                    </div>
                    <div
                        class="
                            p-0
                            col-lg-3 col-md-1
                            d-none d-sm-none d-md-block
                        "
                    >
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-b-space p-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="brand-6 slick-initialized slick-slider">
                            <button
                                class="slick-prev slick-arrow"
                                aria-label="Previous"
                                type="button"
                                style=""
                            >
                                Previous
                            </button>
                            <div class="slick-list draggable">
                                <div
                                    class="slick-track"
                                    style="
                                        opacity: 1;
                                        width: 33892px;
                                        transform: translate3d(
                                            -8244px,
                                            0px,
                                            0px
                                        );
                                    "
                                >
                                    <div
                                        v-for="(item, index) in brands"
                                        :key="index"
                                        class="slick-slide slick-cloned"
                                        data-slick-index="-6"
                                        aria-hidden="true"
                                        tabindex="-1"
                                        style="width: 229px"
                                    >
                                        <div>
                                            <div
                                                style="
                                                    width: 100%;
                                                    display: inline-block;
                                                "
                                            >
                                                <div class="logo-block">
                                                    <a href="#" tabindex="-1">
                                                        <img
                                                            height="60"
                                                            :src="item.image"
                                                            :alt="`${item.name} | ${item.id}`"
                                                        />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button
                                class="slick-next slick-arrow"
                                aria-label="Next"
                                type="button"
                                style=""
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="p-4">
            <div class="container">
                <div class="row">
                    <div class="p-0 col-lg-3 col-md-1 d-none d-sm-none d-md-block">
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                    <div class="p-0 col-lg-6 col-md-10 col-sm-12">
                        <div class="title3">
                            <h2 class="title-inner3">
                                Comentarios de nuestros clientes
                            </h2>
                        </div>
                    </div>
                    <div class="p-0 col-lg-3 col-md-1 d-none d-sm-none d-md-block">
                        <div class="line-custom"></div>
                        <div class="line-custom-2"></div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="testimonial text-center">
                    <div id="testimonial" class="carousel slide testimonial4_indicators testimonial4_control_button thumb_scroll_x  swipe_x"
                        data-ride="carousel" data-pause="hover" data-interval="5000" data-duration="2000">
                        <div class="carousel-inner" role="listbox">                            
                            <div v-for="(item, index) in testimonials" :key="index" :id="`list-${index}`" role="list" :aria-selected="index===0 ? true : false" 
                                :aria-controls="`list-${index}`" tabindex="-1" class="carousel-item" :class="index===0 ? 'active': ''">
                                <div class="testimonial4_slide">
                                    <p>
                                        <img alt="user" src="https://berny.mx/assets/img/user.png" class="img-circle img-responsive"/>
                                    </p>
                                    <h3>{{item.name}}
                                        <small style="font-size: 14px !important;color: black;">( {{item.state}} )</small>
                                    </h3>
                                    <div class="star-rating">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="fa fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                    <p>{{item.comments}}</p>
                                    <h4>{{item.type}}</h4>
                                </div>
                            </div>                            
                        </div>

                        <!-- Buttons previous -->
                        <a  class="carousel-control-prev" href="#testimonial" data-slide="prev">
                            <button class="slick-prev slick-arrow" aria-label="Previous" type="button">
                                Previous
                            </button>
                        </a>
                        <a class="carousel-control-next" href="#testimonial" data-slide="next">
                            <button class="slick-next slick-arrow" aria-label="Next" type="button">
                                Next
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!--  -->
        <section class="p-4 dark-layout">
            <div class="full-banner parallax text-center p-center text-center bg-size blur-up lazyloaded" style="background-image: url(&quot;https://berny.mx/uploads/online-store/dark_bg.png&quot;); background-size: cover; background-position: center center; display: block;">
                <img src="https://berny.mx/uploads/online-store/dark_bg.png" alt="dark_bg" class="bg-img blur-up lazyload" style="display: none;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="brtitle">
                                <h2 class="title-inner3">NOTICIAS</h2>
                                <h3 class="title-inner3">SUBSCRIBETE PARA NOTICIAS Y PROMOCIONES</h3>
                            </div>
                        </div>
                        <div class="p-3 col-xl-8 offset-xl-2">
                            <div class="subscribe">
                                <form class="form-inline subscribe-form classic-form">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ingresa tu correo electrónico">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-solid">Enviar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</template>

<script>
import _ from "lodash";
import ProductProvider from "@/providers/Products";
import HomeProvider from "@/providers/Home";

const ProductResource = new ProductProvider();
const HomeResource = new HomeProvider();

export default {
    data() {
        return {
            lines: [],
            categories: [],
            relevants: [],
            groups: [],
            brands: [],
            testimonials: [],
        };
    },
    mounted() {
        this.fetchLines();
        this.fetchCategories();
        this.fetchRelevants();
        this.fetchGroups();
        this.getBrands();
        this.fetchTestimonials();
    },
    methods: {
        async fetchLines() {
            const { data } = await ProductResource.getLines();
            this.lines = data;
        },
        async fetchCategories() {
            const { data } = await ProductResource.getCategories();
            const _categories = data;
            _.map(_categories, (item) => {
                let _discount = item.PCTJ_FLETE
                    ? parseFloat(item.PCTJ_FLETE) / 100
                    : 0;
                let _price = item.total_with_discount
                    ? parseFloat(item.total_with_discount)
                    : parseFloat(item.lowest_price);
                let _total = item.total_with_discount
                    ? _price + _price * _discount
                    : parseFloat(item.lowest_price);
                this.categories.push({
                    ...item,
                    discount: _discount,
                    price: _price,
                    total: _total,
                });
            });
        },
        async fetchRelevants() {
            const { data } = await ProductResource.getRelevants();
            const _relevants = data;
            _.map(_relevants, (item) => {
                let _discount = item.PCTJ_FLETE
                    ? parseFloat(item.PCTJ_FLETE) / 100
                    : 0;
                let _price = item.total_with_discount
                    ? parseFloat(item.total_with_discount)
                    : parseFloat(item.lowest_price);
                let _total = item.total_with_discount
                    ? _price + _price * _discount
                    : parseFloat(item.lowest_price);
                this.relevants.push({
                    ...item,
                    discount: _discount,
                    price: _price,
                    total: _total,
                });
            });
        },
        async fetchGroups() {
            const { data } = await ProductResource.getGroups();
            this.groups = data;
        },
        async getBrands() {
            const { data } = await ProductResource.getBrands();
            this.brands = data;
        },
        async fetchTestimonials() {
            const { data } = await HomeResource.getTestimonials();
            console.log(data);
            this.testimonials = data;
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(2).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
    },
};
</script>

