<template>
    <form class="form">
        <h2>
            Users Block
        </h2>

        <div class="row">
            <div class="col-sm-12">
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
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "UsersBlock",
    props: ['blockData', 'index'],
    data(){
        return {
            form: {
                subtitle: '',
                title: '',
                text: '',
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
