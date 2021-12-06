<template>
    <div>
         <!--section start-->
        <section class="register-page section-b-space">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Registre sus datos</h3>
                        <div class="theme-card">
                            <form class="theme-form" id="customer_register"  method="post">
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nombre Completo</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre Completo" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Correo Eléctronico</label>
                                                <input id="email" name="email" type="email" class="form-control" placeholder="Correo Eléctronico" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Teléfono (*)</label>
                                                <input id="phone" name="phone" type="tel" class="form-control" autocomplete="off" maxlength="10" min="0" placeholder="Teléfono" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="postal_code">Código postal (*)</label>
                                                <input id="postal_code" name="postal_code" type="text" class="form-control" autocomplete="off" maxlength="10" min="0" placeholder="Código postal" required>
                                                <div id="postal-code-error" class="help-block has-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="states">Estado</label>
                                                <input type="text" name="states" id="states" autocomplete="off" class="form-control" placeholder="Estado" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="municipality">Delegación / Municipio (*)</label>
                                                <input type="text" name="municipality" id="municipality" autocomplete="off" class="form-control" placeholder="Delegación" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="location">Localidad / Población (*)</label>
                                                <div id="show_location">
                                                    <select name="location" id="location" class="form-control" style="padding: 0px 8px; height: 45px;" required>
                                                        <option value="">Selecciona una opción</option>
                                                    </select>
                                                    <br>
                                                    <span id="help_show_new_location" class="help_show_new_location" style="display: none;">
                                                        ¿No encuentro mi localidad o población ? <a href="javascript:void(0)" id="show_new_location" name="show_new_location" style="display: none;">Click aqui</a>
                                                    </span>

                                                    <div id="location-help-block" class="help-block"></div>
                                                </div>
                                                <div id="new_location" style="display: none;">
                                                    <input type="text" id="new_location_name" name="new_location_name" class="form-control" placeholder="Nueva localidad o población">
                                                    <div class="help-block">Mostrar lista de localidades o poblaciones <a href="javascript:void(0)" id="show_list_location" name="show_list_location">Click aqui</a></div>

                                                    <div id="new_location_name-error" class="help-block has-error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <br><br>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Contraseña</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="confirm_password">Confirmar contraseña</label>
                                                <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Confirmar contraseña" required>
                                            </div>
                                        </div>
                                        <input type="hidden" name="register" id="register" value="register">
                                        <input type="hidden" name="latitude" id="latitude" value="0">
                                        <input type="hidden" name="longitude" id="longitude" value="0">
                                        <input type="hidden" name="is_new_location" id="is_new_location" value="0">
                                        <button id="btn_register" name="btn_register" type="button" class="btn btn_register btn-solid">Registrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Section ends-->

         <section class="register-page section-b-space">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h3>Beneficios distribuidor</h3>
                        <div class="row col-md-12">
                            <div class="col-md-12 col-xs-12">
                                <h5> <i class="fa fa-1x fa-truck"></i> Envío seguro a todo México<span class="text-red">*</span></h5>
                            </div>
                            <div class="col-md-10 col-xs-9">
                                <h5> <i class="fa fa-1x fa-dollar"></i> El mejor precio en cada producto. <span class="text-red">*</span></h5>
                            </div>
                            <div class="col-md-10 col-xs-9">
                                <h5> <i class="fa fa-1x fa-dollar"></i> Precios con envío incluido a destino <span class="text-red">*</span></h5>
                            </div>

                            <div class="col-md-10 col-xs-9">
                                <h5> <i class="fa fa-1x fa-cubes"></i> A mayor volumen de compra, mejor precio final <span class="text-red">*</span></h5>
                            </div>

                            <div class="col-md-12 col-xs-12">
                                <h5> <i class="fa fa-1x fa-tags"></i> Promociones exclusivas los primeros 10 dias de cada mes.<span class="text-red">*</span></h5>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <h5><i class="fa fa-info-circle"></i> Atención personalizada <span class="text-red">*</span></h5>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <small>*Para flete pagádo se requiere un mínimo de compra.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="https://www.berny.mx/uploads/socials/distributed.png" alt="distributed" height="220" class="img-responsive d-none d-sm-none d-sm-block">
                        <p class="d-block d-sm-none"><br><br></p>
                    </div>
                    <div class="col-md-6">                        
                        <h3>¿Necesitas ayuda para registrarte?</h3>
                        <p>- Completa tu registro en 5 minutos, haz clic para ver el video</p>
                        <div class="embed-responsive embed-responsive-16by9">
                            <!-- <iframe class="embed-responsive-item" src="<?= URL_VIDEO_DISTRIBUIDOR ?>" frameborder="0" allowfullscreen=""></iframe> -->
                             <!-- <LazyYoutube src="https://www.youtube.com/watch?v=TcMBFSGVi1c" /> -->
                        </div>                        
                    </div>
                </div>               
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isDistributed: false,
        }
    },
}
</script>