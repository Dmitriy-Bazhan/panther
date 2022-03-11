import template from './wrapper.html';
import Header from "../../layouts/app/Header";
import Footer from "../../layouts/app/Footer";
import LeftPanel from "../../layouts/app/LeftPanel";

export default {
    name: 'app',
    props: ['user'],
    data() {
        return {
            showHeader : true,
            showFooter : true,
        }
    },
    template: template,
    components : {
        'panther-header' : Header,
        'panther-footer' : Footer,
        'left-panel' : LeftPanel,
    },
    mounted() {
        this.emitter.on('not-show-layouts', e => {
            this.showHeader = false;
            this.showFooter = false;
        });
    }
}
