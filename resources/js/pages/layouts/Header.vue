<template>
    <div class="container-fluid">

        <div class="container-fluid">
            <div class="row">
                <div class="col-10 offset-1 header-wrapper">
                    <div class="row">
                        <div class="col-2 logo">
                            <img :src="path + '/images/logo.png'" alt="logo" class="logo-image">
                        </div>
                        <div class="col-7 offset-1">
                            <div class="row first-row">
                                <localization-component></localization-component>
                            </div>

                            <div class="row second-row">
                                <div class="menu-item">Pflegerkraft</div>
                                <div class="menu-item">About us</div>
                                <div class="menu-item">FAQ</div>
                                <div class="menu-item" v-if="!auth">My Account</div>
                                <div class="menu-item" v-else-if="auth.email_verified_at === null"
                                     v-on:click="waitVerification()">My Account
                                </div>
                                <div class="menu-item" v-else v-on:click="toDashboard">My Account</div>
                                <div class="menu-item">
                                    <a v-if="!auth" href="login">
                                        <button class="btn btn-sm btn-success">Login</button>
                                    </a>&nbsp;
                                    <logout-component v-else></logout-component>
                                </div>
                            </div>

                        </div>
                        <div class="col-2 finder">
                            <span class="finder-link" v-if="auth.email_verified_at === null"
                                  v-on:click="waitVerification()">{{ $t('caregiver_finder') }}</span>
                            <router-link v-else-if="auth.entity_type ==='client'" :to="{ name : 'Listing' }"
                                         class="finder-link">{{ $t('caregiver_finder') }}
                            </router-link>
                            <span class="finder-link" v-else
                                  >{{ $t('caregiver_finder') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Localization from "../components/Localization";
    import Logout from "../components/Logout";

    export default {
        name: "Header",
        props: ['auth'],
        components: {
            'localization-component': Localization,
            'logout-component': Logout,
        },
        data() {
            return {
                path: location.origin,
            }
        },
        mounted() {
        },
        methods: {
            waitVerification() {
                alert('Wait email verification');
            },
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
    .menu-item {
        display: flex;
        width: 20%;
    }

    .logo {
        height: 100px;
    }

    .logo-image {
        width: 90%;
        height: auto;
    }

    .finder {
        height: 100px;
        background: #0a58ca;
        align-items: center;
        justify-content: center;
        display: flex;
    }

    .finder-link {
        color: white;
        text-decoration: none;
    }

    .first-row {
        border-bottom: solid 2px #b4b4b4;
        padding: 10px;
    }

    .second-row {
        padding-top: 10px;
    }
</style>
