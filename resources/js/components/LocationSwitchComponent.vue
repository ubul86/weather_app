<template>
    <v-select
        :items="cities"
        v-model="selectedCity"
        label="Select a City"
        @change="onCityChange"
        item-value="id"
        item-text="name"
    ></v-select>
</template>

<script>
import CityService from "../services/city.service.js";

export default {
    data() {
        return {
            cities: [],
            selectedCity: localStorage.getItem("cityId") || null,
        };
    },
    created() {
        this.fetchCities();
    },
    methods: {
        fetchCities() {
            CityService.getCities()
                .then((response) => {
                    this.cities = response;
                })
                .catch((error) => {
                    console.error("Failed to fetch cities:", error);
                });
        },
        onCityChange(cityId) {
            if (cityId) {
                localStorage.setItem("cityId", cityId);

                this.$store.dispatch("initializeChannel", cityId);
                this.$store.dispatch("initializeWeatherData", cityId);

                const cityItem = this.cities.find((item) => item.id === cityId);

                this.$store.commit("SET_CHANNEL", {
                    city: cityItem.name,
                    latitude: cityItem.latitude,
                    longitude: cityItem.longitude,
                });
            }
        },
    },
};
</script>
