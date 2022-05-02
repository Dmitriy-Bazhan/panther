<template>
    <div class="pt-section-default">
        <div class="pt-tabs">
            <button v-on:click="activeTav = 1" class="pt-tabs--btn" :class="{active: activeTav === 1}">
                {{$t('i_am_client')}}
            </button>
            <button v-on:click="activeTav = 2" class="pt-tabs--btn" :class="{active: activeTav === 2}">
                {{$t('i_am_nurse')}}
            </button>
        </div>

        <client_register v-if="activeTav === 1" :data="data"></client_register>
        <nurse_register v-if="activeTav === 2" :data="data"></nurse_register>
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
                activeTav: 1,
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
