<template>
    <div
        class="login-page"        
        style="min-height: 496.781px"
    >
        <div class="login-box">
            <div class="login-logo">
                <a href="https://berny.mx/">
                    <img
                        height="75"
                        src="https://berny.mx/assets/img/Logo-negro.png"
                        alt="Berny Distribuidora"
                    />
                </a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="text-center login-box-msg">
                        ¡Hola! Ingresa tu código o correo electrónico
                    </p>
                    <p class="text-center mt-4">
                        ¿Eres un cliente nuevo?
                        <router-link class="text-link" to="/pages/register"  style="2px solid #f37e2b; color: #f37e2b;"
                            >Empieza aqui.</router-link
                        >
                    </p>

                    <form
                        method="post"
                        class="theme-form"
                        id="customer_register"
                    >
                        <b-overlay
                            :show="loading"
                            rounded="sm"
                            opacity=".65"
                            blur="1rem"
                            style="z-index: 8 !important"
                        >
                            <div class="input-group mb-3">
                                <input
                                    v-model="user.code"
                                    type="text"
                                    class="form-control"
                                    placeholder="Código o Correo electrónico"
                                />
                            </div>
                            <div class="input-group mb-3">
                                <input
                                    v-model="user.password"
                                    type="password"
                                    class="form-control"
                                    placeholder="Contraseña"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-eye"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <a href="#"
                                        @click.prevent="login"
                                        type="button"
                                        class="btn btn btn-xs btn-solid btn-secondary rounded-pill btn-block"
                                    >
                                        Entrar
                                    </a>
                                </div>
                                <div class="col-4"></div>
                                <!-- /.col -->
                            </div>

                            <template #overlay>
                                <div class="text-center">
                                    <b-icon
                                        icon="stopwatch"
                                        font-scale="3"
                                        animation="cylon"
                                    ></b-icon>
                                    <p id="cancel-label">Please wait...</p>
                                </div>
                            </template>
                        </b-overlay>
                    </form>

                    <div class="social-auth-links text-center mb-3">
                        <hr>
                        <a href="#" class="btn btn btn-xs btn-solid btn-secondary rounded-pill btn-block">
                            <i class="fa fa-facebook mr-2"></i> Entrar con
                            Facebook
                        </a>
                        <a href="#" class="btn btn-xs btn-solid rounded-pill btn-block">
                            <i class="fa fa-google-plus mr-2"></i> Entrar con
                            Google+
                        </a>
                    </div>
                    <!-- /.social-auth-links -->

                    <p class="mb-2 text-center">
                        <!-- <a href="forgot-password.html">I forgot my password</a> -->
                        Olvidaste tu contraseña o No cuentas con una, <a href="#" style="2px solid #f37e2b; color: #f37e2b;">recuperar aquí</a>
                    </p>                    
                    <p class="text-center mb-0">
                            Si no tienes tu password comunícate con nosotros y te lo proporcionamos. <br />
                            <i class="fa fa-phone"></i> <a style="2px solid #f37e2b; color: #f37e2b;" href="tel:9999263207"> (999) 926 3207</a> <br />
                            <i class="fa fa-envelope"></i> <a style="2px solid #f37e2b; color: #f37e2b;" href="mailto:servicioalcliente@berny.mx"> servicioalcliente@berny.mx</a>
                        </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
    </div>
</template>

<script>
import axios from "axios";
import _ from "lodash";

export default {
    data() {
        return {
            loading: false,
            user: {},
        };
    },
    methods: {
        login() {},
    },
};
</script>

<style scoped>
.login-page,
.register-page {
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    background-color: #fff;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    height: 100vh;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;    
}

.login-box,
.register-box {
    width: 360px;
}

.login-logo,
.register-logo {
    font-size: 2.1rem;
    font-weight: 300;
    margin-bottom: 0.9rem;
    text-align: center;
}

.login-box .card,
.register-box .card {
    margin-bottom: 1;
}

.card {
    box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
    margin-bottom: 1rem;
}

.card {
    position: relative;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
}

.login-card-body,
.register-card-body {
    background-color: #fff;
    border-top: 0;
    color: #666;
    padding: 20px;
}

.card-body {
    -webkit-flex: 1 1 auto;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1.25rem;
}

</style>