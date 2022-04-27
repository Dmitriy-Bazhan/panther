<template>
    <div class="pt-finder">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>Suchen</span>
            </p>
            <h2 class="pt-title">
                LISTING - {{sort}}
            </h2>
            <h2 class="pt-title">
                Sort - {{sort}}
            </h2>
            <h2 class="pt-title">
                Filter - {{filter}}
            </h2>

            <div v-if="nurses" class="pt-listing">
                <filters :filters="filters" @filter="filterStart"></filters>
                <div class="pt-list--wrapper">
                    <div class="pt-select">
                        <v-select :options="sortOptions"
                                  label="title"
                                  v-model="sort">
                            <template #option="{ title }">
                                {{ title }}
                            </template>

                            <template #open-indicator>
                                <span class="pt-select--caret"></span>
                            </template>
                        </v-select>
                    </div>

                    <div class="pt-list">
                        <div v-if="nurses.data.length > 0" v-for="nurse in nurses.data" class="">
                            <div class="pt-card">
                                <div class="pt-card--inner">
                                    <div class="pt-card--preview">
                                        <div class="pt-card--preview-img">
                                            <img v-bind:src="path + '/storage/' + nurse.entity.original_photo"
                                                 alt="no-photo"
                                                 @error="$event.target.src=path + '/images/no-photo.jpg'">
                                        </div>
                                        <div class="pt-card--preview-rate">
                                            <rate :user="nurse"></rate>
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
        </div>
    </div>
</template>

<script>
import Rate from '../components/Rate';
import Filters from './Filters';

export default {
    name: "Listing",
    components: {
        rate: Rate,
        filters: Filters,
    },
    data() {
        return {
            nurses: false,
            filters: false,
            path: location.origin,
            sortOptions: [
                {
                    title: 'Name >',
                    name: 'name',
                    val: 'asc',
                },
                {
                    title: 'Name <',
                    name: 'name',
                    val: 'desc',
                },
                {
                    title: 'Price >',
                    name: 'price',
                    val: 'asc',
                },
                {
                    title: 'Price <',
                    name: 'price',
                    val: 'desc',
                },
            ],
            sort: false,
            filter: false,
        }
    },
    mounted() {
        let self = this

        axios.get('/listing/' + this.$store.state.user.entity_id)
            .then((response) => {
                if (response.data.success && response.data.nurses.data.length > 0) {
                    self.nurses = response.data.nurses
                    self.filters = response.data.filters
                } else {
                    self.$router.push({name: 'Finder'})
                }
            })
            .catch((error) => {
                console.log(error);
            });
    },
    methods: {
        showNurseProfile(nurse) {
            this.$router.push({path: `/nurse/${nurse.id}`})
        },
        filterStart(filters) {
            let self = this
            self.filter = filters
            console.log({
                user_id: this.$store.state.user.entity_id,
                filters: self.filter,
                sort: self.sort,
            })

            axios.post('/finder/get-nurses-to-listing-after-sort', {
                user_id: this.$store.state.user.entity_id,
                filters: self.filter,
                sort: self.sort,
            })
                .then((response) => {
                    console.log(response.data)
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>

</style>
