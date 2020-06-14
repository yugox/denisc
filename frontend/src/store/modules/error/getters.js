// Die Getter sind nur zur Demonstration angelegt. Normalerweise wird in solch einem Fall kein Getter benötigt.
// Wenn nur der state zurückgegeben wird, dann kann man auch direkt auf den state zugreifen.
// Getter machen nur Sinn, wenn man noch etwas mit dem state macht, wie z.B. einen filter einsetzen.

import {GET_FIELD_ERRORS, HAS_LOGIN_ERROR} from "./type";

export default {
    [GET_FIELD_ERRORS](state) {
        return state.fieldErrors;
    },

    [HAS_LOGIN_ERROR](state) {
        return state.loginError;
    }
}
