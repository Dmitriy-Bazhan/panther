<template>
    <form class="form" @submit.prevent="addItem">
        <h2>
            Benefits Block
        </h2>

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

        <div class="" v-for="(item, index) in list">
            <hr>
            <h3>Item - {{index + 1}}</h3>
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
                <input type="text" class="form-control"  v-model="listItem.title">
            </div>
            <div class="form-group">
                <p class="form-label">
                    Item text
                </p>
                <textarea type="text" class="form-control" v-model="listItem.text">

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
export default {
    name: "BenefitsBlock",
    props: ['blockData', 'index'],
    data(){
        return {
            subtitle: '',
            title: '',
            list: [],
            listItem: {
                title: '',
                text: '',
            }
        }
    },
    mounted() {
        if(this.blockData){
            this.list = this.blockData.list
            this.title = this.blockData.title
            this.subtitle = this.blockData.subtitle
        }
    },
    methods: {
        addItem(){
            let self = this;
            let isEmpty = false;
            let form = {}

            for (let key in self.listItem){
                if(self.listItem[key] === ''){
                    isEmpty = true
                }
            }

            if(!isEmpty){
                if(!self.list){
                    self.list = []
                }

                self.list.push(JSON.parse(JSON.stringify(self.listItem)))

                for (let key in self.listItem){
                    self.listItem[key] = ''
                }
            }
            self.update()
        },
        update(){
            let self = this;
            let form = {}

            form.title = self.title
            form.subtitle = self.subtitle
            form.list = self.list
            this.$emit('update', form, self.index)
        }
    }
}
</script>

<style scoped>

</style>
