<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Home</a>
            </li>
        </ul>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown" @click.prevent="toggleUserDrop">
                    <a
                        id="navbarDropdown"
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        v-if="currentUser"
                    >{{ currentUser.name }}</a>
                    <div
                        class="dropdown-menu dropdown-menu-right"
                        aria-labelledby="navbarDropdown"
                        :style="'display:' + activeHover"
                    >
                        <a
                            href="javascript:void(0)"
                            class="dropdown-item"
                            @click.prevent="logOut"
                        >Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
export default {
    name: "app",
    components: {},
    data() {
        return {
            activeHover: "none",
        };
    },
    mounted() { },
    methods: {
        toggleUserDrop() {
            if (this.activeHover == "none") {
                this.activeHover = "block";
            } else {
                this.activeHover = "none";
            }
        },
        logOut() {
            this.$store.dispatch("auth/logout");
            this.$router.push("/customer/login");
        },
    },
    created() {
        if (!this.CustomerloggedIn) {
            this.$router.push("/customer/login");
        }
    },
    computed: {
        CustomerloggedIn() {
            return this.$store.state.auth.initialState.status.CustomerloggedIn;
        },
        currentUser() {
            return this.$store.state.auth.initialState.user.user;
        },
    },
    watch: {
        CustomerloggedIn(val) {
            if (!val) {
                this.$router.push("/customer/login");
            }
        },
    },
};
</script>
