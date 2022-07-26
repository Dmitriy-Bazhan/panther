<template>
    <form action="" @submit.prevent="" class="pt-search pt-ml-a">
        <input type="text" class="pt-search--input" v-model="search" placeholder="Suchen">
        <button class="pt-search--btn">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>

    <section class="pt-section-faq">
        <div class="pt-faq">
            <div class="pt-faq--item">
                <div class="pt-faq--item-head" @click="open(0)" :class="{active: activeFaq === 0}">
                    <div class="pt-faq--item-head--number">
                        1
                    </div>
                    <p class="pt-faq--item-head--title">
                        Wie man sich auf der Plattform registriert?
                    </p>
                </div>
                <pt-accordeon>
                    <div class="pt-faq--item-body" v-if="activeFaq === 0">
                        <div class="pt-faq--item-text">
                            This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.
                        </div>
                    </div>
                </pt-accordeon>
            </div>

            <div class="pt-faq--item">
                <div class="pt-faq--item-head" @click="open(1)" :class="{active: activeFaq === 1}">
                    <div class="pt-faq--item-head--number">
                        2
                    </div>
                    <p class="pt-faq--item-head--title">
                        Wie man für die Dienstleistungen des Dienstes bezahlt, wie hoch ist die Provision für Dienstleistungen?
                    </p>
                </div>
                <pt-accordeon>
                    <div class="pt-faq--item-body" v-if="activeFaq === 1">
                        <div class="pt-faq--item-text">
                            This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.
                        </div>
                    </div>
                </pt-accordeon>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "HelpAndService",
    data() {
        return {
            activeFaq: false,
            search: '',
        }
    },
    mounted() {

    },
    methods: {
        open(n) {
            this.activeFaq = this.activeFaq === n?false: n
        }
    },
}
</script>

<style scoped>
    .faq_item--body{
        transition: 1s;
    }
</style>
