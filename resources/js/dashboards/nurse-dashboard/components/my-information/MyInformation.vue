<template>
    <div>
        <h2>{{ $t('my_information') }}2</h2>
        <p style="font-size: 12px;color: red;">
            * It is necessary to make an instruction, so that each user understands that a change in information automatically sends her for verification
        </p>

        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <button v-bind:class="[info_active ? 'btn btn-success btn-sm' : 'btn btn-secondary btn-sm']"
                            v-on:click="showInfo()">
                        Info
                    </button>
                </div>
                <div class="col-2">
                    <button v-bind:class="[calendar_active ? 'btn btn-success btn-sm' : 'btn btn-secondary btn-sm']"
                            v-on:click="showCalendar()">
                        Time calendar
                    </button>
                </div>
                <div class="col-2">
                    <button v-bind:class="[file_active ? 'btn btn-success btn-sm' : 'btn btn-secondary btn-sm']"
                            v-on:click="showFilesAndPhoto()">
                        File and photo
                    </button>
                </div>
            </div>
        </div>
        <br>

        <nurse_info v-if="info_active" :user="user" :data="data" :errors="errors"></nurse_info>

        <nurse_files_and_photo v-if="file_active" :user="user" :data="data"></nurse_files_and_photo>

        <nurse_time_calendar v-if="calendar_active" :user="user" :data="data" :errors="errors"></nurse_time_calendar>

    </div>



</template>

<script>
import NurseInfo from "./NurseInfo";
import NurseFilesAndPhoto from "./NurseFilesAndPhoto";
import NurseTimeCalendar from "./NurseTimeCalendar";

export default {
    name: "MyInformation",
    components : {
        nurse_info : NurseInfo,
        nurse_files_and_photo : NurseFilesAndPhoto,
        nurse_time_calendar : NurseTimeCalendar,
    },
    props: ['user', 'data'],
    data() {
        return {
            info_active: true,
            file_active: false,
            calendar_active: false,
            path: location.origin,
            errors: null,
        }
    },
    mounted() {
        this.emitter.on('errors', e => {
            this.errors = e;
        });

        this.emitter.on('no-errors', e => {
            this.errors = null;
        });
    },
    methods: {
        showInfo() {
            this.info_active = true;
            this.file_active = false;
            this.calendar_active = false;
        },
        showFilesAndPhoto() {
            this.info_active = false;
            this.file_active = true;
            this.calendar_active = false;
        },
        showCalendar() {
            this.calendar_active = true;
            this.info_active = false;
            this.file_active = false;
        },
    }
}

</script>

<style scoped>

</style>
