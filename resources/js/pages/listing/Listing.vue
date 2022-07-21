<template>
    <div class="pt-finder">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>Suchen</span>
            </p>
            <h2 class="pt-title">
                Listing
            </h2>

            <div v-if="nurses" class="pt-listing">
                <filters :filters="filters" :clear="filter" @filter="filterSet"></filters>
                <div class="pt-list--wrapper">
                    <div class="pt-listing--head">
                        <div class="pt-listing--head-title">
                            {{nurses.data.length}} Ergebnisse gefunden
                        </div>
                        <div class="pt-listing--head-reset" v-show="filter" @click="clearFilters">
                            <pt-icon type="cross"></pt-icon>
                            <span>Ergebnisse zurücksetzen</span>
                        </div>
                        <div class="pt-listing--head-sort">
                            <div class="pt-listing--head-sort--title">
                                Sortierung:
                            </div>
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
                        </div>
                    </div>

                    <div v-show="!load" class="pt-list">
                        <div v-if="nurses.data.length > 0" v-for="nurse in nurses.data" class="">
                            <pt-card :nurse="nurse"></pt-card>
                        </div>
                    </div>

                    <div class="pt-preloader--container" v-show="load">
                        <pt-preloader></pt-preloader>
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

import Filters from './Filters';
import Card from '../../components/Card/CardListing';

export default {
    name: "Listing",
    components: {
        filters: Filters,
        'pt-card': Card,
    },
    data() {
        return {
            load: false,
            nurses: false,
            filters: false,
            path: location.origin,
            sortOptions: [
                {
                    title: 'Z-A',
                    name: 'name',
                    val: 'desc',
                },
                {
                    title: 'A-Z',
                    name: 'name',
                    val: 'asc',
                },
                {
                    title: 'Preis absteigend',
                    name: 'price',
                    val: 'desc',
                },
                {
                    title: 'Preis aufsteigend',
                    name: 'price',
                    val: 'asc',
                },
            ],
            sort: null,
            filter: false,
        }
    },
    watch: {
        sort: function () {
            let self = this
            self.filterStart()
        }
    },
    mounted() {
        let self = this

        axios.get('/listing/' + this.$store.state.user.entity_id)
            .then((response) => {
                console.log(response.data)
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
        clearFilters() {
            this.filterSet(false);
        },
        filterSet(filters){
            let self = this
            self.filter = filters
            self.filterStart()
        },
        filterStart() {
            let self = this
            self.load = true

            axios.post('/finder/get-nurses-to-listing-after-sort', {
                user_id: self.$store.state.user.entity_id,
                filters: self.filter ? self.filter : {},
                sort: self.sort,
            })
                .then((response) => {
                    self.nurses = response.data.nurses
                    self.load = false
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
