<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 offset-4 btn-group-vertical">

                <button v-on:click="toClientRegister" class="btn btn-lg btn-primary">Client</button>

                <br>

                <button v-on:click="toNurseRegister" class="btn btn-lg btn-primary">Nurse</button>

                <br>

                <button v-on:click="backToHome" class="btn btn-lg btn-primary">Back</button>

            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "StartRegister",
    mounted() {
    },
    methods: {
        toClientRegister() {
            location.href = '/client-register';
        },
        toNurseRegister() {
            location.href = '/nurse-register';
        },
        backToHome(){
            location.href = '/';
        }
    }
}
</script>

<style scoped>

</style>
