import axios from "axios";

export default class Products {
	getProducts() {
		return axios.get(`product/product`);
	}

	getLines(query) {
		return axios.get(`product/lines`, query);
	}

    getCategories (query) {
        return axios.get(`product/categories`, query);
    }

    getRelevants () {
        return axios.get(`product/relevants`);
    }

    getGroups () {
        return axios.get(`product/groups`);
    }

    getBrands() {
        return axios.get('product/brands')
    }
}
