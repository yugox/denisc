import {SET_FIELD_ERROR, SET_LOGIN_ERROR} from './type';

export default {
    [SET_FIELD_ERROR]({ commit }, payload) {
        commit(SET_FIELD_ERROR, payload);
    },

    [SET_LOGIN_ERROR]({ commit }, payload) {
        commit(SET_LOGIN_ERROR, payload);
    },
}
