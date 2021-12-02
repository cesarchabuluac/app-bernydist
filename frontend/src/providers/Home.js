import axios from "axios";

export default class Home {
	getTestimonials() {
		return axios.get(`home/testimonials`);
	}
}
