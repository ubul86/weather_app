import WeatherService from "@/services/weather.service";
import AuthService from "@/services/auth.service.js";

export default {
    initializeUser({ commit }) {
        let userId = localStorage.getItem("user_id");
        if (!userId) {
            userId = `user_${Math.random().toString(36).substr(2, 9)}`;
            localStorage.setItem("user_id", userId);
        }
        commit("SET_USER_ID", userId);
    },

    async storeUserLocation({ commit, dispatch, state }) {
        const cityId = localStorage.getItem("cityId");
        if (cityId) {
            dispatch("initializeWeatherData", cityId);
            dispatch("initializeChannel", cityId);
        } else if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async (position) => {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;

                try {
                    const cityResponse =
                        await WeatherService.getCityFromLocation(lat, lon);
                    const { city } = cityResponse;
                    localStorage.setItem("city", city);

                    commit("SET_LOCATION", {
                        city,
                        latitude: lat,
                        longitude: lon,
                    });

                    const locationResponse = await WeatherService.storeLocation(
                        city,
                        lat,
                        lon,
                        state.userId,
                    );
                    const { cityId } = locationResponse;

                    localStorage.setItem("cityId", cityId);

                    commit("SET_CITY_ID", cityId);

                    dispatch("initializeChannel", cityId);
                    dispatch("initializeWeatherData", cityId);
                } catch (error) {
                    console.error(
                        "Hiba történt a hely meghatározása során:",
                        error,
                    );
                }
            });
        } else {
            console.error("Geolocation is not supported by this browser.");
        }
    },

    async initializeWeatherData({ commit }, cityId) {
        try {
            const weatherData = await WeatherService.getWeatherData(cityId);
            commit("SET_WEATHER_DATA", weatherData);
        } catch (error) {
            console.error(
                "Hiba történt az időjárási adatok lekérdezésekor:",
                error,
            );
        }
    },

    initializeChannel({ commit, state }, cityId) {
        if (state.currentChannel) {
            state.currentChannel.unsubscribe();
        }

        const echo = window.Echo;
        const channel = echo
            .channel(`weather-channel.${cityId}`)
            .listen(".weather.updated", (event) => {
                console.log("Weather data received:", event.weatherData);
                commit("SET_WEATHER_DATA", event.weatherData);
            })
            .listen(".pusher:subscription_succeeded", (data) => {
                console.log("Subscribed to channel", data);
            })
            .listen(".pusher:subscription_error", (error) => {
                console.error("Subscription error:", error);
            });

        commit("SET_CHANNEL", channel);
    },

    async login({ commit }, user) {
        try {
            const response = await AuthService.login(user);
            commit("SET_USER", response);
            return response;
        } catch (error) {
            console.error("Login failed:", error);
            throw error;
        }
    },
    async registration({ commit }, user) {
        try {
            const response = await AuthService.registration(user);
            return response;
        } catch (error) {
            console.error("Login failed:", error);
            throw error;
        }
    },

    async logout({ commit }) {
        try {
            await AuthService.logout();
            commit("LOGOUT");
        } catch (error) {
            console.error("Logout failed:", error);
            throw error;
        }
    },
};
