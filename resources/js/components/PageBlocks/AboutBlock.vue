<template>
    <section class="pt-section-default pt-section-about">
        <div class="wrapper">
            <p class="pt-subtitle" v-show="blockData.subtitle">
                <span>{{blockData.subtitle}}</span>
            </p>
            <h2 class="pt-title" v-show="blockData.title">
                {{blockData.title}}
            </h2>

            <p class="pt-block-heading" v-show="blockData.listHeading && blockData.list.length > 0">
                {{blockData.listHeading}}
            </p>

            <div class="pt-row" v-show="blockData.list.length > 0">
                <div class="pt-col-md-6">
                    <p class="pt-i-list--heading" v-show="blockData.text">
                        {{blockData.text}}
                    </p>
                    <ul class="pt-i-list">
                        <li class="pt-i-list--item" v-for="item in blockData.list">
                            <div class="pt-i-list--item-icon">
                                <pt-icon type="company-vision"></pt-icon>
                            </div>
                            <div class="pt-i-list--item-container">
                                <p class="pt-i-list--item-title">
                                    {{item.title}}
                                </p>
                                <p class="pt-i-list--item-text">
                                    {{item.text}}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="pt-col-md-6">
                    <div class="pt-section-about--grid">
                        <div class="pt-section-about--grid-item">
                            <img src="/images/fake/pic1.png" alt="pic">
                        </div>
                        <div class="pt-section-about--grid-item">
                            <img src="/images/fake/pic2.png" alt="pic">
                        </div>
                        <div class="pt-section-about--grid-item">
                            <img src="/images/fake/pic3.png" alt="pic">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "AboutBlock",
    props: ['blockData'],
    mounted() {

    }
}
</script>

<style scoped>

</style>
