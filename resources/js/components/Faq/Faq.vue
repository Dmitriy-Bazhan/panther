<template>
    <section class="pt-section-faq">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>deine Fragen</span>
            </p>
            <h2 class="pt-title">
                FAQ
            </h2>

            <div class="pt-faq">
                <div class="pt-faq--item">
                    <div class="pt-faq--item-head" @click="open(1)" :class="{active: activeFaq === 1}">
                        <div class="pt-faq--item-head--number">
                            1
                        </div>
                        <p class="pt-faq--item-head--title">
                            Wie man sich auf der Plattform registriert?
                        </p>
                    </div>
                    <pt-accordeon>
                        <div  class="pt-faq--item-body" v-show="activeFaq === 1">
                            <div class="pt-faq--item-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet animi architecto at aut commodi doloremque ea error esse est, harum ipsam iste laborum magnam provident quam quasi tempore. Ab accusamus aliquam aliquid asperiores blanditiis consequatur dolor ea, earum ex excepturi facilis illo impedit inventore ipsa libero magni maxime modi mollitia natus nobis quae quas, quibusdam quis, quos reiciendis rem sapiente! Exercitationem illo minus qui sunt voluptatibus? A culpa, cupiditate deserunt doloremque enim explicabo in ipsum iure magnam minima modi, mollitia necessitatibus officia praesentium provident quam, ratione repellat reprehenderit tempore vel vero voluptas voluptatem. Commodi dicta eaque necessitatibus officia, pariatur sit.
                            </div>
                        </div>
                    </pt-accordeon>
                </div>

                <div class="pt-faq--item">
                    <div class="pt-faq--item-head" @click="open(2)" :class="{active: activeFaq === 2}">
                        <div class="pt-faq--item-head--number">
                            2
                        </div>
                        <p class="pt-faq--item-head--title">
                            Wie man für die Dienstleistungen des Dienstes bezahlt, wie hoch ist die Provision für die Dienstleistungen?
                        </p>
                    </div>
                    <pt-accordeon>
                        <div  class="pt-faq--item-body" v-show="activeFaq === 2">
                            <div class="pt-faq--item-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet animi architecto at aut commodi doloremque ea error esse est, harum ipsam iste laborum magnam provident quam quasi tempore. Ab accusamus aliquam aliquid asperiores blanditiis consequatur dolor ea, earum ex excepturi facilis illo impedit inventore ipsa libero magni maxime modi mollitia natus nobis quae quas, quibusdam quis, quos reiciendis rem sapiente! Exercitationem illo minus qui sunt voluptatibus? A culpa, cupiditate deserunt doloremque enim explicabo in ipsum iure magnam minima modi, mollitia necessitatibus officia praesentium provident quam, ratione repellat reprehenderit tempore vel vero voluptas voluptatem. Commodi dicta eaque necessitatibus officia, pariatur sit.
                            </div>
                        </div>
                    </pt-accordeon>
                </div>

                <div class="pt-faq--item">
                    <div class="pt-faq--item-head" @click="open(3)" :class="{active: activeFaq === 3}">
                        <div class="pt-faq--item-head--number">
                            3
                        </div>
                        <p class="pt-faq--item-head--title">
                            Wie finde ich die richtige Krankenschwester?
                        </p>
                    </div>
                    <pt-accordeon>
                        <div  class="pt-faq--item-body" v-show="activeFaq === 3">
                            <div class="pt-faq--item-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet animi architecto at aut commodi doloremque ea error esse est, harum ipsam iste laborum magnam provident quam quasi tempore. Ab accusamus aliquam aliquid asperiores blanditiis consequatur dolor ea, earum ex excepturi facilis illo impedit inventore ipsa libero magni maxime modi mollitia natus nobis quae quas, quibusdam quis, quos reiciendis rem sapiente! Exercitationem illo minus qui sunt voluptatibus? A culpa, cupiditate deserunt doloremque enim explicabo in ipsum iure magnam minima modi, mollitia necessitatibus officia praesentium provident quam, ratione repellat reprehenderit tempore vel vero voluptas voluptatem. Commodi dicta eaque necessitatibus officia, pariatur sit.
                            </div>
                        </div>
                    </pt-accordeon>
                </div>

                <div class="pt-faq--item">
                    <div class="pt-faq--item-head" @click="open(4)" :class="{active: activeFaq === 4}">
                        <div class="pt-faq--item-head--number">
                            4
                        </div>
                        <p class="pt-faq--item-head--title">
                            Ich bin eine Krankenschwester. Wie registriere ich mich auf der Plattform?
                        </p>
                    </div>
                    <pt-accordeon>
                        <div  class="pt-faq--item-body" v-show="activeFaq === 4">
                            <div class="pt-faq--item-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet animi architecto at aut commodi doloremque ea error esse est, harum ipsam iste laborum magnam provident quam quasi tempore. Ab accusamus aliquam aliquid asperiores blanditiis consequatur dolor ea, earum ex excepturi facilis illo impedit inventore ipsa libero magni maxime modi mollitia natus nobis quae quas, quibusdam quis, quos reiciendis rem sapiente! Exercitationem illo minus qui sunt voluptatibus? A culpa, cupiditate deserunt doloremque enim explicabo in ipsum iure magnam minima modi, mollitia necessitatibus officia praesentium provident quam, ratione repellat reprehenderit tempore vel vero voluptas voluptatem. Commodi dicta eaque necessitatibus officia, pariatur sit.
                            </div>
                        </div>
                    </pt-accordeon>
                </div>

                <div class="pt-faq--item">
                    <div class="pt-faq--item-head" @click="open(5)" :class="{active: activeFaq === 5}">
                        <div class="pt-faq--item-head--number">
                            5
                        </div>
                        <p class="pt-faq--item-head--title">
                            Wie oft kann ich den Dienst nutzen?
                        </p>
                    </div>
                    <pt-accordeon>
                        <div  class="pt-faq--item-body" v-show="activeFaq === 5">
                            <div class="pt-faq--item-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet animi architecto at aut commodi doloremque ea error esse est, harum ipsam iste laborum magnam provident quam quasi tempore. Ab accusamus aliquam aliquid asperiores blanditiis consequatur dolor ea, earum ex excepturi facilis illo impedit inventore ipsa libero magni maxime modi mollitia natus nobis quae quas, quibusdam quis, quos reiciendis rem sapiente! Exercitationem illo minus qui sunt voluptatibus? A culpa, cupiditate deserunt doloremque enim explicabo in ipsum iure magnam minima modi, mollitia necessitatibus officia praesentium provident quam, ratione repellat reprehenderit tempore vel vero voluptas voluptatem. Commodi dicta eaque necessitatibus officia, pariatur sit.
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
    data(){
        return {
            activeFaq: false
        }
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
