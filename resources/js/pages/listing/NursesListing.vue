<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-1 offset-11">
                <button class="btn btn-success btn-sm" v-on:click="cliseModalNurseListing()">close</button>
            </div>
        </div>

    </div>
    <div class="container-fluid nurse-cards-container">
        <div class="row">
            <div v-if="nurses.data.length > 0" v-for="nurse in nurses.data" class="col-4 nurse-cards-wrapper">
                <div class="nurse-card">
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 justify-content-center">
            <span v-if="nurses.links.length > 0" v-for="link in nurses.links" class="nurse-link-wrapper">
                <span v-on:click="newPage(link.url)">{{ link.label}}</span>
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
            console.log(this.nurses);
        },
        methods: {
            cliseModalNurseListing() {
                this.emitter.emit('clise-modal-nurse-listing');
            },
            newPage(url) {
                console.log(url);
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
    }
</style>
