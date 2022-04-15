<template>
    <section class="pt-section-users">
        <div class="main-wrapper">
            <div class="pt-section-users--inner" style="background-image: url('/images/fake/bg.png')">
                <div class="wrapper">
                    <div class="pt-row pt-row-stretch">
                        <div class="pt-col-md-6">
                            <div class="pt-section-users--container">
                                <p class="pt-subtitle">
                                    <span>unser Angebot</span>
                                </p>
                                <h2 class="pt-title">
                                    Zahlreiche Pflegekräfte sind
                                    auf der Plattform registriert
                                </h2>
                                <p class="pt-text">
                                    Unsere Pflegekräfte sind geprüft und durch Versicherungsschutz abgedeckt
                                </p>

                                <div class="pt-section-users--bottom">
                                    <a href="" class="pt-btn pt-sm">
                                        alle sehen
                                    </a>

                                    <div class="pt-section-users--ctrl">
                                        <div class="swiper-button-prev">
                                            <i class="fa-solid fa-angle-left"></i>
                                        </div>
                                        <div class="swiper-button-next">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-col-md-6">
                            <swiper
                                class="pt-section-users--slider"
                                :slides-per-view="2"
                                :navigation="navigation"
                                :pagination="pagination"
                                :loop="true"
                                :speed="300"
                                :modules="modules"
                            >
                                <swiper-slide v-for="n in 4">
                                    <div class="pt-section-users--slide">
                                        <div class="pt-section-users--slide-head">
                                            <img src="/images/fake/ava1.png" alt="pic"
                                                 class="pt-section-users--slide-avatar">
                                            <div class="pt-section-users--slide-head--container">
                                                <div class="pt-section-users--slide-head--rating">
                                                    <i class="fa-solid fa-star" v-for="n in 5"></i>
                                                    (180)
                                                </div>
                                                <p class="pt-section-users--slide-head--name">
                                                    Katharina M.
                                                </p>
                                                <p class="pt-section-users--slide-head--age">
                                                    35 Jahre Alt
                                                </p>
                                            </div>
                                        </div>
                                        <div class="pt-section-users--slide-list">
                                            <div class="pt-section-users--slide-list--item">
                                                <div class="pt-section-users--slide-list--item-icon">
                                                    <pt-icon type="pin"></pt-icon>
                                                </div>
                                                <div class="pt-section-users--slide-list--item-container">
                                                    <p class="pt-section-users--slide-list--item-title">
                                                        Ort:
                                                    </p>
                                                    <p class="pt-section-users--slide-list--item-text">
                                                        Berlin
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pt-section-users--slide-list--item">
                                                <div class="pt-section-users--slide-list--item-icon">
                                                    <pt-icon type="pin"></pt-icon>
                                                </div>
                                                <div class="pt-section-users--slide-list--item-container">
                                                    <p class="pt-section-users--slide-list--item-title">
                                                        Altenpflege:
                                                    </p>
                                                    <p class="pt-section-users--slide-list--item-text">
                                                        8 Years (Medical School)
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pt-section-users--slide-list--item">
                                                <div class="pt-section-users--slide-list--item-icon">
                                                    <pt-icon type="pin"></pt-icon>
                                                </div>
                                                <div class="pt-section-users--slide-list--item-container">
                                                    <p class="pt-section-users--slide-list--item-title">
                                                        Sprachen:
                                                    </p>
                                                    <p class="pt-section-users--slide-list--item-text">
                                                        Deutsch, Englisch
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="pt-section-users--slide-list--item">
                                                <div class="pt-section-users--slide-list--item-icon">
                                                    <pt-icon type="pin"></pt-icon>
                                                </div>
                                                <div class="pt-section-users--slide-list--item-container">
                                                    <p class="pt-section-users--slide-list--item-title">
                                                        Verfügbarkeit:
                                                    </p>
                                                    <p class="pt-section-users--slide-list--item-text">
                                                        5 Tage die Woche
                                                        (08:00-21:00 Uhr)
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-section-users--slide-footer">
                                            <a href="" class="pt-btn--primary pt-md">
                                                kontakt
                                            </a>
                                        </div>
                                    </div>
                                </swiper-slide>
                            </swiper>
                        </div>
                    </div>

                    <div class="pt-search-form">
                        <div class="pt-search-form--group">
                            <p class="pt-search-form--label">
                                ort:
                            </p>
                            <div class="pt-select">
                                <div class="pt-select--icon">
                                    <pt-icon type="pin"></pt-icon>
                                </div>
                                <v-select :options="options">
                                    <template #open-indicator>
                                        <span class="pt-select--caret"></span>
                                    </template>
                                </v-select>
                            </div>
                        </div>
                        <div class="pt-search-form--group">
                            <p class="pt-search-form--label">
                                Datum:
                            </p>
                            <div class="pt-select">
                                <div class="pt-select--icon">
                                    <pt-icon type="calendar"></pt-icon>
                                </div>
                                <Datepicker v-model="date" autoApply></Datepicker>
                                <span class="pt-select--caret"></span>
                            </div>
                        </div>
                        <div class="pt-search-form--group">
                            <button class="pt-btn">
                                Pflegekraft finden
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { ref } from 'vue';
import { Navigation, Pagination, EffectFade } from "swiper";
import "swiper/css/effect-fade";

export default {
    name: "MainTestimonials",
    setup() {
        const date = ref(new Date());

        return {
            date,
            options: [
                'foo',
                'bar',
                'baz'
            ],
            modules: [Navigation, Pagination, EffectFade],
            pagination: {
                el: '.pt-section-users  .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.pt-section-users .swiper-button-next',
                prevEl: '.pt-section-users .swiper-button-prev',
            },
        };
    },
}
</script>

<style scoped>

</style>
