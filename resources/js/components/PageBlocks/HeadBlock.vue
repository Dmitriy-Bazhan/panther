<template>
    <section class="main-slider" v-if="blockData && blockData.list.length > 0">
        <div class="main-wrapper">
            <swiper
                :slides-per-view="1"
                :navigation="navigation"
                :pagination="pagination"
                :loop="true"
                :speed="1000"
                :modules="modules"
            >
                <swiper-slide v-for="slide in blockData.list">
                    <div class="main-slider--item">
                        <img src="/images/fake/fake-slide.png" alt="pic" class="main-slider--img">
                        <div class="wrapper">
                            <div class="main-slider--container">
                                <p class="main-slider--subtitle">
                                    Pflege neu gedacht
                                </p>
                                <h2 class="main-slider--title">
                                    Qualität und überzeugenden Service
                                    für Sie und Ihre Angehörige
                                </h2>
                                <p class="main-slider--text">
                                    PflegePanther – freundliche und qualifizierte Pflege
                                </p>
                            </div>
                        </div>
                    </div>
                </swiper-slide>
            </swiper>

            <div class="wrapper main-slider-bottom">
                <div class="pt-row pt-row-end">
                    <div class="pt-col-md-6">
                        <div class="main-slider--promos">
                            <div class="main-slider--promo">
                                <p class="main-slider--promo-title">
                                    Sie benötigen Hilfe
                                </p>
                                <p class="main-slider--promo-text">
                                    Sind Sie suchen nach qualifizierter Pflege?
                                </p>
                                <a href="" class="main-slider--promo-link">
                                    Pflegekraft finden
                                </a>
                            </div>
                            <div class="main-slider--promo">
                                <p class="main-slider--promo-title">
                                    Sie sind Pflegekraft
                                </p>
                                <p class="main-slider--promo-text">
                                    Wir verbinden Sie mit denjenigen Pflegebedürftigen
                                </p>
                                <a href="" class="main-slider--promo-link">
                                    Pflegekraftregistrierung
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="pt-col-md-6" v-if="blockData && blockData.list.length > 0">
                        <div class="main-slider--ctrl">
                            <div class="swiper-pagination"></div>
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
        </div>
    </section>
</template>

<script>
import { Navigation, Pagination, EffectFade } from "swiper";
import "swiper/css/effect-fade";

export default {
    name: "main-slider",
    props: ['blockData'],
    setup() {
        return {
            modules: [Navigation, Pagination, EffectFade],
            pagination: {
                el: '.main-slider .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.main-slider .swiper-button-next',
                prevEl: '.main-slider .swiper-button-prev',
            },
        };
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
