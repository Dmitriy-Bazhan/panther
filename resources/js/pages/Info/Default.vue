<template>
    <div class="page-default">
        <div class="pt-default--content">
            <div class="main-wrapper">
                <h1>Title 1</h1>
                <h2>Title 2</h2>
                <h3>Title 3</h3>
                <h4>Title 4</h4>
                <h5>Title 5</h5>
                <h6>Title 6</h6>

                <p>
                    <a href="">Lorem ipsum</a> dolor sit amet, consectetur adipisicing elit. Accusantium atque eum laudantium mollitia nobis placeat quas reprehenderit unde voluptatem? Excepturi.
                </p>
                <p>
                    Lorem ipsum <strong>dolor</strong> sit amet, consectetur adipisicing elit. Accusantium atque eum laudantium mollitia nobis placeat quas reprehenderit unde voluptatem? Excepturi. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab at, dolores earum magnam non ratione!
                </p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium atque eum laudantium mollitia nobis placeat quas reprehenderit unde voluptatem? Excepturi. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem blanditiis eaque eius facilis, ipsum maiores modi nam non officia, pariatur repudiandae sed ullam.
                </p>
                <ul>
                    <li>Lorem ipsum dolor.</li>
                    <li>Lorem ipsum dolor.</li>
                    <li>Lorem ipsum dolor.</li>
                    <li>Lorem ipsum dolor.</li>
                </ul>
                <ol>
                    <li>Lorem ipsum dolor.</li>
                    <li>Lorem ipsum dolor.</li>
                    <li>Lorem ipsum dolor.</li>
                    <li>Lorem ipsum dolor.</li>
                </ol>
            </div>
        </div>

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
