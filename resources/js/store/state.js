export default {
    isAuthenticated: !!localStorage.getItem("user"),
    user: JSON.parse(localStorage.getItem("user")) || null,
    userId: null,
    city: null,
    latitude: null,
    longitude: null,
    cityId: null,
    currentChannel: null,
    weatherData: null,
};
