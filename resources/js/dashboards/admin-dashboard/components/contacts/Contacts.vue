<template>
    <div>
        <div class="pt-table--head">
            <div class="pt-messages--tabs">
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === ''}"
                        @click.prevent="activateTab('')">
                    <!--                {{ $t('all') }}-->
                    All
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'no'}"
                        @click.prevent="activateTab('no')">
                    <!--                {{ $t('approved_bookings') }}-->
                    Not Answeared
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'yes'}"
                        @click.prevent="activateTab('yes')">
                    <!--                {{ $t('not_approved_bookings') }}-->
                    Answeared
                </button>
            </div>
            <pt-search class="pt-ml-a"></pt-search>
        </div>

        <div class="pt-table--container">
            <div class="pt-table" v-if="contacts.length > 0">
                <div class="pt-table--heading">
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('Name') }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('email') }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('phone') }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('Answered') }}
                        </div>
                    </div>
                </div>
                <div class="pt-table--row" v-for="(contact, index) in contacts">
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            <div class="pt-table--number">
                                {{ index + 1 }}
                            </div>
                            <div>
                                {{ contact.name }}
                            </div>
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            <pt-icon type="sum"></pt-icon>
                            {{ contact.email }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            <pt-icon type="pin"></pt-icon>
                            {{ contact.phone }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--ctrl">
                            <div class="pt-status" :class="contact.status_of_answer">
                                {{ $t(contact.status_of_answer) }}
                            </div>

                            <pt-menu>
                                <template v-for="item in ctrl[contact.status_of_answer]" :key="item">
                                        <div class="pt-table--ctrl-group" v-show="item === 'show_contact'">
                                            <button class="pt-btn"
                                                    @click.prevent="openPopup('show_contact', contact)">
                                                Show
                                            </button>
                                        </div>
                                        <div class="pt-table--ctrl-group" v-show="item === 'answer'">
                                            <button class="pt-btn"
                                                    @click.prevent="openPopup('answer_contact', contact)">
                                                Answer
                                            </button>
                                        </div>
                                        <div class="pt-table--ctrl-group" v-show="item === 'remove'">
                                            <button class="pt-btn"
                                                    @click.prevent="openPopup('show_remove_confirm', contact)">
                                                {{ $t('remove') }}
                                            </button>
                                        </div>
                                </template>
                            </pt-menu>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="" v-else>
                No contacts
            </h2>

            <div class="pt-pagination" v-if="contacts.length > 0">
                <a href="" class="pt-pagination--link"
                   v-for="(link, index) in pagination"
                   @click.prevent="getPayment(link)"
                   :class="{active: link.active}"
                >
                    <i class="fa-solid fa-angle-left" v-if="index === 0"></i>
                    <i class="fa-solid fa-angle-right" v-else-if="index === pagination.length-1"></i>
                    <template v-else>{{ link.label }}</template>
                </a>
            </div>
        </div>
    </div>

<!--    answer-->
    <Modal
        v-model="modal.answer_contact"
        :close="closePopup"
    >
        <div class="pt-popup">
            <h3 class="pt-title">
                {{ $t('answer') }}
            </h3>
            <button class="pt-popup--close" @click.prevent="closePopup">
                <pt-icon type="cross"></pt-icon>
            </button>
            <div class="pt-popup--inner">

                <answer_contact :contact="contact"></answer_contact>

            </div>
        </div>
    </Modal>

<!--    show-->
    <Modal
        v-model="modal.show_contact"
        :close="closePopup"
    >
        <div class="pt-popup">
            <h3 class="pt-title">
                {{ $t('Contacts item') }}
            </h3>
            <button class="pt-popup--close" @click.prevent="closePopup">
                <pt-icon type="cross"></pt-icon>
            </button>
            <div class="pt-popup--inner">

                <show_contact :contact="contact"></show_contact>

            </div>
        </div>
    </Modal>

<!--    remove -->
    <Modal
        v-model="modal.show_remove_confirm"
        :close="closePopup"
    >
        <div class="pt-popup">
            <button class="pt-popup--close" @click.prevent="closePopup">
                <pt-icon type="cross"></pt-icon>
            </button>
            <div class="pt-popup--inner">
                <div class="pt-row">
                    <div class="pt-col-md-6">
                        <button class="pt-btn--primary" v-on:click="removeContactConfirm()">{{ $t('remove') }}</button>
                    </div>
                    <div class="pt-col-md-6">
                        <button class="pt-btn" v-on:click="closePopup()">{{ $t('close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </Modal>

</template>

<script>
import ShowContact from "./ShowContact";
import AnswerContact from "./AnswerContact";

export default {
    name: "Contacts",
    components: {
        show_contact: ShowContact,
        answer_contact: AnswerContact,
    },
    data() {
        return {
            contacts: [],
            contact: 0,
            search: '',
            activeTab: '',
            pagination: false,
            modal: {
                show_remove_confirm: false,
                show_contact: false,
                answer_contact: false,
            },
            ctrl: {
                yes: [
                    'show_contact',
                    'answer',
                    'remove',
                ],
                no: [
                    'show_contact',
                    'answer',
                    'remove',
                ],
            }
        }
    },
    mounted() {
        this.getContacts();

        this.emitter.on('close-modal', (e) => {
            this.closePopup();
            this.getContacts();
        });
    },
    methods: {
        closePopup() {
            let self = this;

            _.forEach(self.modal, function (item, key) {
                self.modal[key] = false;
            });
        },
        activateTab(n) {
            this.activeTab = n;
            this.search = '';
            this.getContacts();
        },
        openPopup(id, contact){
            this.modal[id] = true;
            this.contact = contact;
        },
        removeContactConfirm(){
            axios.delete('/dashboard/admin/get-contacts/' + this.contact.id) //destroy method in AdminContactsController
                .then((response) => {
                    if (response.data.success) {
                        this.closePopup();
                        this.getContacts();
                    }
                }).catch((error) => {
                console.log(error);
            });
        },
        getContacts(link) {
            //status = wait, payed ...
            //status_of_view = 'yes' or 'no'; for admin, does he watched this payment or not

            let page = 1
            if (link) {
                let linkUrl = new URL(link.url);
                page = linkUrl.searchParams.get('page')
            }

            let url = '/dashboard/admin/get-contacts'
                + '?page=' + page
                + '&status=' + this.activeTab
                + '&search=' + this.search;

            axios.get(url)
                .then((response) => {
                    if (response.data.success) {
                        this.contacts = response.data.contacts.data;
                        this.pagination = response.data.contacts.meta.links;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>
.pt-messages--tabs {
    width: 70%;
}

.pt-messages--tabs-btn {
    width: auto;
    display: inline-flex;
    padding: 0 20px;
    white-space: nowrap;
}
</style>
