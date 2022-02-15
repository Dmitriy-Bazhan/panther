<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 offset-4">

                <div class="col-12">

                    <button v-on:click="toClientRegister">Client</button>

                </div>

                <div class="col-12">

                    <button v-on:click="toNurseRegister">Nurse</button>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "StartRegister",
    methods : {
        toClientRegister(){
            location.href = '/client-register';
        },
        toNurseRegister(){
            location.href = '/nurse-register';
        }
    }
}
</script>

<style scoped>

</style>
