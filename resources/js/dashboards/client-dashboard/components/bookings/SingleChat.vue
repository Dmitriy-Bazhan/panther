<template>
  <div>
    <div class="pt-chat">
      <template v-if="comments.length > 0" v-for="comment in comments">
        <div class="pt-chat--message pt-chat--message__inner">
          <div class="pt-chat--message-block">
            <div class="pt-chat--message-date">
              {{ formatDate(comment.created_at) }}
            </div>
            <div class="pt-chat--message-body">
              {{ comment.message }}
            </div>
          </div>
        </div>
      </template>
    </div>



    <form action="" @submit.prevent="sendPrivateMessage()" class="pt-chat--ctrl">
      <div class="pt-chat--ctrl-input">
        <input type="text" v-model="privateMessage">
        <button class="pt-btn">
          {{ $t('send') }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "SingleChat",
  props: ['nurse', 'data', 'client'],
  data() {
    return {
      privateMessage: '',
      comments: [],
      path: location.origin,
      filePreview: '',
      commentsClone: [],
    }
  },
  mounted() {
    this.getPrivateChats();

    try {
      window.Echo.private('client-between-nurse.' + this.nurse.id + '.' + this.client.id)
          .listen('PrivateChat.ClientNurseSentMessage', (response) => {
            let message = {
              'user_name': response.result.user_name,
              'message': response.result.message,
              'client_sent': response.result.client_sent,
              'nurse_sent': response.result.client_sent,
              'created_at': response.result.created_at,
            };
            this.comments.unshift(message);
          }).error((error) => {
        console.log('ERROR IN SOCKETS CONNTECT : ' + error);
      });
    } catch (e) {
      console.log('Websockets not work');
    }
  },
  methods: {
    getPrivateChats() {
      axios.get('bookings/get-private-chats/' + this.nurse.id)
          .then((response) => {
            console.log(response);
            if (response.data.chat.length > 0) {
              for (let value in response.data.chat) {
                let message = {
                  'user_name': response.data.chat[value].user_name,
                  'message': response.data.chat[value].message,
                  'client_sent': response.data.chat[value].client_sent,
                  'nurse_sent': response.data.chat[value].client_sent,
                  'created_at': response.data.chat[value].created_at,
                };
                this.comments.unshift(message);
              }
            }
          })
          .catch((error) => {
            console.log(error);
          });
    },
    sendPrivateMessage() {
      axios.post('/dashboard/client-private-chats', {
        'client_id': this.client.id,
        'nurse_id': this.nurse.id,
        'privateMessage': this.privateMessage
      }).then((response) => {
        if (response.data.success) {
          this.privateMessage = '';
        }

      }).catch((error) => {
        console.log(error);
      });
    },
    formatDate(date) {
      let a = String(date).split('T');
      return a[0] + ' ' + String(a[1].split('.')[0]);
    },
  }
}
</script>

<style scoped>
  .pt-chat--message-body{
    background-color: #ffffff;
  }
</style>
