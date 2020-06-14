import {GET_USER, LOGOUT_USER, SET_IS_LOGGED, SET_USER} from "./type";
import api, {Methods} from "../../api/api";
import {_login, _logout} from "../../api/urls";
import secure from "../../../auth/secure";
import {path, router} from "../../../router";
import filterElements from "../../../helper/utils/filterElements";
import {SET_LOGIN_ERROR} from "../error/type";
import {ERROR_MODULE} from "../error";

export default {
    async [SET_USER]({commit}, formData) {
        const response = await api.postRequest(Methods.post, _login, formData.user);

        if (response.status === 102 || response.status === 200) {
            const user = {
                username: formData.user.username,
                token: response.body.token,
                refreshToken: response.body.refreshToken
            }
            secure.setUserToLocalStorage(user);
            commit(SET_USER, user);
            commit(SET_IS_LOGGED, true);
            commit(ERROR_MODULE+SET_LOGIN_ERROR, false, { root: true });
            setTimeout( () => router.push(path.home), 2000);

        }

        if(response.status === 401) {
            commit(ERROR_MODULE+SET_LOGIN_ERROR, true, { root: true });
        }

        return response;
    },
    [LOGOUT_USER]({ commit, getters }) {
        const user = secure.getUserToLocalStorage();
        api.putRequest(Methods.put, _logout, {token: user.token});
        commit(SET_USER, filterElements.byKeyValue(getters[GET_USER], 'token', user.token));
        secure.removeUserFromLocalStorage();
        commit(SET_IS_LOGGED, false);
        router.push(path.login);
    }
};
