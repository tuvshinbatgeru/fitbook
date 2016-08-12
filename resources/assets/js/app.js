import Vue from 'vue';
import VerifyView from './web/VerifyView.vue';
import IndexView from './web/IndexView.vue';
import SearchView from './web/SearchView.vue';
import ClubEditView from './web/ClubEditView.vue';
import HeaderDefault from './widgets/header/Default.vue';
import _env from '../../../env.js';

var VueResource = require('vue-resource');
Vue.use(VueResource);
Vue.use(require('vue-env'), _env);

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_token').getAttribute('value');

var app = new Vue({
	el : 'body',

	created: function () {
		this.$env.set('APP_ENV', 'Development');
		this.$env.set('APP_URI', 'http://localhost/');
	},

	ready : function () {
		$(document).foundation();
	},

	components : {
		VerifyView, IndexView, SearchView, HeaderDefault, ClubEditView
	},


});