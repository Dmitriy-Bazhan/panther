<template>
    <form class="form" @submit.prevent="addItem">
        <h2>
            Benefits Block
        </h2>

        <div class="form-group">
            <p class="form-label">
                Title
            </p>
            <input type="text" class="form-control" v-model="form.title">
        </div>
        <div class="form-group">
            <p class="form-label">
                Subtitle
            </p>
            <input type="text" class="form-control" v-model="form.subtitle">
        </div>

        <div class="" v-for="(item, index) in form.list">
            <hr>
            <h3>
                Item - {{index + 1}}
                <button class="btn btn-danger btn-sm" @click.prevent="removeItem(index)">X</button>
            </h3>
            <div class="form-group">
                <p class="form-label">
                    Item title
                </p>
                <input type="text" class="form-control"  v-model="item.title">
            </div>
            <div class="form-group">
                <p class="form-label">
                    Item text
                </p>
                <textarea type="text" class="form-control" v-model="item.text">

                </textarea>
            </div>
        </div>
        <div class="">
            <hr>
            <h3>New item</h3>
            <div class="form-group">
                <p class="form-label">
                    Item title
                </p>
                <input type="text" class="form-control"  v-model="form.listItem.title">
            </div>
            <div class="form-group">
                <p class="form-label">
                    Item text
                </p>
                <textarea type="text" class="form-control" v-model="form.listItem.text">

                </textarea>
            </div>
            <div class="form-group mt-2">
                <button class="btn btn-success">
                    Add
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import AdminPageBlockInit from '../../../mixins/AdminPageBlockInit'
export default {
    name: "BenefitsBlock",
    mixins: [AdminPageBlockInit],
    props: ['blockData', 'index'],
    data(){
        return {
            form: {
                subtitle: '',
                title: '',
                list: [],
                listItem: {
                    title: '',
                    text: '',
                }
            }
        }
    },
    mounted() {

    },
    methods: {

    }
}
</script>

<style scoped>

</style>
