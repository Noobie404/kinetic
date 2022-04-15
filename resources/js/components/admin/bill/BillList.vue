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
                            <h1 class="m-0">Bill List</h1>
                            <router-link to="/bill/new" class="btn btn-sm btn-primary mt-2">
                                <i class="fa fa-plus"></i> Add new bill
                            </router-link>
                            <!-- <a href="/" class="btn btn-sm btn-primary mt-2"><i class="fa fa-plus"></i>  Add new customer</a> -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="#">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Bill List</li>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Filter bills by sttus</label>
                            <select
                                name="status"
                                as="select"
                                @change="onChange"
                                class="form-control"
                            >
                                <option value>Choose status</option>
                                <option value="1">Paid</option>
                                <option value="0">Due</option>
                            </select>
                            <ErrorMessage name="status" class="error-feedback text-danger" />
                            <div for="status" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Bill Under</th>
                                <th scope="col">Status</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Paid</th>
                                <th scope="col">Due</th>
                                <th scope="col">Bill Date</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="f_billList">
                            <tr v-for="(BillList, index) in f_billList" v-bind:key="BillList.id">
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ BillList.customer_name }}</td>
                                <td>{{ BillList.status == 1 ? "Paid" : "Due" }}</td>
                                <td>{{ BillList.amount }}</td>
                                <td>{{ BillList.paid }}</td>
                                <td>{{ BillList.due }}</td>
                                <td>{{ new Date(BillList.bill_date).toLocaleDateString() }}</td>
                                <td>{{ BillList.created_by }}</td>
                                <td>
                                    <router-link
                                        :to="'/bill/edit/' + BillList.id"
                                        class="btn btn-info mr-1"
                                    >edit</router-link>
                                    <button
                                        @click="deleteBill(BillList.id)"
                                        class="btn btn-danger"
                                    >delete</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot v-else>
                            <tr>
                                <td colspan="9">No data found</td>
                            </tr>
                        </tfoot>
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
            f_billList: {},
        };
    },
    methods: {
        reInitialize() {
            this.loadBills();
        },
        loadBills() {
            this.$store.dispatch("bill/getAllBills").then(
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
        deleteBill(id) {
            if (confirm("Do you really want to delete?")) {
                this.$store.dispatch("bill/deleteBill", id).then(
                    (response) => {
                        this.loadBills();
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
        },
        onChange(event) {
            let filtered_bills = _.filter(this.BillList, function (b) {
                return b.status == event.target.value;
            });
            this.f_billList = filtered_bills;
        },
    },
    mounted() { },
    created() {
        this.loadBills();
    },
    computed: {
        toastMessage() {
            return this.$store.state.bill.toastMessage;
        },
        BillList() {
            this.f_billList = this.$store.state.bill.BillList;
            return this.$store.state.bill.BillList;
        },
    },
    filters: {},
    watch: {
        toastMessage(val) {
            if (val) {
                this.$toast.show(val, {
                    type: this.$store.state.bill.toastType,
                    position: "top-right",
                });
                setTimeout(this.$toast.clear, 30000);
            }
        },
        BillList(val) { },
    },
};
</script>
