/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import wysiwyg from "vue-wysiwyg";
import Vuex from 'Vuex'
import "vue-wysiwyg/dist/vueWysiwyg.css";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VModal from 'vue-js-modal'
import SweetModal from 'sweet-modal-vue/src/plugin.js'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ActivityIndicator from 'vue-activity-indicator'

Vue.use(SweetModal)
Vue.use(ActivityIndicator)
Vue.use(VModal)
Vue.use(VueSweetalert2);
Vue.use(VueAxios, axios)
Vue.use(wysiwyg);

// axios.defaults.baseURL = `http://admin.pinnacleonline.org/api`
axios.defaults.baseURL = `http://pinnacle.test`

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.use(Vuex);
Vue.component('site-component', require('./components/Site.vue').default);
Vue.component('courses-component', require('./components/Courses.vue').default);
Vue.component('add-courses', require('./components/AddCourse.vue').default);
Vue.component('create-category', require('./components/AddCategory.vue').default);
Vue.component('modules-component', require('./components/ModuleComponent.vue').default);
Vue.component('add-tutor', require('./components/AddTutor.vue').default);
Vue.component('all-course', require('./components/AllCourses.vue').default);
Vue.component('add-module', require('./components/AddModuleCard.vue').default);
Vue.component('add-question', require('./components/AddQuestions.vue').default);
Vue.component('module-list', require('./components/courseModulesList.vue').default);
Vue.component('edit-course', require('./components/EditCourse.vue').default);
Vue.component('add-blog', require('./components/addBlog.vue').default);
Vue.component('testimonials-component', require('./components/testimonials.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});