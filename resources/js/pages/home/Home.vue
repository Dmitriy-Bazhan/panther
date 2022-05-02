<template>
    <div class="page-home">
        <template v-for="block in pageData">
            <component v-bind:is="block.name" :blockData="block.data"></component>
        </template>

        <section class="pt-newsletter">
            <div class="main-wrapper">
                <div class="pt-newsletter--inner">
                    <div class="wrapper">
                        <div class="pt-newsletter--container">
                            <p class="pt-subtitle">
                                <span>newsletter</span>
                            </p>
                            <h2 class="pt-title">
                                Mehr erfahren? Melden Sie sich jetzt für unseren Newsletter an
                            </h2>

                            <form action="" class="pt-newsletter--form">
                                <div class="pt-newsletter--form-group">
                                    <p class="pt-newsletter--form-label">
                                        Wie lautet Ihr Fullname?
                                    </p>
                                    <input type="text" class="pt-simple-input">
                                </div>
                                <div class="pt-newsletter--form-group">
                                    <p class="pt-newsletter--form-label">
                                        Wie lautet Ihre E-Mail-Adresse? *
                                    </p>
                                    <input type="text" class="pt-simple-input">
                                </div>
                                <div class="pt-newsletter--form-group">
                                    <button class="pt-btn--primary pt-md">
                                        anmelden
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>

export default {
    name: "Home",
    data(){
        return {
            pageData: false
        }
    },
    mounted() {
        this.getPage()
    },
    methods: {
        getPage() {
            axios.get('/dashboard/admin/get-page/home' + '?lang=' + window.locale)
                .then((response) => {
                    if(response.data.success){
                        this.pageData = response.data.page.data;
                        console.log(response.data.page)
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
}
</script>

<style scoped>

</style>
