import axios from "axios";

export default {
	methods: {
		http() {
			let instance = axios.create({
				headers: {
					"Access-Control-Allow-Origin": "*",                    
				}
			});
			instance.interceptors.response.use(
				response => response,
				error => {
					return Promise.reject(error);
				}
			);
			return instance;
		},

		success(message) {			
            this.$swal({
                title: 'Operación exitosa',
                text: message,
                icon: 'success',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: `#f37e2b`,
            });
		},

		danger(message) {
            this.$swal({
                title: 'Error generado',
                text: message,
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: `#f37e2b`,
            });
		},

		getFirstValidationError(errorBag) {
			let errors = Object.values(errorBag);
			errors = errors.flat();
			return errors[0];
		},

		handleResponseErrors(e) {
			// this.loading = false
			if (e.response.status === 422) {
			    this.danger(this.getFirstValidationError(e.response.data.errors))
			    this.errors = e.response.data.errors
			}
			else {
			    this.danger(e.message)
			}
		}
	}
};
