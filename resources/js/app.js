/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



window.Vue = require('vue').default;
import Vue2Filters from 'vue2-filters'
import VueProgressBar from 'vue-progressbar'
import VModal from 'vue-js-modal';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-default.css';
import VueHtmlToPaper from 'vue-html-to-paper';

require('./bootstrap');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('cost-estimate-form', require('./components/estimate-form/cost-form.vue').default);
Vue.component('detail-estimate-form', require('./components/estimate-form/detail-form.vue').default);
Vue.component('Activity', require('./components/estimate-form/activity').default);
// Vue.component('estimate-form-2', require('./components/estimate-form/form_2.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(Vue2Filters)
Vue.use(VModal);
Vue.use(VueToast);
const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'left',
    inverse: false
}

Vue.use(VueProgressBar, options)
const app = new Vue({
    el: '#app'
});

Vue.use(VueHtmlToPaper);