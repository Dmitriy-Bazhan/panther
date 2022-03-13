import template from './wrapper.html';
import Header from "../layouts/Header";
import Footer from "../layouts/Footer";
import LeftPanel from "../layouts/LeftPanel";

export default {
    name: 'app',
    props: ['user', 'data'],
    data() {
        return {
            showHeader : true,
            showFooter : true,
            showLeftPanel : true,
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

        this.emitter.on('not-show-left-panel', e => {
            this.showLeftPanel = false;
        });

        if(this.user === false) {
            this.showLeftPanel = false;
        }
    }
}
