<template>
    <div>
        <div v-on:click="changeLangOnDe()" :style="locale === 'de' ? 'color:blue' : ''" class="lang-button">DE</div>
        &nbsp;
        <div v-on:click="changeLangOnEng()" :style="locale === 'en' ? 'color:blue' : ''" class="lang-button">ENG</div>
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
    .lang-button{
        display: inline-block;
        border-radius: 5px;
        width: 40px;
        background: lightgray;
        font-size: 12px;
        font-weight: 700;
        color: gray;
        text-align: center;
        cursor: pointer;
    }
</style>
