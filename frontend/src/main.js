import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import * as VueGoogleMaps from "vue2-google-maps";


//Sweet alert
import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

//Mixins
import http from "./mixins/http";

Vue.config.productionTip = false;

Vue.use(VueGoogleMaps, {
	load: {
		key: "AIzaSyC0lnIcO0oeG0hMl0hgG_DK_xfNRCUGwpA"
	}
});

Vue.use(VueSweetalert2);
Vue.mixin(http);

new Vue({
	router,
	render: h => h(App)
}).$mount("#app");
