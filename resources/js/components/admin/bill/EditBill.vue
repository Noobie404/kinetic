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
                            <h1 class="m-0">Edit bill</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="#">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Edit bill</li>
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
                            <div class="card-header">Fillup bill information</div>
                            <div class="card-body" v-if="BillInfo.bills">
                                <Form @submit="submitBill" :validation-schema="schema">
                                    <Field
                                        name="bill_id"
                                        type="hidden"
                                        class="form-control"
                                        v-model="BillInfo.bills.id"
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
                                                <label for="customer">
                                                    customer
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <Field
                                                    name="customer"
                                                    as="select"
                                                    class="form-control"
                                                    v-model="customerSelected"
                                                >
                                                    <option value>Choose customer</option>
                                                    <option
                                                        v-for="(
                              CustomerOption, index
                            ) of BillInfo.customers"
                                                        :key="index"
                                                        :value="CustomerOption.id"
                                                    >{{ CustomerOption.name }}</option>
                                                </Field>
                                                <ErrorMessage
                                                    name="customer"
                                                    class="error-feedback text-danger"
                                                />
                                                <div for="customer" class="text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <Field
                                                    name="bill_date"
                                                    id="bill_date"
                                                    type="hidden"
                                                    class="form-control"
                                                    v-model="picked"
                                                />
                                                <label for="bill_date">
                                                    Bill date
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <Datepicker
                                                    valuetype="format"
                                                    format="dd-MM-yyyy"
                                                    v-model="picked"
                                                    :class="form - control"
                                                    :clearable="true"
                                                />
                                                <ErrorMessage
                                                    name="bill_date"
                                                    class="error-feedback text-danger"
                                                />
                                                <div for="bill_date" class="text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">
                                                    Bill Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <Field
                                                    name="name"
                                                    type="text"
                                                    id="name"
                                                    class="form-control"
                                                    placeholder="Enter Name"
                                                    autocomplete="nope"
                                                    :value="BillInfo.bills.bill_name"
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
                                                <label for="status">
                                                    Status
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <Field
                                                    name="status"
                                                    as="select"
                                                    class="form-control"
                                                    v-model="statusSelected"
                                                >
                                                    <option value>Choose status</option>
                                                    <option value="1">Paid</option>
                                                    <option value="0">Due</option>
                                                </Field>
                                                <ErrorMessage
                                                    name="status"
                                                    class="error-feedback text-danger"
                                                />
                                                <div for="status" class="text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="amount">
                                                    Amount
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <Field
                                                    name="amount"
                                                    id="amount"
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control"
                                                    placeholder="Enter amount"
                                                    :value="BillInfo.bills.amount"
                                                />
                                                <ErrorMessage
                                                    name="amount"
                                                    class="error-feedback text-danger"
                                                />
                                                <div for="amount" class="text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="paid">
                                                    Paid
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <Field
                                                    name="paid"
                                                    id="paid"
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control"
                                                    placeholder="Enter paid"
                                                    :value="BillInfo.bills.paid"
                                                />
                                                <ErrorMessage
                                                    name="paid"
                                                    class="error-feedback text-danger"
                                                />
                                                <div for="paid" class="text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="due">
                                                    Due
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <Field
                                                    name="due"
                                                    id="due"
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control"
                                                    placeholder="Enter due"
                                                    :value="BillInfo.bills.due"
                                                />
                                                <ErrorMessage
                                                    name="due"
                                                    class="error-feedback text-danger"
                                                />
                                                <div for="due" class="text-danger"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-7 offset-md-5">
                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                                :disabled="loading"
                                            >
                                                <span
                                                    v-show="loading"
                                                    class="spinner-border spinner-border-sm"
                                                ></span>
                                                <span>Update</span>
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
import Datepicker from "vue3-datepicker";
import Sidebar from "../../Layouts/Admin/Sidebar";
import Navbar from "../../Layouts/Admin/Navbar";
export default {
    components: {
        Form,
        Field,
        ErrorMessage,
        Navbar,
        Sidebar,
        Datepicker,
    },
    data() {
        const schema = yup.object().shape({
            customer: yup.string().required("Please select customer"),
            bill_date: yup.date().default(() => new Date()),
            name: yup.string().required("Name is required!"),
            status: yup.string().required("Please select status"),
            amount: yup.number().required("Amount is required!"),
            paid: yup.string().required("Paid is required!"),
            due: yup.string().required("Due is required!"),
        });
        return {
            loading: false,
            message: "",
            schema,
            passwordFieldType: "password",
            activeHover: "none",
            picked: "",
            customerSelected: "",
            statusSelected: "",
        };
    },
    methods: {
        reInitialize() {
            this.loadBillInfo();
        },
        toggleUserDrop() {
            if (this.activeHover == "none") {
                this.activeHover = "block";
            } else {
                this.activeHover = "none";
            }
        },
        submitBill(bill) {
            this.loading = true;
            this.$store.dispatch("bill/billUpdate", bill).then(
                (response) => {
                    this.loading = false;
                },
                (error) => {
                    this.loading = false;
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
        loadBillInfo() {
            this.$store.dispatch("bill/loadBillInfo", this.$route.params.id).then(
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
    },
    mounted() { },
    created() {
        this.loadBillInfo();
    },
    computed: {
        BillInfo() {
            return this.$store.state.bill.BillInfo;
        },
        toastMessage() {
            return this.$store.state.bill.toastMessage;
        },
    },
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
        BillInfo(val) {
            if (val) {
                this.picked = new Date(this.BillInfo.bills.bill_date);
                this.statusSelected = this.BillInfo.bills.status;
                this.customerSelected = this.BillInfo.bills.f_customer_no;
            }
        },
    },
};
</script>
