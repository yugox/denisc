import {SET_FIELD_ERROR, SET_LOGIN_ERROR} from './type';

export default {
    [SET_FIELD_ERROR](state, payload) {
        state.fieldErrors = [];
        state.fieldErrors.push(payload);
    },

    [SET_LOGIN_ERROR](state, payload) {
        state.loginError = payload;
    }
}
