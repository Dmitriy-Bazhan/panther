<template>
    <div class="pt-listing">
        <filters :filters="filters" @filter="filterStart"></filters>
        <div class="pt-list--wrapper">
            <div class="pt-list">
                <div v-if="nurses.data.length > 0" v-for="nurse in nurses.data" class="">
                    <div class="pt-card">
                        <div class="pt-card--inner">
                            <div class="pt-card--preview">
                                <div class="pt-card--preview-img">
                                    <img v-bind:src="path + '/storage/' + nurse.entity.original_photo" alt="no-photo"
                                         @error="$event.target.src=path + '/images/no-photo.jpg'">
                                </div>
                                <div class="pt-card--preview-rate">
                                    <pt-rate></pt-rate>
                                </div>
                            </div>
                            <div class="pt-card--info">
                                <div class="pt-card--info-top">
                                    <div class="pt-card--info-general">
                                        <div class="pt-card--info-name">
                                            - {{ nurse.first_name }} - {{ nurse.last_name }}
                                        </div>
                                        <div class="pt-card--info-age">
                                            {{ nurse.entity.age }} Jahre Alt
                                        </div>
                                        <div class="pt-card--info-price">
                                            €{{ nurse.entity.price.hourly_payment }}/stunde
                                        </div>
                                    </div>
                                    <div class="pt-card--info-list">
                                        <div class="pt-card--info-list--item" v-for="n in 4">
                                            <pt-icon type="pin"></pt-icon>
                                            <div class="">
                                                <div class="pt-card--info-list--item-title">
                                                    Ort:
                                                </div>
                                                <div class="pt-card--info-list--item-text">
                                                    12345 Berlin
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-card--info-bottom">
                                    <div class="pt-card--info-descr">
                                        {{ nurse.entity.description }}
                                    </div>
                                    <a href="" class="pt-btn--primary pt-sm"
                                       @click.prevent="showNurseProfile(nurse)">
                                        Kontakt
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="nurses.meta.links.length > 3" class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
            <span v-if="nurses.meta.links.length > 0" v-for="link in nurses.meta.links" class="nurse-link-wrapper">
                <span v-if="link.label.split(';')[1] === ' Previous'" v-on:click="newPage(link.url)" class="nurse-link">
                     preview
                </span>
                <span v-else-if="link.label.split('&')[0] === 'Next '" v-on:click="newPage(link.url)"
                      class="nurse-link">
                    next
                </span>
                <span v-else v-on:click="newPage(link.url)"
                      v-bind:class="link.active ? 'active-link': ''" class="nurse-link">
                    {{ link.label }}
                </span>
            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Filters from './Filters';

export default {
    name: "NursesListing",
    props: ['nurses', 'data', 'filters'],
    components: {
        filters: Filters,
    },
    data() {
        return {
            path: location.origin,
            nurse: false,
            showModalNurseProfile: false
        }
    },
    mounted() {

    },

    methods: {
        showNurseProfile(nurse) {
            this.$router.push({ path: `/nurse/${nurse.id}` })
        },
        filterStart(filters) {
            console.log(filters)

            // /get-nurses-to-listing-after-sort
            // {
            //     user_id: user.entity.id,
            //         filters: {
            //     price: {
            //         max,
            //             min
            //     }
            //     sort: {
            //         name: (name, price),
            //             sort: (asc, desc)
            //     }
            // }
            // }
        }
    }
}
</script>

<style scoped>
.nurse-cards-container {
    height: 80%;
    overflow: auto;
}

.nurse-cards-wrapper {
    padding: 10px;
}

.nurse-card {
    border: solid 1px black;
    box-shadow: 10px 5px 5px #afafaf;
    height: 300px;
}

.nurse-card:hover {
    box-shadow: 5px 2px 2px #afafaf;
}

.nurse-card-image-wrapper {
    padding: 10px;
    height: 180px;
}

.nurse-card-image {
    width: 90%;
}

.nurse-card-item {
    font-size: 14px;
    font-weight: 600;
}

.nurse-link-wrapper {
    background: #0a58ca;
    padding: 10px;
    margin: 1px;
}

.nurse-link {
    cursor: pointer;
}

.active-link {
    color: white;
}
</style>
