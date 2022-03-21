import template from './template.html';
import NurseInfo from "./NurseInfo";

export default {
    name: "MyInformation",
    template: template,
    components : {
      nurse_info : NurseInfo,
    },
    props: ['user', 'data'],
    data() {
        return {
            info_active: true,
            file_active: false,
            calendar_active: false,
            path: location.origin,
            errors: null,
            criminal_record: '',
            documentation_of_training: '',
            CPR_course: '',
            references: '',
            file: '',
        }
    },

    mounted() {
        console.log(this.user);
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
        filterFiles(data, type) {
            return data.filter(function (el) {
                if (el.file_type === type) {
                    return true;
                }
            })
        },


        updateInformation() {
            this.criminal_record = this.$refs.criminal_record.files;
            this.documentation_of_training = this.$refs.documentation_of_training.files;
            this.CPR_course = this.$refs.CPR_course.files;
            this.references = this.$refs.references.files;
            this.file = this.$refs.file.files[0];
            let formData = new FormData();

            formData.append('file', this.file);

            for (let i = 0; i < this.criminal_record.length; i++) {
                let file = this.criminal_record[i];
                formData.append('criminal_record[' + i + ']', file);
            }


            for (let i = 0; i < this.documentation_of_training.length; i++) {
                let file = this.documentation_of_training[i];
                formData.append('documentation_of_training[' + i + ']', file);
            }

            for (let i = 0; i < this.CPR_course.length; i++) {
                let file = this.CPR_course[i];
                formData.append('CPR_course[' + i + ']', file);
            }

            for (let i = 0; i < this.references.length; i++) {
                let file = this.references[i];
                formData.append('references[' + i + ']', file);
            }

            let user = JSON.stringify(this.user);
            formData.append('user', user);
            axios.post('/dashboard/nurse-my-information/' + this.user.id,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then((response) => {
                    if (response.data.success) {
                        this.emitter.emit('response-success-true');
                        this.errors = null;
                        this.emitter.emit('user-finished-fill-info');
                    } else {
                        this.errors = response.data.errors;
                        console.log(response.data.errors);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        photoUpload() {
            //todo:: photo preview
        },
    }
}
