<template>
    <v-card class="temperature-card">
        <v-card-subtitle>{{ city }}</v-card-subtitle>
        <v-card-text>
            <v-row>
                <v-col cols="12" justify="center">
                    <div class="temperature mb-5">{{ temperature }}°C</div>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-row justify="center">
                <v-col cols="6">
                    <div>{{ city }}</div>
                </v-col>
                <v-col cols="6">
                    <div>{{ formattedTime }}</div>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: "TemperatureCard",
    props: {
        weatherData: {
            type: Object,
            required: true,
        },
    },
    computed: {
        city() {
            return this.$store.state.city;
        },
        temperature() {
            return this.weatherData.current.temperature_2m;
        },
        formattedTime() {
            const date = new Date(this.weatherData.current.time);
            return date.toLocaleString();
        },
    },
};
</script>

<style scoped>
.temperature-card {
    text-align: center;
}

.weather-icon {
    width: 100px;
    height: 100px;
}

.temperature {
    font-size: 2.5em;
    font-weight: bold;
}

.weather-main {
    font-size: 1.2em;
}
</style>
