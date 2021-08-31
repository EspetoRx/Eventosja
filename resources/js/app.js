/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import 'vuejs-datatable/dist/themes/bootstrap-4.esm';
import { VuejsDatatableFactory } from 'vuejs-datatable';
Vue.use( VuejsDatatableFactory );


Vue.component('datatable-component', require('./components/Common/DatatableComponent.vue').default);

Vue.component('navbar-component', require('./components/Navbar/NavbarComponent.vue').default);

import Vue from 'vue';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Swal from 'sweetalert2';
window.Swal = Swal;

const Confirme = Swal.mixin({
    showConfirmButton: true,
    showCancelButton: true,
    showCloseButton: true,
    confirmButtonText: 'Sim!',
    cancelButtonText: 'Não!',
    confirmButtonColor: '#38c172',
    cancelButtonColor: '#e3342f',
    icon: 'question',
});

const Carregando = Swal.mixin({
    showConfirmButton: false,
    showCancelButton: false,
    showCloseButton: false,
    allowOutsideClick: false,
    allowEscapeKey: false,
    icon: 'info',
    didOpen: () => {
        Swal.showLoading();
    }
});

window.Confirme = Confirme;
window.Carregando = Carregando;

import VueToastr from "vue-toastr";
Vue.use(VueToastr, {
    defaultTimeout: 7000,
    defaultClassNames: ["animated", "zoomInUp"],
    clickClose: true
});

import VueProgressBar from 'vue-progressbar'

const options = {
	color: '#38c172',
	failedColor: '#e3342f',
	thickness: '7px',
	transition: {
	  speed: '0.2s',
	  opacity: '0.6s',
	  termination: 300
	},
	autoRevert: true,
	location: 'top',
    inverse: false,
    autoFinish: false,
}

Vue.use(VueProgressBar, options)

Vue.config.productionTip = false;

let routes = [
    {
        path: '/eventos',
        component: require('./components/Eventos/EventosComponent.vue').default,
    },
    {
        path: '/eventos/create',
        component: require('./components/Eventos/CreateEventosComponent.vue').default,
    },
    {
        path: '/eventos/edit/:id',
        component: require('./components/Eventos/CreateEventosComponent.vue').default,
        props: true
    },
    {
        path: '/convidados',
        component: require('./components/Convidados/ConvidadosComponent.vue').default,
    },
    {
        path: '/convidados/create',
        component: require('./components/Convidados/CreateConvidadosComponent.vue').default
    },
    {
        path: '/convidados/edit/:id',
        component: require('./components/Convidados/CreateConvidadosComponent.vue').default,
        props: true
    }
];

const router = new VueRouter({
	mode: "history",
	base : __dirname,
	linkActiveClass: "active",
    routes,
});

window.Fire = new Vue();

const app = new Vue({
    el: '#app',
    router,
    components: {}
});
