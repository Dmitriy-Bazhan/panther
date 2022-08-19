<template>
    <div class="page-default">
        <div class="pt-default--content">
            <div class="main-wrapper" v-html="pageData">

            </div>
        </div>

        <div class="main-wrapper">
            <div class="pt-newsletter">
                <div class="pt-newsletter--inner">
                    <div class="pt-row">
                        <div class="pt-col-md-6">
                            <h3>
                                Kontakt
                            </h3>
                            <ul>
                                <li>
                                    info@pflegepanther.com
                                </li>
                                <li>
                                    +4 (123) 567-89-11
                                </li>
                                <li>
                                    Berlin, Strasse 59, 12345
                                </li>
                            </ul>
                            <div class="pt-footer--social">
                                <a href="" class="pt-footer--social-link">
                                    <pt-icon type="facebook"></pt-icon>
                                </a>
                                <a href="" class="pt-footer--social-link">
                                    <pt-icon type="twitter"></pt-icon>
                                </a>
                                <a href="" class="pt-footer--social-link">
                                    <pt-icon type="instagram"></pt-icon>
                                </a>
                            </div>
                        </div>
                        <div class="pt-col-md-6">
                            <form @submit.prevent="send">
                                <div class="pt-form--group">
                                    <p class="pt-form--label">
                                        Name
                                    </p>
                                    <input type="text" v-model="form.name" class="pt-simple-input">
                                </div>
                                <div class="pt-form--group">
                                    <p class="pt-form--label">
                                        Phone
                                    </p>
                                    <input type="text" v-model="form.phone" class="pt-simple-input">
                                </div>
                                <div class="pt-form--group">
                                    <p class="pt-form--label">
                                        Mail
                                    </p>
                                    <input type="text" v-model="form.mail" class="pt-simple-input">
                                </div>
                                <div class="pt-form--group">
                                    <p class="pt-form--label">
                                        Comment
                                    </p>
                                    <textarea v-model="form.comment" class="pt-simple-input"></textarea>
                                </div>

                                <div class="pt-form--group">
                                    <button class="pt-btn--primary pt-md">
                                        anmelden
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Home",
    data() {
        return {
            pageData: false,
            form:{
                name: '',
                phone: '',
                mail: '',
                comment: '',
            }
        }
    },
    mounted() {
        this.getPage()
    },
    methods: {
        getPage() {
            axios.get('/dashboard/admin/get-page/'+ this.$route.name.toLowerCase() + '?lang=' + window.locale)
                .then((response) => {
                    if (response.data.success) {
                        console.log(response.data)
                        this.pageData = response.data.page.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        send() {
            let self = this
            axios.post('/send-contact-form', this.form).then((response) => {
                if (response.data.success) {
                    console.log(response.data)
                }else{
                    console.log(response.data.errors);
                }

            }).catch((error) => {
                console.log(error);
            });
        },
    }
}
</script>

<style lang="scss" scoped>
.page-default {
    padding: 90px 0;
}

.pt-newsletter--inner {
    padding: 30px;

    ul, ol {
        padding: 10px 0 10px 20px;
    }

    ul {
        li {
            list-style-type: disc;
        }
    }
}

.pt-simple-input:not(textarea) {
    height: 45px;
}

.pt-default--content {
    padding: 0px 0;
}
</style>
