import template from './wrapper.html';
import Header from "../layouts/Header";
import Footer from "../layouts/Footer";
import ResponseSuccessTrue from "../components/ResponseSuccessTrue";

export default {
    name: 'app',
    props: ['user', 'data'],
    data() {
        return {
            showHeader: true,
            showFooter: true,
            response_success_true: false,
        }
    },
    template: template,
    components: {
        'panther-header': Header,
        'panther-footer': Footer,
        'response-success-true': ResponseSuccessTrue,
    },
    mounted() {
        this.emitter.on('response-success-true', e => {
            this.response_success_true = true;
            setTimeout(() => {
                this.response_success_true = false;
            }, 2000);
        });

        this.emitter.on('not-show-layouts', e => {
            this.showHeader = false;
            this.showFooter = false;
        });

    }
}
