import Vue from 'vue';
import VerifyView from './web/VerifyView.vue';
import IndexView from './web/IndexView.vue';
import SearchView from './web/SearchView.vue';
import ClubEditView from './web/ClubEditView.vue';
import HeaderDefault from './widgets/header/Default.vue';
import TeacherDefault from './widgets/content/TeacherDefault.vue';
import TrainingDefault from './widgets/content/TrainingDefault.vue';
import _env from '../../../env.js';
import CustomModal from './components/CustomModal.vue';
import CustomToast from './components/CustomToast.vue';
import Tools from './settings/Tools.js';

Vue.debug = true;
Vue.component('CustomModal', CustomModal);
Vue.component('CustomToast', CustomToast);
Vue.use(require('vue-resource'));
Vue.use(require('vue-env'), _env);
Vue.use(Tools);

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_token').getAttribute('value');

var app = new Vue({
	el : 'body',

	created: function () {
		this.$env.set('APP_ENV', 'Development');
		this.$env.set('APP_URI', 'http://localhost/');
	},

	ready : function () {
		$(document).foundation();
		const toast = this.$refs.toast;
	},

	methods : {
		test : function () {
			var param = encodeURIComponent(JSON.stringify([ 'foo', 'bar' ]));
			alert(param);

			this.$http.post(this.$env.get('APP_URI') + 'api/test?data=' + param).then((response) => 
			{
				debugger;
			}, (response) => {

			});	
		}
	},

	components : {
		VerifyView, IndexView, SearchView, 
		HeaderDefault, ClubEditView, TeacherDefault,
		TrainingDefault,
	},
});