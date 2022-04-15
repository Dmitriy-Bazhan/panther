<template>
    <form class="form" @submit.prevent="addItem">
        <h2>
            About Block
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
        <div class="form-group">
            <p class="form-label">
                Text
            </p>
            <textarea type="text" class="form-control" v-model="text" @change="update"></textarea>
        </div>
        <div class="form-group">
            <p class="form-label">
                List heading
            </p>
            <input type="text" class="form-control" v-model="listHeading" @change="update">
        </div>

        <div class="" v-for="(item, index) in list">
            <hr>
            <h3>
                List item - {{index + 1}}
                <button class="btn btn-danger btn-sm" @click.prevent="removeItem(index)">X</button>
            </h3>
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
                <input type="text" class="form-control"  v-model="listItem.title">
            </div>
            <div class="form-group">
                <p class="form-label">
                    List item text
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
    name: "AboutBlock",
    props: ['blockData', 'index'],
    data(){
        return {
            subtitle: '',
            title: '',
            text: '',
            listHeading: '',
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
            this.text = this.blockData.text
            this.title = this.blockData.title
            this.listHeading = this.blockData.listHeading
            this.subtitle = this.blockData.subtitle
        }
    },
    methods: {
        removeItem(index){
            this.list.splice(index, 1)
        },
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
            form.text = self.text
            form.list = self.list
            form.listHeading = self.listHeading
            this.$emit('update', form, self.index)
        }
    }
}
</script>

<style scoped>

</style>
