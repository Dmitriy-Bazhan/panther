import { createStore } from 'vuex'

export default createStore({
    state () {
        return {
            user: false,
            notifications: false,
            messages: false,
        }
    },
    mutations: {
        initStore(state, user){
            state.user = user
        },
        setNotifications(state, data){
            state.notifications = data
        },
        setMessages(state, data){
            state.messages = data
        }
    },
    actions: {
        messageListener (context) {
            if(context.state.user.entity_type === 'nurse'){
                try {
                    window.Echo.private('nurse-have-new-message.' + context.state.user.id)
                        .listen('PrivateChat.NurseHaveNewMessage', (response) => {
                            console.log(response.client_count_unread_message)
                            context.commit('setMessages', response.nurse_count_unread_message)

                        }).error((error) => {
                        console.log('ERROR IN SOCKETS CONNTECT : ' + error);
                    });
                } catch (e) {
                    console.log('Websockets not work');
                }
            }
            else{
                try {
                    window.Echo.private('client-have-new-message.' + context.state.user.id)
                        .listen('PrivateChat.ClientHaveNewMessage', (response) => {
                            console.log(response.client_count_unread_message)
                            context.commit('setMessages', response.client_count_unread_message)
                        }).error((error) => {
                        console.log('ERROR IN SOCKETS CONNTECT : ' + error);
                    });
                } catch (e) {
                    console.log('Websockets not work');
                }
            }
        }
    }
})
