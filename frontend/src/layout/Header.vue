<template>
    <header style="margin-bottom: 100px">
        <nav class="navbar navbar-expand-lg navbar-dark rounded border fixed-top bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav w-100">
                    <router-link v-if="isLogged" class="nav-item" :to="home" tag="li" active-class="active" exact>
                        <a class="nav-link">
                            <i class="fa fa-fw fa-home"></i>
                            Startseite
                        </a>
                    </router-link>
                    <router-link v-if="isLogged" class="nav-item" :to="about" tag="li" active-class="active">
                        <a class="nav-link">
                            <i class="fa fa-fw fa-user"></i>
                            Über mich
                        </a>
                    </router-link>
                    <router-link v-if="isLogged" class="nav-item" :to="career" tag="li" active-class="active">
                        <a class="nav-link">
                            <i class="fa fa-fw fa-black-tie"></i>
                            Mein Werdegang
                        </a>
                    </router-link>
                    <router-link v-if="!isLogged" class="nav-item" :to="login" tag="li" active-class="active">
                        <a class="nav-link">
                            <i class="fa fa-fw fa-user-circle"></i>
                            Login
                        </a>
                    </router-link>
                    <li v-if="isLogged" id="logoutBtn" style="cursor: pointer" class="nav-item">
                        <a class="nav-link" @click="logout()">
                            <i class="fa fa-fw fa-power-off"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
    import {path} from "../router";
    import secure from "../auth/secure";
    import {IS_LOGGED, LOGOUT_USER} from "../store/modules/user/type";
    import {mapActions, mapGetters} from "vuex";
    import {USER_MODULE} from "../store/modules/user";

    export default {
        data() {
            return {
                home: path.home,
                about: path.about,
                career: path.career,
                login: path.login,
            }
        },

        computed: {
            ...mapGetters(USER_MODULE, [IS_LOGGED]),

            isLogged() {
                if(this[IS_LOGGED] === false && secure.getUserToLocalStorage() !== null) {
                    return true;
                }

                return this[IS_LOGGED];
            }
        },

        methods: {
            ...mapActions(USER_MODULE, [LOGOUT_USER]),

            logout() {
                this[LOGOUT_USER]();
            }
        },
    }
</script>

<style lang="scss" scoped>
    @media (min-device-width: 1000px) {
        #logoutBtn {
            position: absolute;
            right: 10px;
        }
    }

</style>
