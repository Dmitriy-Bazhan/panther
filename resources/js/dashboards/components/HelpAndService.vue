<template>
    <pt-search></pt-search>

    <section class="pt-section-faq">
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
</template>

<script>
export default {
    name: "HelpAndService",
    data() {
        return {
            activeFaq: false,
            search: '',
            faqs: false
        }
    },
    mounted() {
        this.getFaqs()

        this.emitter.on('pt-search', (e) => {
            this.search = e
            this.getFaqs()
        })
    },
    methods: {
        open(n) {
            this.activeFaq = this.activeFaq === n?false: n
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
