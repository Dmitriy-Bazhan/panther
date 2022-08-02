<template>
    <h1>Faq</h1>
    <button class="btn btn-sm btn-success" v-on:click="saveFaqs()">{{ $t('update') }}</button>
    <div v-if="faqs.length > 0" class="" v-for="(item, index) in faqs">
        <h3>
            <button class="btn btn-danger btn-sm" @click.prevent="removeFaq(index)">X</button>
        </h3>
        <div class="form-group">
            <p class="form-label">
                FAQ title
            </p>
            <input type="text" class="form-control" v-model="item.title">
        </div>
        <div class="form-group">
            <p class="form-label">
                FAQ type
            </p>
            <select type="text" class="form-control" v-model="item.type">
                <option value="nurse">{{ $t('nurse')}}</option>
                <option value="client">{{ $t('client')}}</option>
                <option value="guest">{{ $t('guest')}}</option>
                <option value="all">{{ $t('all')}}</option>
            </select>
        </div>
        <div class="form-group">
            <p class="form-label">
                FAQ text
            </p>
            <textarea type="text" class="form-control" v-model="item.content">

                </textarea>
        </div>
        <hr>
    </div>

    <div v-if="new_faqs.length > 0" class="" v-for="(item, index) in new_faqs">

        <h3>
            <button class="btn btn-danger btn-sm" @click.prevent="removeNewItem(index)">X</button>
        </h3>
        <div class="form-group">
            <p class="form-label">
                FAQ title
            </p>
            <input type="text" class="form-control" v-model="item.title">
        </div>
        <div class="form-group">
            <p class="form-label">
                FAQ type
            </p>
            <select type="text" class="form-control" v-model="item.type">
                <option value="nurse">{{ $t('nurse')}}</option>
                <option value="client">{{ $t('client')}}</option>
                <option value="guest">{{ $t('guest')}}</option>
                <option value="all">{{ $t('all')}}</option>
            </select>
        </div>
        <div class="form-group">
            <p class="form-label">
                FAQ text
            </p>
            <textarea type="text" class="form-control" v-model="item.content">

                </textarea>
        </div>
    </div>

    <button class="btn btn-sm btn-success" v-on:click="addItem()">{{ $t('add') }}</button>
    <button class="btn btn-sm btn-success" v-on:click="saveFaqs()">{{ $t('update') }}</button>

</template>

<script>
    export default {
        name: "Faq",
        data() {
            return {
                faqs: [],
                new_faqs: [],
            }
        },
        mounted() {
            this.getFaqs();
        },
        methods: {
            saveFaqs() {
                axios.post('/save-faqs', {
                    'faqs': this.faqs,
                    'new_faqs': this.new_faqs,
                }).then((response) => {
                    if (response.data.success) {
                        this.emitter.emit('response-success-true');
                        this.new_faqs = [],
                        this.getFaqs();
                    }
                })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            getFaqs() {
                axios.get('/get-faqs')
                    .then((response) => {
                        if (response.data.success) {
                            this.faqs = response.data.faqs;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            removeFaq(index) {
                this.faqs.splice(index, 1);
            },
            addItem() {
                let f = {
                    'title': '',
                    'content': '',
                    'type': 'all',
                }
                this.new_faqs.push(f);
            },
            removeNewItem(index) {
                this.new_faqs.splice(index, 1);
            }
        }
    }
</script>

<style scoped>

</style>
