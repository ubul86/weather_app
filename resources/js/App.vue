<template>
  <v-app>
    <Header />
    <v-main>
      <v-container>
          <v-row>
              <v-col cols="12" md="6">
                  <v-skeleton-loader v-if="!weatherData" type="card" />
                  <TemperatureCardComponent v-if="weatherData" :weatherData="weatherData" class="w-50" />
              </v-col>
              <v-col cols="12" md="6">
                  <v-skeleton-loader v-if="!weatherData" type="card" />
                  <HumidityCardComponent v-if="weatherData" :humidity="weatherData.current.relative_humidity_2m" class="w-50" />
              </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
                <v-skeleton-loader v-if="!weatherData" type="card" />
                <ChartComponent v-if="weatherData" :weatherData="weatherData" />
            </v-col>
          </v-row>

      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import Header from './components/Header.vue';
import ChartComponent from "@/components/ChartComponent.vue";
import TemperatureCardComponent from "@/components/TemperatureCardComponent.vue";
import HumidityCardComponent from "@/components/HumidityCardComponent.vue";

export default {
  components: {
    Header, ChartComponent, TemperatureCardComponent, HumidityCardComponent
  },
  computed: {
      cityId() {
          return this.$store.state.cityId;
      },
      weatherData() {
          return this.$store.state.weatherData
      }
  },
    data() {
        return {
            cityId: null
        };
    },
    watch: {
        cityId(newCityId, oldCityId) {
            if (newCityId !== oldCityId) {
                this.$store.dispatch('initializeChannel', newCityId);
                this.$store.dispatch('initializeWeatherData', newCityId);
            }
        }
    },
  created() {
      this.$store.dispatch('initializeUser');
      this.$store.dispatch('storeUserLocation');
  }
};
</script>

<style>
@import 'vuetify/dist/vuetify.min.css';
</style>
