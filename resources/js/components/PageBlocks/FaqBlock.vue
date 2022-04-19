<template>
    <section class="pt-section-faq" v-if="blockData">
        <div class="wrapper">
            <p class="pt-subtitle" v-show="blockData.subtitle">
                <span>{{blockData.subtitle}}</span>
            </p>
            <h2 class="pt-title" v-show="blockData.title">
                {{blockData.title}}
            </h2>

            <div class="pt-faq" v-if="blockData.list.length > 0">
                <div class="pt-faq--item" v-for="(item, index) in blockData.list">
                    <div class="pt-faq--item-head" @click="open(index)" :class="{active: activeFaq === index}">
                        <div class="pt-faq--item-head--number">
                            {{index+1}}
                        </div>
                        <p class="pt-faq--item-head--title">
                            {{item.title}}
                        </p>
                    </div>
                    <pt-accordeon>
                        <div  class="pt-faq--item-body" v-show="activeFaq === index">
                            <div class="pt-faq--item-text">
                                {{item.text}}
                            </div>
                        </div>
                    </pt-accordeon>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { ref } from 'vue';

export default {
    name: "Faq",
    props: ['blockData'],
    data(){
        return {
            activeFaq: false
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
