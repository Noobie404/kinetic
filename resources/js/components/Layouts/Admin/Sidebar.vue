<template>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link text-center">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <router-link to="/" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Users</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/customer" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Customers</p>
                    </router-link>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>

</template>
<script>
export default {
    name: 'app',
    components: {
    },
    data() {
    },
    mounted() {
    },
    methods: {
    },

    created() {
    },
    computed: {
    },
}
</script>
