<template>
    <form class="form" @submit.prevent="addItem">
        <h2>
            Head Block
        </h2>
        <div class="" v-for="(item, index) in form.list">
            <hr>
            <h3>
                Slide - {{index + 1}}
                <button class="btn btn-danger btn-sm" @click.prevent="removeItem(index)">X</button>
            </h3>
            <div class="form-group">
                <p class="form-label">
                    Slide title
                </p>
                <input type="text" class="form-control" v-model="item.title">
            </div>
            <div class="form-group">
                <p class="form-label">
                    Slide subtitle
                </p>
                <input type="text" class="form-control" v-model="item.subtitle">
            </div>
            <div class="form-group">
                <p class="form-label">
                    Slide text
                </p>
                <input type="text" class="form-control" v-model="item.text">
            </div>
            <div class="form-group">
                <p class="form-label">
                    Slider image
                </p>
                <div class="form-media--preview" v-if="item.media">
                    <img :src="item.media.path" alt="">
                    {{item.media.file_name}}
                </div>
            </div>
            <hr>
        </div>
        <div class="">
            <div class="form-group">
                <p class="form-label">
                    Slider title
                </p>
                <input type="text" class="form-control" v-model="form.listItem.title">
            </div>
            <div class="form-group">
                <p class="form-label">
                    Slider subtitle
                </p>
                <input type="text" class="form-control" v-model="form.listItem.subtitle">
            </div>
            <div class="form-group">
                <p class="form-label">
                    Slider text
                </p>
                <input type="text" class="form-control" v-model="form.listItem.text">
            </div>
            <div class="form-group">
                <p class="form-label">
                    Slider image
                </p>
                <div class="form-media--preview" v-if="form.listItem.media">
                    <img :src="form.listItem.media.path" alt="">
                    {{form.listItem.media.file_name}}
                </div>
                <media-popup
                    :modelValue="form.listItem.media"
                    @update:modelValue="newValue => form.listItem.media = newValue"
                ></media-popup>
            </div>
            <div class="form-group mt-3">
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
    name: "HeadBlock",
    mixins: [AdminPageBlockInit],
    props: ['blockData', 'index'],
    data(){
        return {
            form: {
                list: [],
                listItem: {
                    title: '',
                    subtitle: '',
                    text: '',
                    media: '',
                },
            }
        }
    },
    methods: {

    }
}
</script>

<style scoped lang="scss">

</style>
