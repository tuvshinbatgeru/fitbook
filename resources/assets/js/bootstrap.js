
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');

require('./dependency/jquery.fileupload');
require('./dependency/jquery-ui.min');
require('./dependency/jquery.ui.touch-punch');
require('./dependency/foundation');
require('./dependency/jquery.tokenize');
require('./dependency/tabs');
require('./dependency/dropdown');
require('./dependency/velocity.min');
require('./dependency/transition');
require('./dependency/collapse');
require('./dependency/bootstrap-datetimepicker');

/*require('./dependency/tooltip');*/

import Chart from 'chart.js';

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
require('vue-resource');
Vue.use(require('vue-i18n'));

//global components
import CustomModal from './components/CustomModal.vue';
import CustomToast from './components/CustomToast.vue';
import CustomButton from './actors/application/components/CustomButton.vue';

import Multiselect from 'vue-multiselect'

Vue.component('CustomModal', CustomModal);
Vue.component('CustomToast', CustomToast);
Vue.component('Multiselect', Multiselect);
Vue.component('CustomButton', CustomButton);


//common tools
import Tools from './settings/Tools.js';

//global storage
import _env from '../../../env.js';

//language support
import locales from './lang/locales';

Object.keys(locales).forEach(function (lang) {
  Vue.locale(lang, locales[lang])
})

Vue.use(Tools);
Vue.use(require('vue-env'), _env);




/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */
/*
Vue.http.interceptors.push((request, next) => {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;

    next();
});*/

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
