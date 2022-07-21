<template>
    <div class="pt-header">
        <div class="wrapper">
            <div class="pt-header--container">
                <a href="/" class="pt-header--logo">
                    <img :src="path + '/images/logo.png'" alt="logo">
                </a>

                <div class="pt-header--block">
                    <div class="pt-header--ctrl">
                        <localization-component></localization-component>

                        <div class="pt-header--social">
                            <a href="" class="pt-header--social-text">
                                info@pflegepanther.com
                            </a>
                            <a href="" class="pt-header--social-link">
                                <pt-icon type="facebook"></pt-icon>
                            </a>
                            <a href="" class="pt-header--social-link">
                                <pt-icon type="twitter"></pt-icon>
                            </a>
                            <a href="" class="pt-header--social-link">
                                <pt-icon type="instagram"></pt-icon>
                            </a>
                        </div>
                    </div>
                    <div class="pt-header--nav">
                        <div class="pt-header--nav-item">
                            <pt-icon type="list"></pt-icon>
                            Pflegerkraft
                        </div>
                        <div class="pt-header--nav-item">
                            <pt-icon type="breifcase"></pt-icon>
                            Über Uns
                        </div>
                        <div class="pt-header--nav-item">
                            <pt-icon type="help"></pt-icon>
                            FAQ
                        </div>

                        <div class="pt-header--nav-item" v-if="!auth">
                            <pt-icon type="user"></pt-icon>
                            {{ $t('my_account') }}
                        </div>
                        <div class="pt-header--nav-item" v-else-if="auth.email_verified_at === null"
                             v-on:click="waitVerification()">
                            <pt-icon type="user"></pt-icon>
                            {{ $t('my_account') }}
                        </div>
                        <div class="pt-header--nav-item" v-else v-on:click="toDashboard()">
                            <pt-icon type="user"></pt-icon>
                            {{ $t('my_account') }}
                        </div>

                        <div class="pt-header--nav-item">
                            <pt-icon type="log_in"></pt-icon>
                            <span v-if="!auth" v-on:click="toLogin()">
                                {{ $t('sign_in') }}</span>
                            <logout-component v-else></logout-component>
                        </div>
                    </div>
                </div>
                <div class="pt-header--finder">
                    <span class="pt-header--finder-link" v-if="auth.email_verified_at === null"
                          v-on:click="waitVerification()">
                        <pt-icon type="nurse"></pt-icon>
                        {{ $t('caregiver_finder') }}
                    </span>

                    <router-link v-else-if="auth.entity_type ==='client'"
                                 :to="{ name : 'Finder' }"
                                 class="pt-header--finder-link">
                        <pt-icon type="nurse"></pt-icon>
                        {{ $t('caregiver_finder') }}
                    </router-link>

                    <span class="pt-header--finder-link" v-else>
                        <pt-icon type="nurse"></pt-icon>
                        {{ $t('caregiver_finder') }}
                    </span>
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
        //console.log(this.auth);
    },
    methods: {
        toLogin() {
            window.location.href = '/login';
        },
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

</style>
