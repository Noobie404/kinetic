<template>
    <div class="wrapper">
        <!-- Navbar -->
        <Navbar />
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <!-- @include('layouts.sidebar') -->
        <Sidebar />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit customer</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="#">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Edit customer</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Fillup customer information</div>
                            <div class="card-body" v-if="CustomerInfo">
                                <Form @submit="submitCustomer" :validation-schema="schema">
                                    <Field
                                        name="customer_id"
                                        type="hidden"
                                        class="form-control"
                                        v-model="CustomerInfo.id"
                                    />
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div
                                                v-if="message"
                                                class="alert alert-danger"
                                                role="alert"
                                            >{{ message }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">
                                                    Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <Field
                                                    name="name"
                                                    type="text"
                                                    id="name"
                                                    class="form-control"
                                                    placeholder="Enter Name"
                                                    autocomplete="nope"
                                                    v-model="CustomerInfo.name"
                                                />
                                                <ErrorMessage
                                                    name="name"
                                                    class="error-feedback text-danger"
                                                />
                                                <div for="name" class="text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">
                                                    Email
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <Field
                                                    name="email"
                                                    id="email"
                                                    type="email"
                                                    class="form-control"
                                                    placeholder="Enter email"
                                                    v-model="CustomerInfo.email"
                                                />
                                                <ErrorMessage
                                                    name="email"
                                                    class="error-feedback text-danger"
                                                />
                                                <div for="email" class="text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">
                                                    Password
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <Field
                                                    name="password"
                                                    type="password"
                                                    id="password"
                                                    class="form-control"
                                                    placeholder="Enter password"
                                                    autocomplete="new-password"
                                                />
                                                <ErrorMessage
                                                    name="password"
                                                    class="error-feedback text-danger"
                                                />
                                                <p>Leave empty if you do not want to change password</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">
                                                    Confirm password
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <Field
                                                    name="confirmPassword"
                                                    type="password"
                                                    id="password"
                                                    class="form-control"
                                                    placeholder="Enter password"
                                                    autocomplete="new-password"
                                                />
                                                <ErrorMessage
                                                    name="confirmPassword"
                                                    class="error-feedback text-danger"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                                :disabled="loading"
                                            >
                                                <span
                                                    v-show="loading"
                                                    class="spinner-border spinner-border-sm"
                                                ></span>
                                                <span>Submit</span>
                                            </button>
                                        </div>
                                    </div>
                                </Form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">Anything you want</div>
            <!-- Default to the left -->
            <strong>Copyright &copy;</strong> All rights reserved.
        </footer>
    </div>
</template>
<script>
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import Sidebar from "../../Layouts/Admin/Sidebar";
import Navbar from "../../Layouts/Admin/Navbar";
export default {
    components: {
        Form,
        Field,
        ErrorMessage,
        Navbar,
        Sidebar,
    },
    data() {
        const schema = yup.object().shape({
            name: yup.string().required("Name is required!"),
            email: yup
                .string()
                .required("Email is required!")
                .email("Email is invalid"),
            password: yup
                .string()
                .min(6, "Must be at least 6 characters!")
                .max(40, "Must be maximum 40 characters!"),
            confirmPassword: yup
                .string()
                .oneOf([yup.ref("password"), null], "Passwords must match"),
        });
        return {
            loading: false,
            message: "",
            schema,
            passwordFieldType: "password",
            activeHover: "none",
        };
    },
    methods: {
        reInitialize() {
            this.loadCustomerInfo();
        },
        toggleUserDrop() {
            if (this.activeHover == "none") {
                this.activeHover = "block";
            } else {
                this.activeHover = "none";
            }
        },
        submitCustomer(customer) {
            this.loading = true;
            this.$store.dispatch("customer/customerUpdate", customer).then(
                (response) => {
                    this.loading = false;
                },
                (error) => {
                    this.loading = false;
                    if (error.response.status == 401) {
                        this.$router.push("/customer/login");
                    }
                    if (error.response.status == 422) {
                        let errors = error.response.data.error;
                        for (let i in errors) {
                            document.querySelector("div[for='" + i + "']").innerHTML =
                                errors[i][0];
                        }
                    } else {
                        this.message =
                            (error.response &&
                                error.response.data &&
                                error.response.data.message) ||
                            error.message ||
                            error.toString();
                    }
                }
            );
        },
        loadCustomerInfo() {
            this.$store.dispatch("customer/loadCustomerInfo", this.$route.params.id);
        },
    },
    mounted() { },
    created() {
        this.loadCustomerInfo();
    },
    computed: {
        currentUser() {
            return this.$store.state.auth.initialState.user.user;
        },
        CustomerInfo() {
            return this.$store.state.customer.CustomerInfo;
        },
        toastMessage() {
            return this.$store.state.customer.toastMessage;
        },
    },
    filters: {},
    watch: {
        toastMessage(val) {
            if (val) {
                this.$toast.show(val, {
                    type: this.$store.state.customer.toastType,
                    position: "top-right",
                });
                setTimeout(this.$toast.clear, 30000);
            }
        },
    },
};
</script>
