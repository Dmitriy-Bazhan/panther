<template>
    <div class="page-home">
        <main-slider></main-slider>

        <section class="pt-section-default pt-section-about">
            <div class="wrapper">
                <p class="pt-subtitle">
                    <span>Wer sind wir</span>
                </p>
                <h2 class="pt-title">
                    PflegePanther - Pflege neu gedacht
                </h2>

                <p class="pt-block-heading">
                    So einfach funktioniert’s
                </p>

                <div class="pt-row">
                    <div class="pt-col-md-6">
                        <p class="pt-i-list--heading">
                            PflegePanther ermöglicht Transparenz, Qualität und überzeugenden Service für Sie und Ihre Angehörigen.
                        </p>
                        <ul class="pt-i-list">
                            <li class="pt-i-list--item">
                                <div class="pt-i-list--item-icon">
                                    <pt-icon type="company-vision"></pt-icon>
                                </div>
                                <div class="pt-i-list--item-container">
                                    <p class="pt-i-list--item-title">
                                        Profil erstellen
                                    </p>
                                    <p class="pt-i-list--item-text">
                                        Angehörige und Pflegekräfte erstellen ein Profil und geben an, welche Orte, Qualifikationen oder Arbeitszeiten sie sich wünschen.
                                    </p>
                                </div>
                            </li>
                            <li class="pt-i-list--item">
                                <div class="pt-i-list--item-icon">
                                    <pt-icon type="charity"></pt-icon>
                                </div>
                                <div class="pt-i-list--item-container">
                                    <p class="pt-i-list--item-title">
                                        Zusammengebracht werden
                                    </p>
                                    <p class="pt-i-list--item-text">
                                        Durch unsere Suchfunktion werden Angehörige und Pflegekräfte auf der Basis passender Angaben zusammengebracht.
                                    </p>
                                </div>
                            </li>
                            <li class="pt-i-list--item">
                                <div class="pt-i-list--item-icon">
                                    <pt-icon type="search2"></pt-icon>
                                </div>
                                <div class="pt-i-list--item-container">
                                    <p class="pt-i-list--item-title">
                                        Passende Pflege erhalten
                                    </p>
                                    <p class="pt-i-list--item-text">
                                        Buchung und Bezahlung der Pflegedienstleistungen erfolgt schnell und einfach direkt über PflegePanther.
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

        <main-testimonials></main-testimonials>

        <section class="pt-section-benefits">
            <div class="wrapper">
                <p class="pt-subtitle">
                    <span>vorteile</span>
                </p>
                <h2 class="pt-title">
                    PflegePanther – wir stehen für freundliche und qualifizierte Pflege
                </h2>

                <div class="pt-row pt-section-benefits--items">
                    <div class="pt-col-md-6" v-for="n in 4">
                        <div class="pt-section-benefits--item">
                            <div class="pt-section-benefits--item-title">
                                <div class="pt-section-benefits--item-icon">
                                    <pt-icon type="decor"></pt-icon>
                                </div>
                                Geprüfte Qualität
                            </div>
                            <div class="pt-section-benefits--item-text">
                                Sämtliche der auf der Plattform registrierten Pflegekräfte wurden von unserem Team von Experten auf ihre nachweisbare Qualifikation hin geprüft
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-section-register">
            <div class="main-wrapper">
                <div class="pt-section-register--items">
                    <div class="pt-section-register--item">
                        <img src="/images/fake/nurse.png" alt="" class="pt-section-register--item-img">
                        <p class="pt-block-heading">
                            Sie sind Pflegekraft und möchten
                            flexibel, selbstbestimmt arbeiten?
                        </p>
                        <p class="pt-section-register--item-text">
                            Wir verbinden Sie mit denjenigen Pflegebedürftigen und Angehörigen, die Ihre Dienste brauchen. Dabei kümmern wir uns um Verträge, Versicherungsschutz Medikamentenpläne und Terminplanung: Sie können sich komplett auf die Pflege konzentrieren, ihren Lohn legen Sie im Vorfeld selbst fest
                        </p>

                        <a href="" class="pt-btn pt-lg">Registrieren</a>
                    </div>
                    <div class="pt-section-register--item">
                        <img src="/images/fake/old.png" alt="" class="pt-section-register--item-img">
                        <p class="pt-block-heading">
                            Sie sind Angehörige/r einer
                            pflegebedürftigen Person und suchen
                            nach qualifizierter Pflege?
                        </p>
                        <p class="pt-section-register--item-text">
                            Dann ist PflegePanther genau die richtige Wahl. Unter Berücksichtigung der gewünschten Qualifikation, Berufserfahrung, Sprachen, zeitlicher Verfügbarkeit und Vielem mehr suchen wir genau zu Ihnen passende Pflegekräfte in Ihrer Umgebung.
                        </p>

                        <a href="" class="pt-btn pt-lg">Registrieren</a>
                    </div>
                </div>
            </div>
        </section>

        <main-faq></main-faq>

        <section class="pt-newsletter">
            <div class="main-wrapper">
                <div class="pt-newsletter--inner">
                    <div class="wrapper">
                        <div class="pt-newsletter--container">
                            <p class="pt-subtitle">
                                <span>newsletter</span>
                            </p>
                            <h2 class="pt-title">
                                Mehr erfahren? Melden Sie sich jetzt für unseren Newsletter an
                            </h2>

                            <form action="" class="pt-newsletter--form">
                                <div class="pt-newsletter--form-group">
                                    <p class="pt-newsletter--form-label">
                                        Wie lautet Ihr Fullname?
                                    </p>
                                    <input type="text" class="pt-simple-input">
                                </div>
                                <div class="pt-newsletter--form-group">
                                    <p class="pt-newsletter--form-label">
                                        Wie lautet Ihre E-Mail-Adresse? *
                                    </p>
                                    <input type="text" class="pt-simple-input">
                                </div>
                                <div class="pt-newsletter--form-group">
                                    <button class="pt-btn--primary pt-md">
                                        anmelden
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>

export default {
    name: "Home",
}
</script>

<style scoped>

</style>
