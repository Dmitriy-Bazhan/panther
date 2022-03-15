import template from './template.html';
import Chat from './Chat';

export default {
    name: "Messages",
    template: template,
    props: ['user', 'data'],
    components: {
        'chat': Chat
    },
    data() {
        return {
            chats: false,
        }
    },
    mounted() {
        this.getPrivateChats();
    },
    methods: {
        getPrivateChats() {
            axios.get('/dashboard/nurse-private-chats')
                .then((response) => {
                    this.chats = response.data.chats;
                    console.log(this.chats);
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
