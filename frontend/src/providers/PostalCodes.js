import axios from "axios";

export default class PostalCodes {
	find(postal_code) {
		return axios.get("../postalcode/show", {
			params: { cp: postal_code },
		});
	}

    store(payload) {
        return axios.post("../postalcode/store", JSON.stringify(payload));
    }
}
