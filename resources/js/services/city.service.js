import { publicApi, privateApi } from "./api";

class CityService {
    getCities() {
        return publicApi.get("/cities").then((response) => {
            return response.data.data;
        });
    }
}

export default new CityService();
