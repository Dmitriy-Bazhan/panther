<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <h4>List of nurses by search results</h4>
            </div>
            <div class="col-1 offset-7">
                <button class="btn btn-success btn-sm" v-on:click="closeModalNurseListing()">close</button>
            </div>
        </div>

    </div>
    <div class="container-fluid nurse-cards-container">
        <div class="row">
            <div v-if="nurses.data.length > 0" v-for="nurse in nurses.data" class="col-4 nurse-cards-wrapper">
                <div class="nurse-card" v-on:click="showNurseProfile(nurse)">
                    <div class="row">
                        <div class="col-7">
                            <div>
                                <div class="nurse-card-item">name: {{ nurse.first_name }}</div>
                                <div class="nurse-card-item">last_name: {{ nurse.last_name }}</div>
                                <div class="nurse-card-item">age: {{ nurse.entity.age }}</div>
                                <div class="nurse-card-item">price: {{ nurse.entity.price.hourly_payment }}</div>
                                <div class="nurse-card-item">distance: distance</div>

                            </div>
                        </div>

                        <div class="col-5 nurse-card-image-wrapper">
                            <img v-bind:src="path + '/storage/' + nurse.entity.original_photo" alt="no-photo"
                                 class="nurse-card-image">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div>description: {{ nurse.entity.description }}</div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


    </div>
    <br>
    <div v-if="nurses.links.length > 3" class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
            <span v-if="nurses.links.length > 0" v-for="link in nurses.links" class="nurse-link-wrapper">
                <span v-if="link.label.split(';')[1] === ' Previous'" v-on:click="newPage(link.url)" class="nurse-link">
                     preview
                </span>
                <span v-else-if="link.label.split('&')[0] === 'Next '" v-on:click="newPage(link.url)" class="nurse-link">
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
</template>

<script>
    export default {
        name: "NursesListing",
        props: ['nurses', 'data'],
        data() {
            return {
                path: location.origin,
            }
        },
        mounted() {
        },
        methods: {
            closeModalNurseListing() {
                this.emitter.emit('close-modal-nurse-listing');
            },
            newPage(url) {
               this.emitter.emit('get-nurses-new-page', url);
            },
            showNurseProfile(nurse){
                this.emitter.emit('show-nurse-profile', nurse);
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
        color:white;
    }
</style>
