<template>
    <div class="container-fluid main-header">

        <div class="row header-wrapper">

            <div class="col-2 offset-8">
                <localization-component></localization-component>
            </div>

            <div v-if="!auth || auth.email_verified_at === null" class="col-2">
                <a href="login">
                    <button class="btn btn-sm btn-success">Login</button>
                </a>&nbsp;
                <a href="register">
                    <button class="btn btn-sm btn-success">Register</button>
                </a>
            </div>

            <div v-else class="col-2">
                <span>{{ auth.first_name }}</span>
                <button v-on:click="toDashboard" class="btn btn-sm btn-success">Dashboard</button>&nbsp;

                <logout-component></logout-component>

            </div>


        </div>
    </div>
</template>

<script>
import Localization from "../../pages/components/Localization";
import Logout from "../../pages/components/Logout";

export default {
    name: "Header",
    props: ['auth'],
    components : {
         'localization-component' : Localization,
         'logout-component' : Logout,
    },
    mounted() {
    },
    methods: {
        toDashboard() {
            if (window.guard === 'admin') {
                location.href = '/dashboard/admin';
            }

            if (window.guard === 'client') {
                location.href = '/dashboard/client';
            }

            if (window.guard === 'nurse') {
                location.href = '/dashboard/nurse';
            }


        }
    }
}
</script>

<style scoped>
    .main-header {
        padding: 5px;
        background: #9dc3fc;
    }
</style>
