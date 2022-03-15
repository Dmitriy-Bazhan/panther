import template from './template.html';
import Chat from './Chat';

export default {
    name: "Messages",
    template: template,
    props: ['user', 'data'],
    components : {
        'chat' : Chat
    }
}
