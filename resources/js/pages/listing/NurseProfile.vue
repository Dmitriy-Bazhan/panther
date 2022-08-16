<template>
    <div class="pt-profile pt-mb-50 pt-mt-50" v-if="nurse">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>profile</span>
            </p>
            <h2 class="pt-title">
                LISTING
            </h2>

            <div class="pt-row pt-mt-50 pt-mb-20">
                <div class="pt-col-md-6">
                    <div class="pt-profile--head">
                        <div class="pt-profile--head-avatar">
                            <img v-bind:src="path + '/storage/' + nurse.entity.original_photo" alt="no-photo"
                                 @error="$event.target.src=path + '/images/no-photo.jpg'">
                        </div>
                        <div class="pt-profile--head-info">
                            <div class="pt-profile--head-top">
                                <div class="pt-profile--head-top--left">
                                    <pt-rate :rate="nurse.rate.round"></pt-rate>
                                    <div class="pt-profile--name">
                                        {{ nurse.first_name }}
                                        <div>{{ nurse.last_name }}</div>
                                        .
                                    </div>
                                    <div class="pt-profile--age">
                                        {{ nurse.entity.age }} Jahre Alt
                                    </div>
                                </div>
                                <div class="pt-profile--head-top--right">
                                    <div class="pt-profile--price">
                                        €{{ nurse.entity.price.hourly_payment }}/stunde
                                    </div>
                                    <div class="pt-profile--special">
                                        etwas Besuche
                                        pro Woche
                                    </div>
                                </div>
                            </div>
                            <div class="pt-profile--head-bottom">
                                <button class="pt-btn pt-sm" @click="sendToBookings">
                                    {{ $t('send_to_bookings') }}
                                </button>
                                <button class="pt-btn--border pt-sm" @click="openPopup('show_chat')">
                                    chat
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="pt-profile--list">
                        <div class="pt-profile--list-item">
                            <pt-icon type="pin"></pt-icon>
                            <div class="">
                                <div class="pt-profile--list-item-title">
                                    Ort:
                                </div>
                                <div class="pt-profile--list-item-text">
                                    <strong>12345 Berlin</strong>
                                </div>
                            </div>
                        </div>
                        <div class="pt-profile--list-item">
                            <pt-icon type="bar"></pt-icon>
                            <div class="">
                                <div class="pt-profile--list-item-title">
                                    Pflegegrad:
                                </div>
                                <div class="pt-profile--list-item-text">
                                    <strong>{{ nurse.entity.available_care_range }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="pt-profile--list-item">
                            <pt-icon type="users"></pt-icon>
                            <div class="">
                                <div class="pt-profile--list-item-title">
                                    Geschlechtspräferenz:
                                </div>
                                <div class="pt-profile--list-item-text">
                                    <strong>{{ nurse.entity.pref_client_gender }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="pt-profile--list-item">
                            <pt-icon type="globe"></pt-icon>
                            <div class="">
                                <div class="pt-profile--list-item-title">
                                    Sprachen:
                                </div>
                                <div class="pt-profile--list-item-text" v-for="lang in nurse.entity.languages">
                                    <strong>{{ lang.lang }}</strong> - {{ lang.level }}
                                </div>
                            </div>
                        </div>
                        <div class="pt-profile--list-item">
                            <pt-icon type="heart"></pt-icon>
                            <div class="">
                                <div class="pt-profile--list-item-title">
                                    Hilfe:
                                </div>
                                <div class="pt-profile--list-item-text" v-for="item in nurse.entity.provide_supports">
                                    <strong>{{ item.name }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="pt-profile--list-item">
                            <pt-icon type="paper"></pt-icon>
                            <div class="">
                                <div class="pt-profile--list-item-title">
                                    Berufserfahrung mit:
                                </div>
                                <div class="pt-profile--list-item-text" v-for="item in nurse.entity.additional_info">
                                    <strong>{{ item.alias }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-col-md-6">
                    <img :src="path + '/images/fake/fake-calendar.png'" alt="">
                </div>
            </div>

            <div class="pt-profile--additional">
                <h3 class="pt-profile--additional-title">
                    Über Mich
                </h3>
                <p>
                    {{ nurse.hear_about_us }}
                    This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean
                    sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
                    Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec
                    tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.
                    Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris
                    in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed
                    ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat,
                    velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.
                </p>
            </div>

            <div class="pt-profile--additional">
                <h3 class="pt-profile--additional-title">
                    Zertifikate
                </h3>
                <div class="pt-profile--file" v-for="(item, index) in nurse.entity.files">
                    <div class="pt-profile--file-number">
                        {{ index + 1 }}
                    </div>
                    <img :src="path + '/storage/' + item.file_path" alt="pic" class="pt-profile--file-preview">
                    <div class="pt-profile--file-inner">
                        <div class="pt-profile--file-title">
                            {{item.title}}
                            <span>{{item.date}}</span>
                        </div>
                        <button class="pt-btn--light pt-lg" @click="openPopup('gallery',path + '/' + item.file_path)">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                            Uhrenzertifikat
                        </button>
                    </div>
                </div>
            </div>

            <div class="pt-profile--additional">
                <h3 class="pt-profile--additional-title">
                    Bewertungen
                    <pt-rate :rate="nurse.rate.round"></pt-rate>
                </h3>

                <div class="pt-testimonials">
                    <div class="pt-testimonial" v-for="feedback in feedbacks">
                        <div class="pt-testimonial--avatar">
                            <img :src="feedback.creator.entity.thumbnail_photo" alt="pic" v-if="feedback.creator.entity.thumbnail_photo">
                        </div>
                        <div class="pt-testimonial--container">
                            <div class="pt-testimonial--info">
                                <div class="pt-testimonial--name">
                                    {{feedback.creator.first_name}}
                                    <div>
                                        {{feedback.creator.last_name}}
                                    </div>
                                    <pt-rate :rate="feedback.rate"></pt-rate>
                                </div>
                                <div class="pt-testimonial--date">
                                    {{serializeDate(feedback.created_at)}}
                                </div>
                            </div>
                            <div class="pt-testimonial--text">
                                <pt-icon type="quotes"></pt-icon>
                                <p>
                                    {{feedback.description}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-pagination">
                    <a href="" class="pt-pagination--link"
                       v-for="(link, index) in pagination"
                       @click.prevent="getFeedback(link)"
                       :class="{active: link.active}"
                    >
                        <i class="fa-solid fa-angle-left" v-if="index === 0"></i>
                        <i class="fa-solid fa-angle-right" v-else-if="index === pagination.length-1"></i>
                        <template v-else>{{ link.label }}</template>
                    </a>
                </div>
            </div>

            <div class="row" v-show="false">
                <div class="col-7">
                    <div>

                        <div class="nurse-profile-item">{{ $t('gender') }}: {{ nurse.entity.gender }}</div>
                        <div class="nurse-profile-item">{{ $t('experience') }}: {{ nurse.entity.experience }}</div>
                        <div class="nurse-profile-item">{{ $t('distance') }}: distance</div>

                        <div class="nurse-profile-item">{{ $t('provide_supports') }}:</div>
                        <div class="nurse-profile-item" v-for="support in nurse.entity.provide_supports">
                            . {{ $t(support.name) }}
                        </div>

                        <div class="nurse-profile-item">{{ $t('additional_info') }} :</div>
                        <div class="nurse-profile-item" v-for="additional_info in nurse.entity.additional_info">
                            . {{ filterAdditionalInfo(additional_info.id) }}
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        {{ $t('chat') }}:
                    </div>
                    <div class="col-10 chat-wrapper" v-if="comments.length > 0">
                        <div v-for="comment in comments">
                            <div v-if="comment.client_sent === 'yes'" class="chat-client-message-wrapper">
                        <span class="chat-client-name">
                            {{ comment.user_name }}
                        </span>
                                <br>
                                <span class="chat-client-message">
                            {{ comment.message }}
                        </span>
                                <br>
                                <span class="chat-client-date">
                            {{ formatDate(comment.created_at) }}
                        </span>
                            </div>

                            <div v-else class="nurse-client-message-wrapper">
                        <span class="nurse-client-name">
                            {{ comment.user_name }}
                        </span>
                                <br>
                                <span class="nurse-client-message">
                            {{ comment.message }}
                        </span>
                                <br>
                                <span class="nurse-client-date">
                            {{ formatDate(comment.created_at) }}
                        </span>

                            </div>
                        </div>
                    </div>

                </div>
                <br>
                <div class="row">
                    <div class="col-2">
                        {{ $t('message') }}:
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" v-model="privateMessage">
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success btn-sm" v-on:click="sendPrivateMessage()">{{ $t('send') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--        show_chat-->
    <Modal
        v-model="modal.show_chat"
        :close="closePopup"
    >
        <div class="pt-popup">
            <button class="pt-popup--close" @click.prevent="closePopup">
                <pt-icon type="cross"></pt-icon>
            </button>
            <div class="pt-popup--inner">
                <h3 class="pt-title pt-mb-15">
                    Chat
                </h3>


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
        </div>
    </Modal>

    <Modal
        v-model="modal.gallery"
        :close="closePopup"
    >
        <div class="pt-popup--gallery">
            <img :src="modal.src" alt="">
        </div>
    </Modal>
</template>

<script>
import SingleChat from "../../dashboards/nurse-dashboard/components/bookings/SingleChat";

export default {
    name: "NurseProfile",
    props: ['data', 'user'],
    components: {
        single_chat: SingleChat,
    },
    data() {
        return {
            modal: {
                show_chat: false,
                gallery: false,
                src: false
            },
            nurse: false,
            user: false,
            path: location.origin,
            privateMessage: '',
            comments: [],
            feedbacks: [],
            pagination: false,
        }
    },
    mounted() {
        let self = this
        self.user = self.$store.state.user

        self.getFeedback()

        axios.get('/get-nurse-profile/' + self.$route.params.id)
            .then((response) => {
                if (response.data.success) {
                    self.nurse = response.data.nurse
                    console.log(response.data.nurse)
                    self.getPrivateChats();

                    try {
                        window.Echo.private('client-between-nurse.' + self.nurse.id + '.' + self.user.id)
                            .listen('PrivateChat.ClientNurseSentMessage', (response) => {
                                let message = {
                                    'user_name': response.result.user_name,
                                    'message': response.result.message,
                                    'client_sent': response.result.client_sent,
                                    'nurse_sent': response.result.client_sent,
                                    'created_at': response.result.created_at,
                                };
                                self.comments.unshift(message);
                            }).error((error) => {
                            console.log('ERROR IN SOCKETS CONNTECT : ' + error);
                        });
                    } catch (e) {
                        console.log('Websockets not work');
                    }
                }
            })
            .catch((error) => {
                console.log(error);
            });
    },
    methods: {
        getFeedback(link) {
            let self = this
            let url = link&&link.url?link.url:'/feedback/' + self.$route.params.id
            axios.get(url)
                .then((response) => {
                    if(response.data.success){
                        self.feedbacks = response.data.feedbacks.data
                        self.pagination = response.data.feedbacks.meta.links
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        serializeDate(date) {
            let publicDate = new Date(date)
            let result = ''
            result += (publicDate.getDate()<10?'0'+publicDate.getDate(): publicDate.getDate())+'.';
            result += (publicDate.getMonth() + 1<10?'0'+(publicDate.getMonth()+1):(publicDate.getMonth() + 1))+'.';
            result += publicDate.getFullYear();
            return result;
        },
        closePopup() {
            let self = this;

            _.forEach(self.modal, function (item, key) {
                self.modal[key] = false;
            });
        },
        openPopup(id, src) {
            this.modal[id] = true
            this.src = src;
        },
        sendToBookings() {
            window.open('/booking/' + this.nurse.id);
        },
        getPrivateChats() {
            axios.get('/finder/get-private-chats/' + this.nurse.id)
                .then((response) => {
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
            axios.post('/finder/send-private-message', {
                'nurse_id': this.nurse.id,
                'privateMessage': this.privateMessage
            }).then((response) => {
                this.privateMessage = '';
            }).catch((error) => {
                console.log(error);
            });
        },
        filterAdditionalInfo(id) {
            let info = this.data.additional_info.filter(function (el) {
                if (el.id === id) {
                    return true;
                }
            });

            return info[0].data.data;
        },
        closeModalNurseProfile() {
            this.emitter.emit('close-modal-nurse-profile');
        },
        formatDate(date) {
            let a = String(date).split('T');
            return a[0] + ' ' + String(a[1].split('.')[0]);
        },
    },
}
</script>

<style scoped>
.pt-chat--message-body{
    background-color: #ffffff;
}
</style>
