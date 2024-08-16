<template>
    <div>
        <v-select
            :items="cities"
            v-model="selectedCity"
            label="Select a City"
            @change="onCityChange"
            item-value="id"
            item-text="name"
            class="v-select--z-index-1000"
        ></v-select>
        <MapComponent
            v-if="selectedCity"
            :latitude="selectedCity.latitude"
            :longitude="selectedCity.longitude"
            :city="selectedCity"
        />
    </div>
</template>

<script>
import CityService from "../services/city.service.js";
import MapComponent from "@/components/MapComponent.vue";

export default {
    components: {
        MapComponent,
    },
    computed: {
        selectedCity() {
            return this.cities.find((city) => city.id === this.selectedCityId);
        },
        selectedCityId() {
            return localStorage.getItem("cityId");
        },
    },
    data() {
        return {
            cities: [],
            selectedCity: null,
            selectedCityId: null,
        };
    },
    mounted() {
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

                this.selectedCity = cityItem;

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

<style scoped>
.v-select--z-index-1000 {
    z-index: 1000;
}
</style>
