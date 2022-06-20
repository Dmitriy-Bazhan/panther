<template>
    <div class="file_modal_wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10">

                </div>
                <div class="col-2">
                    <button class="btn btn-success btn-sm" v-on:click="closeFileModal()">Close</button>
                </div>
            </div>
            <div class="row">
                <div class="col-10 offset-1">
<!--                    <iframe v-bind:src="path + '/storage/' + userFile.file_path"-->
<!--                            type="application/pdf" class="file_modal_iframe"></iframe>-->
                    <embed v-bind:src="path + '/storage/' + userFile.file_path"
                           type="application/pdf" class="file_modal_iframe">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FileModal",
        props: ['userFile'],
        data(){
            return {
                path: location.origin,
            }
        },
        mounted() {

        },
        methods: {
            closeFileModal(){
                this.emitter.emit('close-file-modal');
            }
        }
    }
</script>

<style scoped>
    .file_modal_wrapper {
        position: fixed;
        z-index: 100;
        top: 10%;
        left: 20%;
        width: 60%;
        height: 600px;
        max-height: 600px;
        overflow: auto;
        background: white;
        border: solid 1px green;
        border-radius: 15px;
        padding: 15px;
    }

    .file_modal_iframe {
        width: 100%;
        height: 500px;
        max-height: 500px;
    }
</style>
