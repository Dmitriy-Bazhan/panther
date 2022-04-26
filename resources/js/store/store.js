import { createStore } from 'vuex'

export default createStore({
    state () {
        return {
            user: false
        }
    },
    mutations: {
        initStore(state, user){
            state.user = user
        }
    }
})
