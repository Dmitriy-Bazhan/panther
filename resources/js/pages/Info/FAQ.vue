<template>
    <div class="pt-section-default">
        <div class="main-wrapper">
            <tepmlate v-html="pageData"></tepmlate>

            <pt-search class="pt-mt-25"></pt-search>

            <section class="">
                <div class="pt-faq" v-show="faqs.length > 0">
                    <div class="pt-faq--item" v-for="(item, index) in faqs">
                        <div class="pt-faq--item-head" @click="open(index)" :class="{active: activeFaq === index}">
                            <div class="pt-faq--item-head--number">
                                {{index + 1}}
                            </div>
                            <p class="pt-faq--item-head--title">
                                {{item.title}}
                            </p>
                        </div>
                        <pt-accordeon>
                            <div class="pt-faq--item-body" v-if="activeFaq === index">
                                <div class="pt-faq--item-text">
                                    {{item.content}}
                                </div>
                            </div>
                        </pt-accordeon>
                    </div>
                </div>
                <h2 class="pt-title pt-mt-15" v-show="faqs.length === 0">
                    No results
                </h2>
            </section>
        </div>
    </div>
</template>

<script>
export default {
    name: "FAQ",
    data() {
        return {
            pageData: false,
            activeFaq: false,
            search: '',
            faqs: false
        }
    },
    mounted() {
        this.getFaqs()
        this.getPage()

        this.emitter.on('pt-search', (e) => {
            this.search = e
            this.getFaqs()
        })
    },
    methods: {
        open(n) {
            this.activeFaq = this.activeFaq === n?false: n
        },
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
        getFaqs(){
            axios.get('/get-faqs?search=' + this.search)
                .then((response) => {
                    if (response.data.success) {
                        this.faqs = response.data.faqs
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },
}
</script>

<style scoped>
.faq_item--body{
    transition: 1s;
}
</style>
