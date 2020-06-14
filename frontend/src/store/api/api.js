import Vue from 'vue';
import VueResource from 'vue-resource';
import secure from "../../auth/secure";

Vue.use(VueResource);

Vue.http.interceptors.push((request, next) => {
    request.headers.set('Accept', 'application/json')

    const user = secure.getUserToLocalStorage();
    if(user !== null) {
        request.headers.set('Authorization', 'Bearer '+ user.token);
    }

    next((response) => {
        const status = response.status;
        if(status === 401) {
            secure.removeUserFromLocalStorage();
        }
    })
});

export const Methods = {
    delete: 'DELETE',
    get: 'GET',
    post: 'POST',
    put: 'PUT',
};

export async function postRequest(method, url, data) {
    if (method !== Methods.post) {
        return;
    }

    return await Vue.http.post(url, data)
        .then(response => {
            return response;
        })
        .catch(function (error) {
            return error;
        });
}

export async function getRequest(method, url) {
    if (method !== Methods.get) {
        return;
    }

    return await Vue.http.get(url)
        .then(response => {
            return response.data.data;
        })
        .catch(function (error) {
            return error;
        });
}

export async function putRequest(method, url, data) {
    if (method !== Methods.put) {
        return;
    }

    return await Vue.http.put(url, data)
        .then(response => {
            return response;
        })
        .catch(function (error) {
            return error;
        });
}

export async function deleteRequest(method, url) {
    if (method !== Methods.delete) {
        return;
    }

    return await Vue.http.delete(url)
        .then(response => {
            return response;
        })
        .catch(function (error) {
            return error;
        });
}

export default {
    postRequest,
    getRequest,
    putRequest,
    deleteRequest
}
