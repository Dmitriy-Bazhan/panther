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
                            <a href="">Für Pflegekraft</a>
                        </li>
                        <li class="pt-footer--list-item">
                            <a href="">Für Klient</a>
                        </li>
                        <li class="pt-footer--list-item">
                            <a href="">FAQ</a>
                        </li>
                        <li class="pt-footer--list-item">
                            <a href="">Über Uns</a>
                        </li>
                        <li class="pt-footer--list-item">
                            <a href="">Kontakt</a>
                        </li>
                    </ul>
                </div>
                <div class="pt-col-md-3">
                    <p class="pt-footer--list-title">
                        Platform
                    </p>
                    <ul class="pt-footer--list">
                        <li class="pt-footer--list-item">
                            <a href="">Kundenregistrierung</a>
                        </li>
                        <li class="pt-footer--list-item">
                            <a href="">Pflegekraftegistrierung</a>
                        </li>
                        <li class="pt-footer--list-item">
                            <a href="">Mein Konto</a>
                        </li>
                        <li class="pt-footer--list-item">
                            <a href="">Support</a>
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
        data() {
            return {
                path: location.origin,
            }
        },
    }
</script>

<style scoped>
    .footer-wrapper {
        background: dimgray;
    }
</style>
