import axios from "axios";

export default class Auth {
	login(formData) {
		return axios.post(`../auth/login`, formData);
	}
}