<template>
    <v-card class="humidity-card">
        <v-card-title class="headline">Humidity</v-card-title>
        <v-card-text>
            <v-progress-circular
                :size="200"
                :width="20"
                :rotate="220"
                :value="computedHumidity"
                color="blue"
            >
                <span class="humidity-label">{{ humidity }}%</span>
            </v-progress-circular>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: "HumidityCard",
    props: {
        humidity: {
            type: Number,
            required: true,
        },
    },
    computed: {
        computedHumidity() {
            return this.humidity;
        },
    },
};
</script>

<style scoped>
.humidity-card {
    text-align: center;
}

.humidity-label {
    font-size: 2em;
    font-weight: bold;
}
</style>
