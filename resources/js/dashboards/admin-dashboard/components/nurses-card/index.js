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
        showFilesWindow(showFilesWindow) {
            if (showFilesWindow) {
                document.addEventListener('click', this.closeFileList);
            }
        }
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
        showHideAdditionalInfo() {
            this.showAdditionalInfo === true ? this.showAdditionalInfo = false : this.showAdditionalInfo = true;
            this.showProviderSupports = false;
            this.showFilesWindow = false;
        },
        showHideProviderSupports() {
            this.showProviderSupports === true ? this.showProviderSupports = false : this.showProviderSupports = true;
            this.showAdditionalInfo = false;
            this.showFilesWindow = false
        },
        showHideFilesWindow() {
            this.showFilesWindow === true ? this.showFilesWindow = false : this.showFilesWindow = true;
            this.showProviderSupports = false;
            this.showAdditionalInfo = false;
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
                    && !document.getElementById('files_arrow').contains(event.target)) {
                    this.showAdditionalInfo = false;
                    this.showProviderSupports = false;
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
