export default {
    SET_USER(state, user) {
        state.isAuthenticated = true;
        state.user = user;
        localStorage.setItem("user", JSON.stringify(user));
    },
    LOGOUT(state) {
        state.isAuthenticated = false;
        state.user = null;
        localStorage.removeItem("user");
    },
    SET_USER_ID(state, userId) {
        state.userId = userId;
    },
    SET_LOCATION(state, { city, latitude, longitude }) {
        state.city = city;
        state.latitude = latitude;
        state.longitude = longitude;
    },
    SET_CITY_ID(state, cityId) {
        state.cityId = cityId;
    },
    SET_CHANNEL(state, channel) {
        state.currentChannel = channel;
    },
    SET_WEATHER_DATA(state, weatherData) {
        state.weatherData = weatherData;
    },
};
