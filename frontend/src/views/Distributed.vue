<template>
    <div>
        <!--section start-->
        <section class="register-page section-b-space">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Registre sus datos</h3>
                        <div class="theme-card">
                            <form
                                class="theme-form"
                                id="customer_register"
                                method="post"
                            >
                                <b-overlay
                                    :show="loading"
                                    rounded="sm"
                                    opacity=".65"
                                    blur="1rem"
                                    style="z-index: 8 !important"
                                >
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name"
                                                        >Nombre Completo
                                                        (*)</label
                                                    >
                                                    <input
                                                        v-model="user.name"
                                                        type="text"
                                                        class="form-control"
                                                        id="name"
                                                        name="name"
                                                        placeholder="Nombre Completo"
                                                        required
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email"
                                                        >Correo Eléctronico
                                                        (*)</label
                                                    >
                                                    <input
                                                        v-model="user.email"
                                                        id="email"
                                                        name="email"
                                                        type="email"
                                                        class="form-control"
                                                        placeholder="Correo Eléctronico"
                                                        required
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone"
                                                        >Teléfono (*)</label
                                                    >
                                                    <input
                                                        v-model="user.phone"
                                                        id="phone"
                                                        name="phone"
                                                        type="tel"
                                                        class="form-control"
                                                        autocomplete="off"
                                                        maxlength="10"
                                                        min="0"
                                                        placeholder="Teléfono"
                                                        required
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="postal_code"
                                                        >Código postal
                                                        (*)</label
                                                    >
                                                    <input
                                                        v-model="
                                                            user.postal_code
                                                        "
                                                        @blur.prevent="
                                                            validPostalCode
                                                        "
                                                        id="postal_code"
                                                        name="postal_code"
                                                        type="text"
                                                        class="form-control"
                                                        autocomplete="off"
                                                        maxlength="10"
                                                        min="0"
                                                        placeholder="Código postal"
                                                        required
                                                    />
                                                    <div
                                                        id="postal-code-error"
                                                        class="
                                                            help-block
                                                            has-error
                                                        "
                                                    ></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="state"
                                                        >Estado (*)</label
                                                    >
                                                    <input
                                                        v-model="user.state"
                                                        type="text"
                                                        name="state"
                                                        id="state"
                                                        autocomplete="off"
                                                        class="form-control"
                                                        placeholder="Estado"
                                                        required
                                                        readonly
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="municipality"
                                                        >Delegación / Municipio
                                                        (*)</label
                                                    >
                                                    <input
                                                        v-model="
                                                            user.municipality
                                                        "
                                                        type="text"
                                                        name="municipality"
                                                        id="municipality"
                                                        autocomplete="off"
                                                        class="form-control"
                                                        placeholder="Delegación"
                                                        required
                                                        readonly
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            v-if="!isNewLocation"
                                            class="form-row"
                                        >
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="location"
                                                        >Localidad / Población
                                                        (*)</label
                                                    >
                                                    <select
                                                        v-model="
                                                            user.location_id
                                                        "
                                                        name="location"
                                                        id="location"
                                                        class="form-control"
                                                        style="
                                                            padding: 0px 8px;
                                                            height: 45px;
                                                        "
                                                        required
                                                    >
                                                        <option value="">
                                                            Selecciona una
                                                            opción
                                                        </option>
                                                        <option
                                                            v-for="(
                                                                item, index
                                                            ) in locations"
                                                            :key="index"
                                                            :value="
                                                                item.LOCALIDAD_ID
                                                            "
                                                        >
                                                            {{
                                                                item.NOMBRE_LOCALIDAD
                                                            }}
                                                        </option>
                                                    </select>
                                                    <br />
                                                    <span
                                                        v-if="locations"
                                                        id="help_show_new_location"
                                                        class="
                                                            help_show_new_location
                                                        "
                                                    >
                                                        ¿No encuentro mi
                                                        localidad o población ?
                                                        <b-link
                                                            href="javascript:void(0)"
                                                            @click="
                                                                showNewLocation
                                                            "
                                                            >Click aqui</b-link
                                                        >
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            v-if="isNewLocation"
                                            class="form-row"
                                        >
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="location"
                                                        >Localidad / Población
                                                        (*)</label
                                                    >
                                                    <input
                                                        v-model="
                                                            user.new_location
                                                        "
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="Nueva localidad o población"
                                                    />
                                                    <div class="help-block">
                                                        Mostrar lista de
                                                        localidades o
                                                        poblaciones
                                                        <a
                                                            href="javascript:void(0)"
                                                            @click="
                                                                showLocations
                                                            "
                                                            >Click aqui</a
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row"><br /><br /></div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password"
                                                        >Contraseña (*)</label
                                                    >
                                                    <input
                                                        v-model="user.password"
                                                        type="password"
                                                        class="form-control"
                                                        id="password"
                                                        name="password"
                                                        placeholder="Contraseña"
                                                        required
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label
                                                        for="confirm_password"
                                                        >Confirmar contraseña
                                                        (*)</label
                                                    >
                                                    <input
                                                        v-model="
                                                            user.confirm_password
                                                        "
                                                        type="password"
                                                        class="form-control"
                                                        placeholder="Confirmar contraseña"
                                                        required
                                                    />
                                                </div>
                                            </div>
                                            <button
                                                @click.prevent="register"
                                                id="btn_register"
                                                name="btn_register"
                                                type="button"
                                                class="
                                                    btn btn_register btn-solid
                                                "
                                            >
                                                Registrar
                                            </button>
                                        </div>
                                    </div>

                                    <template #overlay>
                                        <div class="text-center">
                                            <b-icon
                                                icon="stopwatch"
                                                font-scale="3"
                                                animation="cylon"
                                            ></b-icon>
                                            <p id="cancel-label">
                                                Please wait...
                                            </p>
                                        </div>
                                    </template>
                                </b-overlay>
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
                                <h5>
                                    <i class="fa fa-1x fa-truck"></i> Envío
                                    seguro a todo México<span class="text-red"
                                        >*</span
                                    >
                                </h5>
                            </div>
                            <div class="col-md-10 col-xs-9">
                                <h5>
                                    <i class="fa fa-1x fa-dollar"></i> El mejor
                                    precio en cada producto.
                                    <span class="text-red">*</span>
                                </h5>
                            </div>
                            <div class="col-md-10 col-xs-9">
                                <h5>
                                    <i class="fa fa-1x fa-dollar"></i> Precios
                                    con envío incluido a destino
                                    <span class="text-red">*</span>
                                </h5>
                            </div>

                            <div class="col-md-10 col-xs-9">
                                <h5>
                                    <i class="fa fa-1x fa-cubes"></i> A mayor
                                    volumen de compra, mejor precio final
                                    <span class="text-red">*</span>
                                </h5>
                            </div>

                            <div class="col-md-12 col-xs-12">
                                <h5>
                                    <i class="fa fa-1x fa-tags"></i> Promociones
                                    exclusivas los primeros 10 dias de cada
                                    mes.<span class="text-red">*</span>
                                </h5>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <h5>
                                    <i class="fa fa-info-circle"></i> Atención
                                    personalizada
                                    <span class="text-red">*</span>
                                </h5>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <small
                                    >*Para flete pagádo se requiere un mínimo de
                                    compra.</small
                                >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <img
                            src="https://www.berny.mx/uploads/socials/distributed.png"
                            alt="distributed"
                            height="220"
                            class="img-responsive d-none d-sm-none d-sm-block"
                        />
                        <p class="d-block d-sm-none"><br /><br /></p>
                    </div>
                    <div class="col-md-6">
                        <h3>¿Necesitas ayuda para registrarte?</h3>
                        <p>
                            - Completa tu registro en 5 minutos, haz clic para
                            ver el video
                        </p>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe
                                class="embed-responsive-item"
                                src="https://www.youtube.com/embed/RhHRLWISDYU"
                                frameborder="0"
                                allowfullscreen=""
                            ></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from "axios";
import _ from "lodash";
import LocationProvider from "@/providers/Locations";
import PostalCodeProvider from "@/providers/PostalCodes";
import CustomerProvider from '@/providers/Customers'
const LocationResource = new LocationProvider();
const PostalCodeResource = new PostalCodeProvider();
const CustomerResource = new CustomerProvider();

export default {
    data() {
        return {
            loading: false,
            tokenSepomex: `cdcb3106-ebe5-44ce-a2cb-9a36830d4d26`,
            user: {},
            postalCodes: [],
            locations: [],
            isNewLocation: false,
            error: 0,
            errorMessages: [],
        };
    },
    computed: {},
    methods: {
        async validPostalCode() {
            if (this.user.postal_code) {
                this.locations = [];
                this.user.new_location = null;
                this.user.state = null;
                this.user.municipality = null;
                this.user.location_id = null;
                this.loading = true;

                let query = {};
                try {
                    let { data } = await PostalCodeResource.find(
                        this.user.postal_code
                    );
                    if (!data.status) {
                        const API_SEPOMEX = `https://api-sepomex.hckdrk.mx/query/info_cp/${this.user.postal_code}?token=${this.tokenSepomex}`;
                        const { data } = await axios.get(API_SEPOMEX);
                        const firstItem = _.first(data);
                        const bulkData = [];

                        data.forEach((element) => {
                            bulkData.push({
                                cp: element.response.cp,
                                settlement: element.response.asentamiento,
                                settlement_type:
                                    element.response.tipo_asentamiento,
                                municipality: element.response.municipio,
                                state: element.response.estado,
                                city: element.response.ciudad,
                                country: element.response.pais,
                            });
                        });

                        if (!firstItem.error) {
                            this.user.state = firstItem.response.estado;
                            this.user.municipality =
                                firstItem.response.municipio;
                            query = {
                                name_state: firstItem.response.estado,
                                name_city: firstItem.response.municipio,
                            };

                            //Bulk Insert to database local
                            PostalCodeResource.store(bulkData);
                        } else {
                            this.danger(firstItem.error_message);
                        }
                    } else {
                        this.user.state = data.data.state;
                        this.user.municipality = data.data.municipality;

                        query = {
                            name_state: data.data.state,
                            name_city: data.data.municipality,
                        };
                    }

                    // const params = query;
                    LocationResource.findByCity(query)
                        .then((response) => {
                            this.loading = false;
                            if (response.status) {
                                this.locations = response.data.data;
                            } else {
                                this.danger(response.data.message);
                            }
                        })
                        .catch((err) => {
                            this.loading = false;
                            let errors = Object.values(err);
                            errors = errors.flat();
                            if (errors[2]) {
                                this.danger(errors[2].data.error_message);
                            } else {
                                this.handleResponseErrors(err);
                            }
                        });
                } catch (error) {
                    this.loading = false;
                    let errors = Object.values(error);
                    errors = errors.flat();
                    if (errors[2]) {
                        this.danger(errors[2].data.error_message);
                    } else {
                        this.handleResponseErrors(error);
                    }
                }
            }
        },
        validForm() {
            this.error = 0;
            this.errorMessages = [];

            if (!this.user.name) {
                this.errorMessages.push("El nombre es requerido.");
            }
            if (!this.user.email) {
                this.errorMessages.push("El correo es requerido.");
            }
            if (!this.user.phone) {
                this.errorMessages.push("El teléfono es requerido.");
            }
            if (!this.user.postal_code) {
                this.errorMessages.push("El código postal es requerido");
            }
            if (!this.user.state) {
                this.errorMessages.push("El estado es requerido");
            }
            if (!this.user.municipality) {
                this.errorMessages.push("La delegación/municipio es requerido");
            }
            if (!this.user.password) {
                this.errorMessages.push("La contraseña es requerido");
            }
            // if (!this.user.password.length <= 5){this.errorMessages.push("La longitud de la contraseña es corta, debe tener almenos 5 caracteres (Alfanumerico)");}
            if (this.user.password != this.user.confirm_password) {
                this.errorMessages.push(
                    "La confirmación de la contraseña no coincide"
                );
            }

            if (this.isNewLocation) {
                if (!this.user.new_location) {
                    this.errorMessages.push("La localidad es requerido");
                }
            } else {
                if (!this.user.location_id /*|| !this.user.new_location*/) {
                    this.errorMessages.push("La localidad es requerido");
                }
            }

            if (this.errorMessages.length) {
                this.error = 1;
                this.danger(" (*) Campos requeridos");
                return this.error;
            }
        },
        async register() {
            this.validForm();
            this.user.is_new_location = this.isNewLocation;
            console.log(this.user);
            this.loading = true;

            try {

                const { data } = await CustomerResource.store(this.user)
                this.loading = false
                if (data.status) {
                    this.user = {}
                    this.success(data.message);

                } else {
                    this.danger(data.message);
                }

            } catch (error) {                
                this.loading = false;
                let errors = Object.values(error);
                console.log(errors)
                errors = errors.flat();
                if (errors[2]) {
                    this.danger(errors[2].data.error_message);
                } else {
                    this.handleResponseErrors(error);
                }
            }
        },
        showNewLocation() {
            this.locations = [];
            this.user.location_id = null;
            this.user.new_location = null;
            this.isNewLocation = true;
            this.error = 0;
            this.errorMessages = [];
        },
        showLocations() {
            this.isNewLocation = false;
            this.user.new_location = null;
            this.error = 0;
            this.errorMessages = [];
            this.validPostalCode();
        },
    },
};
</script>