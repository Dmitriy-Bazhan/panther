<template>
    <div class="pt-section-default">
        <div class="pt-tabs">
            <button v-on:click="activeTab = 1" class="pt-tabs--btn" :class="{active: activeTab === 1}">
                {{$t('i_am_client')}}
            </button>
            <button v-on:click="activeTab = 2" class="pt-tabs--btn" :class="{active: activeTab === 2}">
                {{$t('i_am_nurse')}}
            </button>
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
