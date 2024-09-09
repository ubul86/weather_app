<template>
    <div>
        <l-map :zoom="zoom" :center="center" class="map-leaflet">
            <l-tile-layer
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                attribution="&copy; <a href='https://www.openstreetmap.org/copyright'>OpenStreetMap</a> contributors"
            ></l-tile-layer>

            <l-marker :lat-lng="center">
                <l-popup>{{ city.name }}</l-popup>
            </l-marker>
        </l-map>
    </div>
</template>

<script>
import { LMap, LTileLayer, LMarker, LPopup } from "vue2-leaflet";
import "leaflet/dist/leaflet.css";

export default {
    name: "MapComponent",
    components: {
        LMap,
        LTileLayer,
        LMarker,
        LPopup,
    },
    props: {
        latitude: {
            type: Number,
            required: true,
        },
        longitude: {
            type: Number,
            required: true,
        },
        city: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            zoom: 13,
        };
    },
    computed: {
        center() {
            return [this.latitude, this.longitude];
        },
    },
};
</script>

<style scoped>
.map-leaflet {
    height: 400px;
    width: 100%;
    z-index: 1;
    position: relative;
}
</style>
