import {USER} from "../store/modules/user/type";
import {path, router} from "../router";

function authRoutes() {
    router.beforeEach((to, from, next) => {
        const publicPages = [path.login];
        const authRequired = !publicPages.includes(to.path);
        const loggedIn = JSON.parse(localStorage.getItem(USER)) !== null;

        if (authRequired && !loggedIn) {
            next(path.login);
        }

        if (!authRequired && loggedIn) {
            next(path.home);
        }

        next();
    });
}

function setUserToLocalStorage(user) {
    localStorage.setItem(USER, JSON.stringify(user));
}

function getUserToLocalStorage() {
    return JSON.parse(localStorage.getItem(USER))
}

function removeUserFromLocalStorage() {
    localStorage.removeItem(USER);
}

export default {
    authRoutes,
    setUserToLocalStorage,
    getUserToLocalStorage,
    removeUserFromLocalStorage
}