<template>
    <div class="container-fluid">
        <div class="row header-wrapper">

            <div class="col-2 offset-8" v-on:click="changeLang">
                Lang : {{ $t('lang') }}
            </div>
            <div v-if="auth == null" class="col-2">
                <a href="login">
                    <button class="btn btn-sm btn-success">Login</button>
                </a>&nbsp;
                <a href="register">
                    <button class="btn btn-sm btn-success">Register</button>
                </a>
            </div>

            <div v-else class="col-2">
                <span>{{ auth.first_name }}</span>
                <button v-on:click="logOut" class="btn btn-sm btn-success">Log out</button>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "Header",
    props: {
        auth: Object,
    },
    mounted() {
    },
    methods: {
        logOut() {
            axios.get('/log-out')
                .then((response) => {
                    if (response.data.success) {
                        location.href = '/';
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
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
