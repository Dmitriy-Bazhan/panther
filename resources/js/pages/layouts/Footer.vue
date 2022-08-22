<template>
    <div class="pt-footer">
        <div class="wrapper">
            <div class="pt-row">
                <div class="pt-col-md-3">
                    <a href="" class="pt-footer--logo">
                        <img :src="path + '/images/logo.png'" alt="logo">
                    </a>
                </div>
                <div class="pt-col-md-3">
                    <p class="pt-footer--list-title">
                        Information
                    </p>
                    <ul class="pt-footer--list">
                        <li class="pt-footer--list-item">
                            <router-link to="/info/for-nurse">
                                Für Pflegekraft
                            </router-link>
                        </li>
                        <li class="pt-footer--list-item">
                            <router-link to="/info/for-client">
                                Für Klient
                            </router-link>
                        </li>
                        <li class="pt-footer--list-item">
                            <router-link :to="{ name : 'FAQ' }">
                                FAQ
                            </router-link>
                        </li>
                        <li class="pt-footer--list-item">
                            <router-link to="/info/about">
                                Über Uns
                            </router-link>
                        </li>
                        <li class="pt-footer--list-item">
                            <router-link :to="{ name : 'Contacts' }">
                                Kontakt
                            </router-link>
                        </li>
                    </ul>
                </div>
                <div class="pt-col-md-3">
                    <p class="pt-footer--list-title">
                        Platform
                    </p>
                    <ul class="pt-footer--list">
                        <li class="pt-footer--list-item">
                            <a href="/register/client">
                                Kundenregistrierung
                            </a>
                        </li>
                        <li class="pt-footer--list-item">
                            <a href="/register/nurse">
                                Pflegekraftegistrierung
                            </a>
                        </li>
                        <li class="pt-footer--list-item">
                            <a href="">Mein Konto</a>
                        </li>
                    </ul>
                </div>
                <div class="pt-col-md-3">
                    <p class="pt-footer--list-title">
                        Kontakt
                    </p>
                    <ul class="pt-footer--list">
                        <li class="pt-footer--list-item">
                            info@pflegepanther.com
                        </li>
                        <li class="pt-footer--list-item">
                            +4 (123) 567-89-11
                        </li>
                        <li class="pt-footer--list-item">
                            Berlin, Strasse 59, 12345
                        </li>
                    </ul>
                    <div class="pt-footer--social">
                        <a href="" class="pt-footer--social-link">
                            <pt-icon type="facebook"></pt-icon>
                        </a>
                        <a href="" class="pt-footer--social-link">
                            <pt-icon type="twitter"></pt-icon>
                        </a>
                        <a href="" class="pt-footer--social-link">
                            <pt-icon type="instagram"></pt-icon>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-footer--text">
                <p>
                    © 2022 PflegePanther GmbH.
                </p>
                <p>
                    <a href="">Impressum & Datenschutz</a>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Footer",
    props: ['data'],
    data() {
        return {
            path: location.origin,
        }
    },
    mounted() {

    }
}
</script>

<style scoped>
.footer-wrapper {
    background: dimgray;
}
</style>
