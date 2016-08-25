
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import Chart from 'chart.js';

import VerifyView from './web/VerifyView.vue';
import IndexView from './web/IndexView.vue';
import SearchView from './web/SearchView.vue';
import ProfileView from './web/ProfileView.vue';
import ProfileEditView from './web/ProfileEditView.vue';
import ClubEditView from './web/ClubEditView.vue';

import HeaderDefault from './widgets/header/Default.vue';
import TeacherDefault from './widgets/content/TeacherDefault.vue';
import TrainingDefault from './widgets/content/TrainingDefault.vue';

import CustomModal from './components/CustomModal.vue';
import CustomToast from './components/CustomToast.vue';

import Tools from './settings/Tools.js';
import _env from '../../../env.js';


Vue.debug = true;
Vue.component('example', require('./components/Example.vue'));
Vue.component('CustomModal', CustomModal);
Vue.component('CustomToast', CustomToast);
Vue.use(require('vue-resource'));
Vue.use(require('vue-env'), _env);
Vue.use(Tools);


const app = new Vue({
	el : 'body',

	created: function () {
		this.$env.set('APP_ENV', 'Development');
		this.$env.set('APP_URI', 'http://localhost/');
	},

	ready : function () {
		$(document).foundation();
		const toast = this.$refs.toast;
	},

	components : {
		VerifyView, IndexView, SearchView, 
		HeaderDefault, ClubEditView, TeacherDefault,
		TrainingDefault, ProfileView, ProfileEditView
	},
});
