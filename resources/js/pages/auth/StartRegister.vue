<template>
    <div class="pt-section-default">
        <div class="pt-tabs">
            <router-link :to="{ name : 'RegisterClient' }" class="pt-tabs--btn" :class="{active: activeTab === 1}">
                {{$t('i_am_client')}}
            </router-link>
            <router-link :to="{ name : 'RegisterNurse' }" class="pt-tabs--btn" :class="{active: activeTab === 2}">
                {{$t('i_am_nurse')}}
            </router-link>
        </div>

        <client_register v-if="activeTab === 1" :data="data"></client_register>
        <nurse_register v-if="activeTab === 2" :data="data"></nurse_register>
    </div>
</template>

<script>
    import NurseRegister from "./NurseRegister";
    import ClientRegister from "./ClientRegister";

    export default {
        name: "StartRegister",
        props: ['data'],
        components: {
            nurse_register: NurseRegister,
            client_register: ClientRegister,
        },
        data() {
            return {
                activeTab: 1,
            }
        },
        mounted() {
            if(this.$route.meta && this.$route.meta.activeTab){
                this.activeTab = this.$route.meta.activeTab
            }

            this.$router.afterEach((to, from, next) => {
                this.$router.go(to)
            })
        },
        methods: {
        }
    }
</script>

<style scoped>
    .center {
        text-align: center;
    }
</style>
