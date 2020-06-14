import {ADD_PERSON, DELETE_PERSON, EDIT_PERSON, FETCH_PERSONS, SET_SELECTED_PERSON, SET_TOTAL} from "./type";
import filterElements from "../../../helper/utils/filterElements";

export default {
    [ADD_PERSON](state, payload) {
        state.persons.push(payload);
    },

    [DELETE_PERSON](state, indexes) {
        const filteredElements = filterElements.byIndexes(state.persons, indexes);
        state.persons = filteredElements;
        state.total = filteredElements.length;
    },

    [EDIT_PERSON](state, person) {
        state.persons.splice(person.index, 1);
        state.persons.splice(person.index, 0, person.person);
    },

    async [FETCH_PERSONS](state, payload) {
        state.persons = payload;
    },

    [SET_TOTAL](state, payload) {
        state.total = payload;
    },

    [SET_SELECTED_PERSON](state, payload) {
        state.selectedPerson = payload;
    }
};
