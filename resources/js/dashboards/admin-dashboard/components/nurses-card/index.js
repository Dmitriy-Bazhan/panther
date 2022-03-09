import template from "./template.html";
import './style.css';

export default {
    name: "NursesCard",
    template: template,
    props: ['nurse', 'data'],
    data() {
        return {
            path: location.origin,
            showAdditionalInfo: false,
            showProviderSupports: false,

        }
    },
    mounted() {
        console.log(this.data);
        console.log(this.nurse);
    },
    methods: {
        closeNurseCard() {
            this.emitter.emit('close-nurse-card');
        },
        showHideAdditionalInfo() {
            this.showAdditionalInfo === true ? this.showAdditionalInfo = false : this.showAdditionalInfo = true;
        },
        showHideProviderSupports() {
            this.showProviderSupports === true ? this.showProviderSupports = false : this.showProviderSupports = true;
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
        }
    }
}
