<template>
    <div class="lang-btns">
        <div v-on:click="changeLangOnDe()" :class="{active: locale === 'de'}" class="lang-btn">DE</div>
        <div v-on:click="changeLangOnEng()" :class="{active: locale === 'en'}" class="lang-btn">ENG</div>
    </div>
</template>

<script>
    export default {
        name: "Localization",
        data(){
            return {
                locale: 'en'
            }
        },
        mounted() {
            this.locale = window.locale;
        },
        methods: {
            changeLangOnDe() {
                if (window.guard !== 'guest') {
                    axios.get('/change-lang/de')
                        .then((response) => {
                            if (response.data.success) {
                                location.reload();
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                } else {
                    window.localStorage.setItem('locale', 'de');
                    location.reload();
                }
            },
            changeLangOnEng() {
                if (window.guard !== 'guest') {
                    axios.get('/change-lang/en')
                        .then((response) => {
                            if (response.data.success) {
                                location.reload();
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                } else {
                    window.localStorage.setItem('locale', 'en');
                    location.reload();
                }
            },

            changeLang() {
                if (window.guard !== 'guest') {
                    axios.get('/change-lang')
                        .then((response) => {
                            if (response.data.success) {
                                location.reload();
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                } else {
                    let locale = window.localStorage.getItem('locale');
                    if (locale === 'en') {
                        window.localStorage.setItem('locale', 'de');
                    } else {
                        window.localStorage.setItem('locale', 'en');
                    }
                    location.reload();
                }
            }
        }
    }
</script>

<style scoped>
</style>
