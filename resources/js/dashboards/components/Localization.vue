<template>
  <pt-dropdown icon="globe">
    <template v-slot:menu>
      <a href="" @click.prevent="changeLang('de')" :class="{active: locale === 'de'}" class="pt-dropdown--menu-item">DE</a>
      <a href="" @click.prevent="changeLang('en')" :class="{active: locale === 'en'}" class="pt-dropdown--menu-item">ENG</a>
    </template>
  </pt-dropdown>
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
            changeLang(lang) {
                if (window.guard !== 'guest') {
                    axios.get('/change-lang/'+lang)
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
