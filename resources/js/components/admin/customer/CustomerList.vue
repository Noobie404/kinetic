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
                            <h1 class="m-0">Customer List</h1>
                            <router-link to="/customer/new" class="btn btn-sm btn-primary mt-2">
                                <i class="fa fa-plus"></i> Add new customer
                            </router-link>
                            <!-- <a href="/" class="btn btn-sm btn-primary mt-2"><i class="fa fa-plus"></i>  Add new customer</a> -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="#">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Customer List</li>
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
                        <div v-if="message" class="alert alert-danger" role="alert">{{ message }}</div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(CustomerList, index) in CustomerList"
                                v-bind:key="CustomerList.id"
                            >
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ CustomerList.name }}</td>
                                <td>{{ CustomerList.email }}</td>
                                <td>{{ CustomerList.created_by }}</td>
                                <td>
                                    <router-link
                                        :to="'/customer/edit/' + CustomerList.id"
                                        class="btn btn-info mr-1"
                                    >edit</router-link>
                                    <button
                                        @click="deleteCustomer(CustomerList.id)"
                                        class="btn btn-danger"
                                    >delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

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
import { reactive, computed, toRefs } from "vue";
import Moment from "moment";
import Sidebar from "../../Layouts/Admin/Sidebar";
import Navbar from "../../Layouts/Admin/Navbar";
export default {
    components: {
        Moment,
        Sidebar,
        Navbar,
    },
    data() {
        return {
            activeHover: "none",
            user: "",
            message: "",
        };
    },
    methods: {
        reInitialize() {
            this.loadCustomers();
        },
        logOut() {
            this.$store.dispatch("auth/logout");
            this.$router.push("/login");
        },
        toggleUserDrop() {
            if (this.activeHover == "none") {
                this.activeHover = "block";
            } else {
                this.activeHover = "none";
            }
        },
        loadCustomers() {
            this.$store.dispatch("user/getAllCustomers").then(
                (response) => {
                },
                (error) => {
                    if (error.response.status == 401) {
                        this.$router.push("/customer/login");
                    }
                    this.message =
                        (error.response &&
                            error.response.data &&
                            error.response.data.message) ||
                        error.message ||
                        error.toString();
                }
            );
        },
        deleteCustomer(id) {
            if (confirm("Do you really want to delete?")) {
                this.$store.dispatch("user/deleteCustomer", id).then(
                    (response) => {
                        this.loadCustomers();
                    },
                    (error) => {
                        this.message =
                            (error.response &&
                                error.response.data &&
                                error.response.data.message) ||
                            error.message ||
                            error.toString();
                    }
                );
            }
        }
    },
    mounted() {
    },
    created() {
        this.loadCustomers();
    },
    computed: {
        currentUser() {
            return this.$store.state.auth.initialState.user.user;
        },
        toastMessage() {
            return this.$store.state.user.toastMessage;
        },
        CustomerList() {
            return this.$store.state.user.CustomerList;
        },
    },
    filters: {},
    watch: {
        toastMessage(val) {
            if (val) {
                this.$toast.show(val, {
                    type: this.$store.state.user.toastType,
                    position: "top-right",
                });
                setTimeout(this.$toast.clear, 30000);
            }
        },
    },
};
</script>
