import template from './template.html';
import './style.css';

export default {
    name: 'Clients',
    template: template,
    props: ['user', 'data'],
    data() {
        return {
            path: location.origin,
            clients: [],
            links: [],
            url: 'get-clients',
        }
    },
    mounted() {
        this.getClients();
    },
    methods: {
        getClients() {
            axios.get(this.url)
                .then((response) => {
                    this.clients = response.data.clients.data;
                    this.links = response.data.clients.links;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        newPage(url){
            if (url !== null) {
                this.url = url;
                this.getClients();
            }
        }
    }
}
