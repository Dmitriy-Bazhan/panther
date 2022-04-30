<template>
    <div class="container-fluid">
        <div class="row">
            <!--        photo-->
            <div class="col-3">

                <div v-if="user.entity.original_photo !== null" class="my-information-photo-wrapper">
                    <img v-bind:src="path + '/storage/' + user.entity.original_photo" alt="no-photo"
                         class="my-information-photo">
                </div>

                <div v-else class="my-information-photo-wrapper">
                    <img :src="path + '/images/no-photo.jpg'" alt="no-photo" class="my-information-photo">

                </div>

                <input type="file" name="nurse_new_photo"
                       ref="file"
                       v-on:change="photoUpload()"
                       class="form-control-file form-control-sm">
                <span class="register-form-error" v-if="errors !== null && errors['file'] !== undefined">{{ errors['file'][0] }}</span>
            </div>

            <div class="col-7 offset-1" style="border: solid 1px lightgray">
                <div>
                    {{ $t('certificates') }}

                    <div v-for="(certificat, index) in certificates">

                        <div class="row">
                            <div class="col-4">
                                <div class="certificate-thumbnail-photo-wrapper">
                                    <img v-bind:src="path + '/storage/' + certificat.file_path" alt="no-photo"
                                         class="certificate-thumbnail-photo">
                                </div>
                            </div>
                            <div class="col-8">
                                Title:<input type="text" v-model="certificat.title"><br>
                                Date:<input type="text" v-model="certificat.date"><br>
                                Place of receipt:<input type="text" v-model="certificat.place_of_receipt"><br>
                                Other info:<input type="text" v-model="certificat.other_info"><br>

                                <input type="file" @change="upload($event, index)"><br>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <button @click="addItem">Add Certificat</button>
                    <hr>
                </div>


                <div>
                    {{ $t('criminal_record') }}
                    <input type="file" id="criminal_record" ref="criminal_record" multiple
                           class="form-control-file form-control-sm"/>
                    <p class="file_name" v-for="item in filterFiles(user.entity.files, 'criminal_record')">{{
                        item.original_name }}</p><br>
                    <span class="register-form-error" v-if="errors !== null && errors['criminal_record'] !== undefined">{{ errors['criminal_record'][0] }}</span>
                </div>

                <div>
                    {{ $t('documentation_of_training') }}
                    <input type="file" id="documentation_of_training" ref="documentation_of_training" multiple
                           class="form-control-file form-control-sm"/>
                    <p class="file_name" v-for="item in filterFiles(user.entity.files, 'documentation_of_training')">{{
                        item.original_name }}</p>
                    <span class="register-form-error"
                          v-if="errors !== null && errors['documentation_of_training'] !== undefined">{{ errors['documentation_of_training'][0] }}</span>
                </div>

                <div>
                    {{ $t('CPR_course') }}
                    <input type="file" id="CPR_course" ref="CPR_course" multiple
                           class="form-control-file form-control-sm"/>
                    <p class="file_name" v-for="item in filterFiles(user.entity.files, 'CPR_course')">{{
                        item.original_name }}</p>
                </div>

                <div>
                    {{ $t('references') }}
                    <input type="file" id="references" ref="references" multiple
                           class="form-control-file form-control-sm"/>
                    <p class="file_name" v-for="item in filterFiles(user.entity.files, 'references')">{{
                        item.original_name }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-2 offset-10">
                <button class="btn btn-success btn-sm" v-on:click="updateFilesAndPhoto">{{ $t('update') }}</button>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "NurseFilesAndPhoto",
        props: ['user', 'data'],
        data() {
            return {
                path: location.origin,
                errors: null,
                certificates: [],
                criminal_record: '',
                documentation_of_training: '',
                CPR_course: '',
                references: '',
                file: '',
            }
        },
        mounted() {
            console.log(this.user);

        },
        watch: {
            user: {
                handler(newValue, oldValue) {
                    let arr = this.filterFiles(this.user.entity.files, 'certificate');
                    for (let i = 0; i < arr.length; i++) {
                        this.certificates.push({
                            id: arr[i].id,
                            title: arr[i].title,
                            thumbnail_path: arr[i].thumbnail_path,
                            file_path: arr[i].file_path,
                            date: arr[i].date,
                            place_of_receipt: arr[i].place_of_receipt,
                            other_info: arr[i].other_info,
                            file: '',
                        });
                    }
                },
                immediate: true
            },
        },
        methods: {
            addItem() {
                this.certificates.push({title: '', date: '', place_of_receipt: '', other_info: '', file: '',})
            },

            upload(event, index) {
                this.certificates[index].file = event.target.files[0]
            },


            updateFilesAndPhoto() {
                this.criminal_record = this.$refs.criminal_record.files;
                this.documentation_of_training = this.$refs.documentation_of_training.files;
                this.CPR_course = this.$refs.CPR_course.files;
                this.references = this.$refs.references.files;
                this.file = this.$refs.file.files[0];
                let formData = new FormData();
                formData.append('file', this.file);
                formData.append('certificates', JSON.stringify(this.certificates));

                for (let i = 0; i < this.certificates.length; i++) {
                    let file = this.certificates[i].file;
                    formData.append('certificates_files[' + i + ']', file);
                }

                for (let i = 0; i < this.criminal_record.length; i++) {
                    let file = this.criminal_record[i];
                    formData.append('criminal_record[' + i + ']', file);
                }


                for (let i = 0; i < this.documentation_of_training.length; i++) {
                    let file = this.documentation_of_training[i];
                    formData.append('documentation_of_training[' + i + ']', file);
                }

                for (let i = 0; i < this.CPR_course.length; i++) {
                    let file = this.CPR_course[i];
                    formData.append('CPR_course[' + i + ']', file);
                }

                for (let i = 0; i < this.references.length; i++) {
                    let file = this.references[i];
                    formData.append('references[' + i + ']', file);
                }

                axios.post('/dashboard/nurse-my-information/update-files-and-photo/' + this.user.id,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    })
                    .then((response) => {
                        if (response.data.success) {
                            console.log(response.data);
                            this.emitter.emit('response-success-true');
                            this.errors = null;
                            this.emitter.emit('photo-exist');
                        } else {
                            this.errors = response.data.errors;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            filterFiles(data, type) {
                return data.filter(function (el) {
                    if (el.file_type === type) {
                        return true;
                    }
                })
            },
            photoUpload() {
                //todo:: photo preview
            },
        }
    }
</script>

<style scoped>

</style>
