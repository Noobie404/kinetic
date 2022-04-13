<template>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <router-link class="navbar-brand" to="/">Kinetik</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <router-link class="nav-link" to="/login">Admin Login</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/customer/login">Customer Login</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/registration">Register</router-link>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Login</div>
                <div class="card-body">
                    <Form @submit="handleLogin" :validation-schema="schema">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div v-if="message" class="alert alert-danger" role="alert">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>
                            <div class="col-md-6">
                                <Field name="email" type="text" class="form-control" placeholder="Enter Email" autocomplete="email" value="admin@gmail.com" required autofocus />
                                <ErrorMessage name="email" class="error-feedback text-danger text-capitalize" />
                            </div>
                        </div>
                        <div class="form-group row login-input">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <Field name="password" :type="passwordFieldType" class="form-control" placeholder="Enter password" value="123456" autocomplete="current-password" required/>
                                <i class="cursor-pointer far fa-eye" :class="passwordToggleIcon" @click="togglePasswordVisibility"></i>
                                <ErrorMessage name="password" class="error-feedback text-danger text-capitalize" />
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" :disabled="loading">
                                    <span v-show="loading" class="spinner-border spinner-border-sm"></span>
                                    <span>Login</span>
                                </button>
                                <router-link class="btn btn-link" to="/forgot_password">Forgot Your Password?</router-link>
                            </div>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
export default {
    name: "Login",
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    data() {
        const schema = yup.object().shape({
            email: yup.string().required("Email is required!"),
            password: yup.string().required("Password is required!"),
        });
        return {
            loading: false,
            message: "",
            schema,
            passwordFieldType: 'password'
        };
    },
    watch: {
        '$route': 'reInitialize',
    },
    computed: {
        loggedIn() {
            return this.$store.state.auth.initialState.status.loggedIn;
        },
        passwordToggleIcon() {
            return this.passwordFieldType === 'password' ? 'far fa-eye' : 'far fa-eye-slash';
        },
    },
    created() {
        if (this.loggedIn) {
            this.$router.push("/");
        }
    },
    methods: {
        handleLogin(user) {
            this.loading = true;
            this.$store.dispatch("auth/login", user).then(
                (response) => {
                    console.log(response);
                    this.loading = false;
                    this.$router.push(this.$route.query.redirect || '/');
                },
                (error) => {
                    this.loading = false;
                    this.message =
                        (error.response &&
                            error.response.data &&
                            error.response.data.message) ||
                        error.message ||
                        error.toString();
                }
            );
        },
        togglePasswordVisibility() {
            this.passwordFieldType = this.passwordFieldType === 'password' ? 'text' : 'password'
        },
    },
};
</script>
<style scoped>
.form-group.login-input i {
    position: absolute;
    right: 25px;
    top: 0;
    line-height: 2;
    font-size: 17px;
}
.form-group.login-input {
    position: relative;
}
</style>
