<template>
    <div>
        <h1>My information</h1>
        <!--        <p v-for="item in user">{{ item }}</p>-->

        <div class="container-fluid">

            <div class="row">
                <div class="col-3">

                    <!-- first name -->
                    <div class="row">
                        <div class="col-4">
                            <label for="first_name" class="form-label col-form-label-sm">First name</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" v-model="user.first_name"
                                   id="first_name">
                        </div>
                    </div>

                    <!-- last name -->
                    <div class="row">
                        <div class="col-4">
                            <label for="last_name" class="form-label col-form-label-sm">Last name</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" v-model="user.last_name"
                                   id="last_name">
                        </div>
                    </div>

                    <!-- email -->
                    <div class="row">
                        <div class="col-4">
                            <label for="email" class="form-label col-form-label-sm">Email</label>
                        </div>

                        <div class="col-8">
                            <input type="email" class="form-control form-control-sm" v-model="user.email" id="email">
                        </div>
                    </div>

                    <!-- phone -->
                    <div class="row">
                        <div class="col-4">
                            <label for="phone" class="form-label col-form-label-sm">Phone</label>
                        </div>

                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" v-model="user.phone" id="phone">
                        </div>
                    </div>

                    <!-- zip code -->
                    <div class="row">
                        <div class="col-4">
                            <label for="zip_code" class="form-label col-form-label-sm">Zip code</label>
                        </div>

                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" v-model="user.zip_code"
                                   id="zip_code">
                        </div>
                    </div>

                    <!-- gender -->
                    <div class="row">
                        <div class="col-4">
                            <label for="gender" class="form-label col-form-label-sm">Gender</label>
                        </div>

                        <div class="col-8">
                            <select class="form-control form-control-sm" v-model="user.entity.gender" id="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- age -->
                    <div class="row">
                        <div class="col-4">
                            <label for="age" class="form-label col-form-label-sm">Age</label>
                        </div>

                        <div class="col-8">
                            <input type="number" class="form-control form-control-sm" v-model="user.entity.age" id="age"
                                   min="18" max="100">
                        </div>
                    </div>

                    <!-- experience -->
                    <div class="row">
                        <div class="col-4">
                            <label for="experience" class="form-label col-form-label-sm">Experience</label>
                        </div>

                        <div class="col-8">
                            <input type="number" class="form-control form-control-sm" v-model="user.entity.experience"
                                   id="experience" min="18" max="100">
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <!-- pref client gender -->
                    <div class="row">
                        <div class="col-4">
                            <label for="pref_client_gender" class="form-label col-form-label-sm">Preference client
                                gender</label>
                        </div>

                        <div class="col-8">
                            <select class="form-control form-control-sm" v-model="user.entity.pref_client_gender"
                                    id="pref_client_gender">
                                <option value="no_matter">No matter</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- available care range -->
                    <div class="row">
                        <div class="col-4">
                            <label for="available_care_range" class="form-label col-form-label-sm">Available care
                                range</label>
                        </div>

                        <div class="col-8">
                            <select class="form-control form-control-sm" v-model="user.entity.available_care_range"
                                    id="available_care_range">
                                <option value="1">1</option>
                                <option value="1">2</option>
                                <option value="1">3</option>
                                <option value="1">4</option>
                                <option value="1">5</option>
                            </select>
                        </div>
                    </div>

                    <!-- multiple bookings -->
                    <div class="row">
                        <div class="col-4">
                            <label for="multiple_bookings" class="form-label col-form-label-sm">Multiple
                                bookings</label>
                        </div>

                        <div class="col-8">
                            <select class="form-control form-control-sm" v-model="user.entity.multiple_bookings"
                                    id="multiple_bookings">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>

                    <!-- provide supports -->
                    <div class="row">
                        <div class="col-4">
                            <label for="provide_supports" class="form-label col-form-label-sm">Provide supports</label>
                        </div>

                        <div class="col-8">
                            <select class="form-control form-control-sm" v-model="user.entity.provide_supports"
                                    id="provide_supports" multiple>
                                <option v-for="support in data.provider_supports"
                                        :value="support">
                                    {{ $t(support.name) }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-2 offset-3">

                    <div v-if="user.entity.photo !== null" class="my-information-photo-wrapper">
                        <img :src="path + '/' + user.entity.photo" alt="" class="my-information-photo">
                    </div>

                    <div v-else class="my-information-photo-wrapper">
                        <img :src="path + '/images/no-photo.jpg'" alt="no-photo" class="my-information-photo">
                    </div>

                    <input type="file" name="nurse_new_photo" class="form-control-file form-control-sm">

                </div>
            </div>

            <div class="row">

                <div class="col-6">
                    <!-- description -->
                    <div class="row">
                        <div class="col-2">
                            <label for="description" class="form-label col-form-label-sm">Description</label>
                        </div>

                        <div class="col-8">
                            <textarea class="form-control form-control-sm" v-model="user.entity.description"
                                      id="description" rows="6">

                            </textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-2 offset-10">

                    <button class="btn btn-success btn-sm" v-on:click="updateInformation">Update</button>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "MyInformation",
    props: ['user', 'data'],
    data() {
        return {
            path: location.origin,
        }
    },
    watch: {
        // user: {
        //     handler(newValue, oldValue) {
        //         console.log('Watch');
        //         console.log(newValue);
        //         console.log(oldValue);
        //     },
        //     immediate: true
        // },
        user: function (val){
            console.log('FFFF');
        }
    },
    mounted() {

    },
    methods: {
        updateInformation() {
            console.log(this.user);
            axios.put('/dashboard/nurse/' + this.user.id, {'user': this.user})
                .then((response) => {
                    console.log(response);
                })
                .catch();
        },
    }

}
</script>

<style scoped>

.my-information-photo {
    width: 100%;
}

.my-information-photo-wrapper {
    border: solid 1px gray;
}

</style>
