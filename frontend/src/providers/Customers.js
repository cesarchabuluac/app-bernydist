import axios from "axios";

export default class Customers {
	store(formData) {
		return axios.post(`../customer/store`, formData);
	}
}
