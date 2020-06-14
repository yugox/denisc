// Die Getter sind nur zur Demonstration angelegt. Normalerweise wird in solch einem Fall kein Getter benötigt.
// Wenn nur der state zurückgegeben wird, dann kann man auch direkt auf den state zugreifen.
// Getter machen nur Sinn, wenn man noch etwas mit dem state macht, wie z.B. einen filter einsetzen.

import {GET_PERSONS, GET_TOTAL} from "./type";

export default {
    [GET_PERSONS]: state => {
        return state.persons;
    },

    [GET_TOTAL]: state => {
        return state.total;
    },
};
