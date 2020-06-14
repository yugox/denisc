import Vue from 'vue';
import Vuex from 'vuex';
import PersonModule from './modules/person';
import UserModule from './modules/user';
import ErrorModule from './modules/error';

Vue.use(Vuex);



export const store = new Vuex.Store({
    modules: {
        ErrorModule,
        PersonModule,
        UserModule,
    }
});
