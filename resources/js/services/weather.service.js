import { publicApi } from "./api";

class WeatherService {
    async getCityFromLocation(latitude, longitude) {
        try {
            const response = await publicApi.post("/get-city-from-location", {
                latitude,
                longitude,
            });
            return response.data;
        } catch (error) {
            console.error("Hiba történt a város lekérése során:", error);
            throw error;
        }
    }

    async storeLocation(city, latitude, longitude, userId) {
        try {
            const response = await publicApi.post(
                "/store-location",
                {
                    city,
                    latitude,
                    longitude,
                },
                {
                    headers: {
                        "X-User-Id": userId,
                    },
                },
            );
            return response.data;
        } catch (error) {
            console.error("Hiba történt a hely tárolása során:", error);
            throw error;
        }
    }

    async getWeatherData(cityId) {
        try {
            const response = await publicApi.get(`/weather/${cityId}`);
            return response.data;
        } catch (error) {
            console.error(
                "Hiba történt az időjárás adatok lekérése során:",
                error,
            );
            throw error;
        }
    }
}

export default new WeatherService();
