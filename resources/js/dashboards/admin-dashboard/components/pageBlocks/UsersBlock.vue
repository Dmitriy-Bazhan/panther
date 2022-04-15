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
                    <input type="text" class="form-control" v-model="title" @change="update">
                </div>
                <div class="form-group">
                    <p class="form-label">
                        Subtitle
                    </p>
                    <input type="text" class="form-control" v-model="subtitle" @change="update">
                </div>
                <div class="form-group">
                    <p class="form-label">
                        Text
                    </p>
                    <textarea type="text" class="form-control" v-model="text" @change="update"></textarea>
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
            subtitle: '',
            title: '',
            text: '',
            list: [],
            listItem: {
                title: '',
                text: '',
            }
        }
    },
    mounted() {
        if(this.blockData){
            this.text = this.blockData.text
            this.title = this.blockData.title
            this.subtitle = this.blockData.subtitle
        }
    },
    methods: {
        update(){
            let self = this;
            let form = {}

            form.title = self.title
            form.subtitle = self.subtitle
            form.text = self.text
            this.$emit('update', form, self.index)
        }
    }
}
</script>

<style scoped>

</style>
