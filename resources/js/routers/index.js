import Vue from 'vue';
import Router from 'vue-router';
import Activation from '../views/Activation.vue';

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/activation/:token',
            name: 'Activation',
            component: Activation,
        },
    ],
});
