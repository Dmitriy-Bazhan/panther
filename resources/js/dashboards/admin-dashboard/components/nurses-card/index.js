import template from "./template.html";
import './style.css';

export default {
    name: "NursesCard",
    template: template,
    components: {
        'file_modal': FileModal,
    },
    props: ['nurse', 'data'],
    data() {
        return {
            path: location.origin,
            showFilesWindow: false,
            showFileModal: false,
            show_modal: false,
            showWorkTimePrefWindow: false,
            languages: [
                {
                    title: 'english',
                    val: 'English'
                },
                {
                    title: 'german',
                    val: 'Deutsche'
                }
            ]
        }
    },
    watch: {
        showWorkTimePrefWindow(showWorkTimePrefWindow) {
            if (showWorkTimePrefWindow) {
                document.addEventListener('click', this.closeInfoWindows);
            }
        },
        showFilesWindow(showFilesWindow) {
            if (showFilesWindow) {
                document.addEventListener('click', this.closeFileList);
            }
        },
        nurse: {
            handler(newValue, oldValue) {
                if (typeof this.nurse.entity.work_time_pref === "string") {
                    // this.nurse.entity.work_time_pref = JSON.parse(this.nurse.entity.work_time_pref);
                }
            },
            immediate: true
        },
    },
    mounted() {
        this.emitter.on('close-file-modal', (e) => {
            this.showFileModal = false;
        });
    },
    methods: {
        closeNurseCard() {
            this.emitter.emit('close-modal');
        },
        closeModal(){
            this.show_modal = false;
        },
        updateNurse() {
            axios.post('/dashboard/admin/update-nurse/' + this.nurse.id, {'user': this.nurse})
                .then((response) => {
                    if (response.data.success) {
                        this.emitter.emit('response-success-true');
                        this.emitter.emit('close-modal');
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        approveNurse() {
            axios.post('approve-nurse', {'id': this.nurse.entity.id})
                .then((response) => {
                    this.nurse.entity.is_approved = 'yes';
                    this.nurse.entity.change_info = 'no';
                    this.emitter.emit('close-nurse-card');
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        addLanguage() {
            if(this.nurse.entity.languages.length < this.languages.length){
                this.nurse.entity.languages.push({
                    lang: '',
                    level: '',
                })
            }
        },
        removeLang(index){
            if(this.nurse.entity.languages.length > 1){
                this.nurse.entity.languages.splice(index,1);
            }
        },
        showHideFilesWindow() {
            this.showFilesWindow === true ? this.showFilesWindow = false : this.showFilesWindow = true;
            this.showWorkTimePrefWindow = false;
        },
        showHideWorkTimePrefWindow() {
            this.show_modal = 'work_time_pref';
        },
        filterAdditionalInfo(id) {
            let info = this.data.additional_info.filter(function (value) {
                if (value.id === id) {
                    return value.data.data;
                }
            });
            return info[0].data.data;
        },
        filterProvideSupports(id) {
            let info = this.data.provider_supports.filter(function (value) {
                if (value.id === id) {
                    return value.name;
                }
            });
            return info[0].name;
        },
        filterFiles(data, type) {
            return data.filter(function (el) {
                if (el.file_type === type) {
                    return true;
                }
            })
        },

        closeInfoWindows(event) {
            if (!document.getElementById('provider_supports_arrow').contains(event.target)
                && !document.getElementById('additional_info_arrow').contains(event.target)
                && !document.getElementById('work_time_arrow_arrow').contains(event.target)
                && !document.getElementById('files_arrow').contains(event.target)) {
                this.showAdditionalInfo = false;
                this.showProviderSupports = false;
                this.showWorkTimePrefWindow = false;
                document.removeEventListener('click', this.closeInfoWindows);
            }

        },
        closeFileList(event) {
            if (!document.getElementById('files_arrow').contains(event.target)) {
                this.showFilesWindow = false;
                document.removeEventListener('click', this.closeFileList);
            }
        },
        translateOptions(options) {
            let self = this
            options.forEach(function (item) {
                item.title = self.$t(item.name)
            })
            return options
        },
    }
}
