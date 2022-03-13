<template>
    <div v-on:click="changeLang">
        Lang : <span  class="locale-name">{{ $t('lang') }}</span>
    </div>
</template>

<script>
export default {
    name: "Localization",
    methods: {
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
.locale-name{
    cursor:pointer;

}
</style>
