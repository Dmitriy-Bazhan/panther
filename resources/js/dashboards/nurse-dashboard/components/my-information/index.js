import template from './template.html';
import NurseInfo from "./NurseInfo";
import NurseFilesAndPhoto from "./NurseFilesAndPhoto";
import NurseTimeCalendar from "./NurseTimeCalendar";

export default {
    name: "MyInformation",
    template: template,
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
