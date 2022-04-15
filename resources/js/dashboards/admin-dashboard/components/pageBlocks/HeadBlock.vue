<template>
    <form class="form" @submit.prevent="addItem">
        <h2>
            Head Block
        </h2>
        <div class="" v-for="(item, index) in slider">
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
            <hr>
        </div>
        <div class="">
            <div class="form-group">
                <p class="form-label">
                    Slider title
                </p>
                <input type="text" class="form-control" v-model="slide.title">
            </div>
            <div class="form-group">
                <p class="form-label">
                    Slider subtitle
                </p>
                <input type="text" class="form-control" v-model="slide.subtitle">
            </div>
            <div class="form-group">
                <p class="form-label">
                    Slider text
                </p>
                <input type="text" class="form-control" v-model="slide.text">
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
    name: "HeadBlock",
    props: ['blockData', 'index'],
    data(){
        return {
            slider: [],
            slide: {
                title: '',
                subtitle: '',
                text: '',
            }
        }
    },
    mounted() {
        if(this.blockData){
            this.slider = this.blockData
        }
    },
    methods: {
        removeItem(index){
            this.slider.splice(index, 1)
        },
        addItem(){
            let self = this;
            let isEmpty = false;

            for (let key in self.slide){
                if(self.slide[key] === ''){
                    isEmpty = true
                }
            }

            if(!isEmpty){
                if(!self.slider){
                    self.slider = []
                }

                self.slider.push(JSON.parse(JSON.stringify(self.slide)))

                for (let key in self.slide){
                    self.slide[key] = ''
                }
            }
            this.$emit('update', self.slider, self.index)
        }
    }
}
</script>

<style scoped>

</style>
