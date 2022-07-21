<template>
    <div class="nurse-file-wrapper">

        <div class="container-fluid">

            <div class="row">

                <div class="col-2">

                    <h5>Nurse files</h5>

                </div>

                <div class="col-1 offset-9">

                    <button class="btn btn-danger btn-sm" v-on:click="closeNurseFiles()">Close</button>

                </div>

            </div>

        </div>



        <div class="container-fluid">
            <div class="row">
                <!--                    Files-->
                <p>Files <span style="cursor: pointer;"
                               id="files_arrow"
                               v-on:click="showHideFilesWindow()">&#8964;</span></p>
                <div v-if="showFilesWindow" class="showFilesWindow" id="files_wrapper">
                    <div>
                        criminal record
                        <p class="nurse_file_name"
                           v-for="item in filterFiles(nurse.entity.files, 'criminal_record')"
                           v-on:click="showContent(item)">
                            {{ item.original_name }}
                        </p>
                        <br>
                    </div>

                    <div>
                        documentation of training
                        <p class="nurse_file_name"
                           v-for="item in filterFiles(nurse.entity.files, 'documentation_of_training')"
                           v-on:click="showContent(item)">
                            {{ item.original_name }}</p>
                    </div>

                    <div>
                        CPR course
                        <p class="nurse_file_name" v-for="item in filterFiles(nurse.entity.files, 'CPR_course')"
                           v-on:click="showContent(item)">
                            {{ item.original_name }}</p>
                    </div>

                    <div>
                        references
                        <p class="nurse_file_name" v-for="item in filterFiles(nurse.entity.files, 'references')"
                           v-on:click="showContent(item)">
                            {{ item.original_name }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import FileModal from "./FileModal";

    export default {
        name: "CheckFiles",
        props: ['nurse', 'data'],
        components: {
            'file_modal': FileModal,
        },
        data() {
            return {
                path: location.origin,
                userFile: '',
            }
        },
        mounted() {
            console.log(this.nurse.entity.files);

        },
        methods: {
            closeNurseFiles() {
                this.emitter.emit('close-modal');
            },
            showContent(item) {
                this.userFile = item;
                this.showFileModal = true;
                document.removeEventListener('click', this.closeFileList);
            },
        }
    }
</script>

<style scoped>
    .nurse-file-wrapper {
        position: fixed;
        top: 2%;
        left: 10%;
        width: 80%;
        border: solid 1px red;
        border-radius: 20px;
        background: #b3b3b3;
        z-index: 100;
        padding: 10px;
        height: 650px;
        overflow: auto;
    }

</style>
