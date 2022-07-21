import template from './template.html';
import './style.css';

export default {
    name: "MyInformation",
    template : template,
    props: ['user', 'data'],
    data() {
        return {
            path: location.origin,
            errors: null,
            file: '',
        }
    },
    mounted() {
        console.log(this.user);
    },
    methods : {
        updateInformation() {
            this.file = this.$refs.file.files[0];
            let formData = new FormData();

            formData.append('file', this.file);

            let user = JSON.stringify(this.user);
            formData.append('user', user);
            axios.post('/dashboard/client-my-information/' + this.user.id,
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
