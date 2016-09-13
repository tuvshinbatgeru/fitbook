
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//Application pages
import VerifyView from './web/VerifyView.vue';
import IndexView from './web/IndexView.vue';
import SearchView from './web/SearchView.vue';
import ProfileView from './web/ProfileView.vue';
import ProfileEditView from './web/ProfileEditView.vue';
import ClubEditView from './web/ClubEditView.vue';
import ClubView from './web/ClubView.vue';
import PlanView from './web/PlanView.vue';
import ReceptionDashboardView from './web/ReceptionDashboardView.vue';

Vue.debug = true;
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_token').getAttribute('value');
Vue.config.lang = 'en';

const app = new Vue({
	el : 'body',

	created: function () {
		this.$env.set('APP_ENV', 'Development');
		this.$env.set('APP_URI', 'http://localhost/');
		this.$env.set('APP_LANG', 'en');
	},

	ready : function () {
		$(document).foundation();
		const toast = this.$refs.toast;
	},

	components : {
		VerifyView, IndexView, SearchView, ClubEditView,
		ProfileView, ProfileEditView, ClubView, PlanView, 
		ReceptionDashboardView
	},
});
