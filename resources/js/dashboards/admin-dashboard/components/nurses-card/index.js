import template from "./template.html";
import FileModal from "./FileModal";
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
            showAdditionalInfo: false,
            showProviderSupports: false,
            showFilesWindow: false,
            showFileModal: false,
            showWorkTimePrefWindow: false,
            userFile: '',
        }
    },
    watch: {
        showAdditionalInfo(showAdditionalInfo) {
            if (showAdditionalInfo) {
                document.addEventListener('click', this.closeInfoWindows);
            }
        },
        showProviderSupports(showProviderSupports) {
            if (showProviderSupports) {
                document.addEventListener('click', this.closeInfoWindows);
            }
        },
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
                    this.nurse.entity.work_time_pref = JSON.parse(this.nurse.entity.work_time_pref);
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
            this.emitter.emit('close-nurse-card');
        },
        approveNurse(){
            axios.post('approve-nurse', {'id': this.nurse.entity.id})
                .then((response) => {
                    this.nurse.entity.is_approved = 'yes';
                    this.nurse.entity.change_info = 'no';
                    this.nurse.entity.info_is_full = 'no';
                    this.emitter.emit('close-nurse-card');
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        showHideAdditionalInfo() {
            this.showAdditionalInfo === true ? this.showAdditionalInfo = false : this.showAdditionalInfo = true;
            this.showProviderSupports = false;
            this.showFilesWindow = false;
            this.showWorkTimePrefWindow = false;
        },
        showHideProviderSupports() {
            this.showProviderSupports === true ? this.showProviderSupports = false : this.showProviderSupports = true;
            this.showAdditionalInfo = false;
            this.showFilesWindow = false;
            this.showWorkTimePrefWindow = false;
        },
        showHideFilesWindow() {
            this.showFilesWindow === true ? this.showFilesWindow = false : this.showFilesWindow = true;
            this.showProviderSupports = false;
            this.showAdditionalInfo = false;
            this.showWorkTimePrefWindow = false;
        },
        showHideWorkTimePrefWindow(){
            this.showWorkTimePrefWindow === true ? this.showWorkTimePrefWindow = false : this.showWorkTimePrefWindow = true;
            this.showProviderSupports = false;
            this.showAdditionalInfo = false;
            this.showFilesWindow = false;
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
        showContent(item) {
            this.userFile = item;
            this.showFileModal = true;
            document.removeEventListener('click', this.closeFileList);
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
        closeFileList(event){
            if (!document.getElementById('files_arrow').contains(event.target)) {
                this.showFilesWindow = false;
                document.removeEventListener('click', this.closeFileList);
            }
        }
    }
}
