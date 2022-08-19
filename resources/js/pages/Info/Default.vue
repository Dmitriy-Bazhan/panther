<template>
    <div className="page-default">
        <div className="pt-default--content">
            <div className="main-wrapper" v-html="pageData">

            </div>
        </div>

        <section className="pt-newsletter">
            <div className="main-wrapper">
                <div className="pt-newsletter--inner">
                    <div className="wrapper">
                        <div className="pt-newsletter--container">
                            <p className="pt-subtitle">
                                <span>newsletter</span>
                            </p>
                            <h2 className="pt-title">
                                Mehr erfahren? Melden Sie sich jetzt für unseren Newsletter an
                            </h2>

                            <form action="" className="pt-newsletter--form">
                                <div className="pt-newsletter--form-group">
                                    <p className="pt-newsletter--form-label">
                                        Wie lautet Ihr Fullname?
                                    </p>
                                    <input type="text" className="pt-simple-input">
                                </div>
                                <div className="pt-newsletter--form-group">
                                    <p className="pt-newsletter--form-label">
                                        Wie lautet Ihre E-Mail-Adresse? *
                                    </p>
                                    <input type="text" className="pt-simple-input">
                                </div>
                                <div className="pt-newsletter--form-group">
                                    <button className="pt-btn--primary pt-md">
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
    data() {
        return {
            pageData: false
        }
    },
    watch: {
        $route() {
            this.getPage()
        },
    },
    mounted() {
        this.getPage()
    },
    methods: {
        getPage() {
            if (this.$route.params.page) {
                axios.get('/dashboard/admin/get-page/' + this.$route.params.page.toLowerCase() + '?lang=' + window.locale)
                    .then((response) => {
                        if (response.data.success) {
                            this.pageData = response.data.page.data;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
}
</script>

<style scoped>

</style>
