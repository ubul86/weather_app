import Vue from "vue";
import Router from "vue-router";
import Activation from "../views/Activation.vue";
import Home from "../views/Home.vue";

Vue.use(Router);

export default new Router({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "Home",
            component: Home,
        },
        {
            path: "/activation/:token",
            name: "Activation",
            component: Activation,
        },
    ],
});
