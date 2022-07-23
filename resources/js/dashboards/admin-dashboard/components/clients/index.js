import template from './template.html';
import './style.css';
import ShowChats from "./ShowChats";
import AddNewClient from "./AddNewClient";

export default {
    name: 'Clients',
    template: template,
    props: ['user', 'data'],
    components: {
        show_chats: ShowChats,
        add_new_client: AddNewClient,
    },
    data() {
        return {
            path: location.origin,
            clients: [],
            links: [],
            url: 'get-clients?page=',
            show_modal: false,
            client: false,
            search: '',
        }
    },
    mounted() {
        this.getClients();

        this.emitter.on('close-modal', (e) => {
            this.closeModal();
        });
    },
    methods: {
        searchClient() {
            this.url = 'get-clients?page=';
            this.getClients();
        },
        getClients() {
            console.log(this.url + '&search=' + this.search);
            axios.get(this.url + '&search=' + this.search)
                .then((response) => {
                    this.clients = response.data.clients.data;
                    this.links = response.data.clients.meta.links;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        addNewClient() {
            this.show_modal = 'add_new_client';
            this.nurse = null;
        },
        showChats(client) {
           this.show_modal = 'show_chats';
           this.client = client;
        },
        newPage(url){
            if (url !== null) {
                this.url = url;
                this.getClients();
            }
        },
        closeModal() {
            this.show_modal = false;
            this.client = false;
        },
    }
}
