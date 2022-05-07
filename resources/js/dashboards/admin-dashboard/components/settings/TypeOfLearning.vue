<template>
    <h5>{{ $t('type_of_learning') }}</h5>
    <table>
        <thead>
        <tr>
            <th>{{ $t('id') }}</th>
            <th>{{ $t('data') }}</th>
            <th>{{ $t('action') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="type_of_learning.length > 0" v-for="item in type_of_learning">
            <td>{{ item.id }}</td>
            <td>
                <input type="text" v-model="item.data[0].data">
            </td>
            <td>
                <button v-if="item.id !== 1" class="btn btn-sm btn-danger"
                        v-on:click="removeTypeOfLearning(item.id)">{{ $t('remove')}}
                </button>
            </td>

        </tr>
        </tbody>
    </table>
    <div v-if="new_type_of_learning.length > 0" v-for="(item, index) in new_type_of_learning">
        <label class="col-form-label-sm" for="new_hear_about_us_data"></label>
        <input type="text" id="new_hear_about_us_data" v-model="new_type_of_learning[index].data">
        <button class="btn btn-sm btn-danger" v-on:click="removeItem(index)">{{ $t('remove') }}</button>
    </div>
    <button class="btn btn-sm btn-danger" v-on:click="addTypeOfLearning()">{{ $t('add') }}</button>
    <br>
    <button class="btn btn-sm btn-success" v-on:click="setTypeOfLearning()">{{ $t('save') }}</button>
</template>

<script>
    export default {
        name: "TypeOfLearning",
        props: ['user'],
        data(){
            return {
                type_of_learning: [],
                new_type_of_learning: [],
            }
        },
        mounted() {
            this.getTypeOfLearning();
        },
        methods: {
            removeTypeOfLearning(id) {
                axios.get('/dashboard/admin/remove-type-of-learning/' + id)
                    .then((response) => {
                        if(response.data.success){
                            this.emitter.emit('response-success-true');
                            this.getTypeOfLearning();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            removeItem(index) {
                this.new_type_of_learning.splice(index, 1);
            },
            addTypeOfLearning() {
                this.new_type_of_learning.push({
                    data: '',
                });
            },
            setTypeOfLearning() {
                axios.post('/dashboard/admin/set-type-of-learning',
                    {
                        'type_of_learning': this.type_of_learning,
                        'lang': window.locale,
                        'new_type_of_learning': this.new_type_of_learning
                    })
                    .then((response) => {
                        if (response.data.success) {
                            this.emitter.emit('response-success-true');
                            this.getTypeOfLearning();
                        } else {
                            console.log(response.data.errors);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            getTypeOfLearning() {
                axios.get('/dashboard/admin/get-type-of-learning?lang=' + window.locale)
                    .then((response) => {
                        this.type_of_learning = response.data.type_of_learning;
                        console.log(this.type_of_learning);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
        }
    }
</script>

<style scoped>

</style>
