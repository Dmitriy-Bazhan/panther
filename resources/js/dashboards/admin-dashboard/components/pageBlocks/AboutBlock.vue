<template>
    <form class="form" @submit.prevent="addItem">
        <h2>
            About Block
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
        <div class="form-group">
            <p class="form-label">
                Text
            </p>
            <textarea type="text" class="form-control" v-model="form.text"></textarea>
        </div>
        <div class="form-group">
            <h2>
                Images:
            </h2>
        </div>

        <div class="form-group">
            <p class="form-label">
                Slider image 1
            </p>
            <div class="form-media--preview" v-if="form.image1">
                <img :src="form.image1.path" alt="">
                {{form.image1.file_name}}
            </div>
            <media-popup
                :modelValue="form.image1"
                @update:modelValue="newValue => form.image1 = newValue"
            ></media-popup>
        </div>

        <div class="form-group">
            <p class="form-label">
                Slider image 1
            </p>
            <div class="form-media--preview" v-if="form.image2">
                <img :src="form.image2.path" alt="">
                {{form.image2.file_name}}
            </div>
            <media-popup
                :modelValue="form.image2"
                @update:modelValue="newValue => form.image2 = newValue"
            ></media-popup>
        </div>

        <div class="form-group">
            <p class="form-label">
                Slider image 1
            </p>
            <div class="form-media--preview" v-if="form.image3">
                <img :src="form.image3.path" alt="">
                {{form.image3.file_name}}
            </div>
            <media-popup
                :modelValue="form.image3"
                @update:modelValue="newValue => form.image3 = newValue"
            ></media-popup>
        </div>

        <hr>

        <div class="form-group">
            <p class="form-label">
                List heading
            </p>
            <input type="text" class="form-control" v-model="form.listHeading">
        </div>

        <div class="" v-for="(item, index) in form.list">
            <hr>
            <h3>
                List item - {{index + 1}}
                <button class="btn btn-danger btn-sm" @click.prevent="removeItem(index)">X</button>
            </h3>
            <div class="form-group">
                <p class="form-label">
                    List item icon
                </p>

                <v-select :options="icons" label="name" v-model="item.icon">
                    <template #option="{name, icon}">
                        <pt-icon :type="icon"></pt-icon>
                        <em>{{ name }}</em>
                    </template>
                </v-select>
            </div>
            <div class="form-group">
                <p class="form-label">
                    List item title
                </p>
                <input type="text" class="form-control"  v-model="item.title">
            </div>
            <div class="form-group">
                <p class="form-label">
                    List item text
                </p>
                <textarea type="text" class="form-control" v-model="item.text">

                </textarea>
            </div>
        </div>
        <div class="">
            <hr>
            <h3>New list item</h3>
            <div class="form-group">
                <p class="form-label">
                    List item title
                </p>
                <input type="text" class="form-control" v-model="form.listItem.title">
            </div>
            <div class="form-group">
                <p class="form-label">
                    List item text
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
    name: "AboutBlock",
    mixins: [AdminPageBlockInit],
    props: ['blockData', 'index'],
    data(){
        return {
            icons: [
                {
                    icon: 'company-vision',
                    name: 'company vision',
                },
                {
                    icon: 'search2',
                    name: 'search',
                },
                {
                    icon: 'charity',
                    name: 'charity',
                },
                {
                    icon: 'nurse',
                    name: 'nurse',
                },
            ],
            form: {
                subtitle: '',
                title: '',
                text: '',
                image1: '',
                image2: '',
                image3: '',
                listHeading: '',
                list: [],
                listItem: {
                    title: '',
                    text: '',
                    icon: '',
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

<style lang="scss">
    .v-select{
        .pt-icon{
            width: 24px;
            height: 24px;
            margin-right: 10px;
            color: black;
        }
    }
</style>
