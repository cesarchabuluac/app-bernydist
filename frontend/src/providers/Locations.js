import axios from "axios";

export default class Locations {

    findByCity (query) {
        return axios.get(`../location/findByCity`, { params: query});
    }	
}
