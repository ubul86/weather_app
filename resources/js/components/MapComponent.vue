<template>
    <div>
        <l-map :zoom="zoom" :center="center" style="height: 400px; width: 100%">
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
