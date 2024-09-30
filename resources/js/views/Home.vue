<template>
    <v-main>
        <v-container>
            <v-row>
                <v-col cols="12">
                    <LocationSwitchComponent />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="6">
                    <v-skeleton-loader v-if="!weatherData" type="card" />
                    <TemperatureCardComponent
                        v-if="weatherData"
                        :weatherData="weatherData"
                        class="w-50"
                    />
                </v-col>
                <v-col cols="12" md="6">
                    <v-skeleton-loader v-if="!weatherData" type="card" />
                    <HumidityCardComponent
                        v-if="weatherData"
                        :humidity="weatherData.current.relative_humidity_2m"
                        class="w-50"
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-skeleton-loader v-if="!weatherData" type="card" />
                    <ChartComponent
                        v-if="weatherData"
                        :weatherData="weatherData"
                    />
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
import ChartComponent from "../components/ChartComponent.vue";
import TemperatureCardComponent from "../components/TemperatureCardComponent.vue";
import HumidityCardComponent from "../components/HumidityCardComponent.vue";
import LocationSwitchComponent from "../components/LocationSwitchComponent.vue";

export default {
    components: {
        ChartComponent,
        TemperatureCardComponent,
        HumidityCardComponent,
        LocationSwitchComponent,
    },
    computed: {
        cityId() {
            return this.$store.state.cityId;
        },
        weatherData() {
            return this.$store.state.weatherData;
        },
    },
    data() {
        return {
            cityId: null,
        };
    },
};
</script>

<style>
@import "vuetify/dist/vuetify.min.css";
</style>
