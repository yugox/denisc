import {SET_IS_LOGGED, SET_USER} from "./type";

export default {
    [SET_USER](state, user) {
        state.users.push(user);
    },
    [SET_IS_LOGGED](state, payload) {
        state.isLogged = payload
    },
};
