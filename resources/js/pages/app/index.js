import template from './wrapper.html';
import Header from "../../layouts/app/Header";
import Footer from "../../layouts/app/Footer";

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
    },
    mounted() {
        console.log(this.user);

        this.emitter.on('not-show-layouts', e => {
            this.showHeader = false;
            this.showFooter = false;
        });
    }
}
