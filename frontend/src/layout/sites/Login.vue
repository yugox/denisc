<template>
    <div class="row">
        <div v-if="!isLogged" class="login-form">
            <div v-if="showMessage" :class="alertClasses" role="alert">
                {{ this.hasError
                ? 'Benutzername oder Passwort ist nicht korrekt'
                : 'Erfolgreich eingeloggt' }}
            </div>
            <form @submit.prevent>
            <h2 class="text-center">Login</h2>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text"
                           class="form-control"
                           placeholder="Username"
                           required="required"
                           v-model="user.username">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input :type="showPassword ? 'text' : 'password'"
                           class="form-control"
                           placeholder="Password"
                           required="required"
                           v-model="user.password" />
                    <i style="cursor: pointer" class="position-absolute fa fa-eye"
                       title="Passwort anzeigen"
                    @click="showPassword = !showPassword"></i>
                </div>
            </div>
                <div v-if="!inProcess" class="form-group">
                    <button :disabled="!hasFieldValues" class="btn btn-primary login-btn btn-block" @click="onSubmit()">
                        Login
                    </button>
                </div>
                <div v-else class="justify-content-center col">
                    <b-spinner variant="primary" label="Text Centered"></b-spinner>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {SET_USER} from "../../store/modules/user/type";
    import {mapActions, mapGetters} from "vuex";
    import secure from "../../auth/secure";
    import {HAS_LOGIN_ERROR} from "../../store/modules/error/type";
    import {USER_MODULE} from "../../store/modules/user";
    import {ERROR_MODULE} from "../../store/modules/error";

    export default {
        data() {
            return {
                user: {
                    username: '',
                    password: '',
                },
                showMessage: false,
                showPassword: false,
                inProcess: false,
            }
        },

        computed: {
            ...mapGetters(ERROR_MODULE, [HAS_LOGIN_ERROR]),

            isLogged() {
                return secure.getUserToLocalStorage() !== null;
            },

            hasError() {
                return this[HAS_LOGIN_ERROR];
            },

            alertClasses() {
                return {
                    'alert alert-danger': this.hasError,
                    'alert alert-success': !this.hasError,
                }
            },

            hasFieldValues() {
                return !(this.user.username === '' || this.user.password === '');
            }
        },

        methods: {
            ...mapActions(USER_MODULE, [SET_USER]),

            async onSubmit() {

                if(!this.hasFieldValues) {
                    return;
                }

                this.inProcess = true;
                const formData = {
                    user: {
                        username: this.user.username,
                        password: this.user.password,
                    }
                }

                const response = await this[SET_USER](formData);

                this.showMessage = true;

                if(response.status !== 200) {
                    this.inProcess = false;
                }
            },
        },
    }
</script>

<style lang="scss" scoped>
    @import '../../scss/global.scss';

    .login-form {
        width: 385px;
        margin: 30px auto;
    }

    .login-form {
        margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0 0 10px 9px rgba(0, 0, 0, 0.8);
        padding: 30px;
    }

    .login-form h2 {
        margin: 0 0 15px;
    }

    .form-control, .login-btn {
        min-height: 38px;
        border-radius: $borderRadius;
    }

    .input-group-addon {
        padding-left: 10px;
        background-color: #007bff;
        border-top-left-radius: $borderRadius;
        border-bottom-left-radius: $borderRadius;
    }

    .input-group-addon .fa {
        color: #ffffff;
        font-size: 18px;
        margin-top: 10px;
        margin-right: 10px;
    }

    .login-btn {
        font-size: 15px;
        font-weight: bold;
    }

    .fa-eye {
        right: 10px;
        top: 10px;
    }
</style>