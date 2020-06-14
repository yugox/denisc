import {
    ADD_PERSON,
    DELETE_PERSON,
    EDIT_PERSON,
    FETCH_PERSONS,
    SET_SELECTED_PERSON,
    SET_TOTAL
} from "./type";
import api, {Methods} from "../../api/api";
import {SET_FIELD_ERROR} from "../error/type";
import {ERROR_MODULE} from "../error";

export default {
    async [ADD_PERSON]({ commit, state }, payload) {
        const response = await api.postRequest(
            Methods.post,
            payload.url,
            payload.data.person);

        if (response.status === 200) {
            commit(ADD_PERSON, response.body.data);
            commit(SET_TOTAL, state.total + 1);
        }

        if (response.status === 400) {
            commit(ERROR_MODULE+SET_FIELD_ERROR, response.body, { root: true });
        }

        return response.status;
    },

    async [DELETE_PERSON]({commit}, payload) {
        const persons = payload.data;
        const personsIds = [];
        const indexes = [];

        persons.forEach(function (person) {
            indexes.push(person.index);
            personsIds.push(person.id);
        });

        const response = await api.deleteRequest(
            Methods.delete,
            payload.url + personsIds.join(','));

        if (response.status === 204) {
            commit(DELETE_PERSON, indexes);
        }
    },

    async [EDIT_PERSON]({commit}, payload) {
        const data = payload.data;
        const response = await api.putRequest(
            Methods.put,
            payload.url + data.id,
            data.person);

        if (response.status === 204) {
            data.person.id = data.id;
            commit(EDIT_PERSON,
                {
                    person: data.person,
                    index: data.index
                });
        }

        if (response.status === 400) {
            commit(ERROR_MODULE+SET_FIELD_ERROR, response.body, { root: true });
        }

        return response.status;
    },

    async [FETCH_PERSONS]({commit}, payload) {
        const data = await api.getRequest(Methods.get, payload.url);
        commit(FETCH_PERSONS, data.persons);
        commit(SET_TOTAL, data.total);
    },

    [SET_TOTAL]({commit}, payload) {
        commit(SET_TOTAL, payload);
    },

    [SET_SELECTED_PERSON]({ commit }, payload) {
        commit(SET_SELECTED_PERSON, payload);
    },
};
