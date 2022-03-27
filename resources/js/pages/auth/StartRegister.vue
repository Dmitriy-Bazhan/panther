<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 offset-3 center">

                <button v-on:click="toClientRegister" class="btn btn-primary">Client</button>
            </div>
            <div class="col-3 center">
                <button v-on:click="toNurseRegister" class="btn  btn-primary">Nurse</button>

            </div>
        </div>

        <div class="row">
            <div class="col-6 offset-3 center">
                <client_register v-if="showClientRegister" :data="data"></client_register>
                <nurse_register v-if="showNurseRegister" :data="data"></nurse_register>
            </div>
        </div>
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
                showNurseRegister: false,
                showClientRegister: true,
            }
        },
        mounted() {

        },
        methods: {
            toClientRegister() {
                this.showNurseRegister = false;
                this.showClientRegister = true;
            },
            toNurseRegister() {
                this.showNurseRegister = true;
                this.showClientRegister = false;
            },
        }
    }
</script>

<style scoped>
    .center {
        text-align: center;
    }
</style>
