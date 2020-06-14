import Vue from 'vue'
import VueLodash from 'vue-lodash'

import lodash from 'lodash'
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

import {router} from './router/index';
import {store} from './store/store';
import secure from './auth/secure';

import App from './App.vue';

Vue.config.productionTip = false;
Vue.use(VueLodash, {lodash: lodash})
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

secure.authRoutes();

new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app')
