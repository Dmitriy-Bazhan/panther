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
            <div class="form-group">
                <p class="form-label">
                    Slider image
                </p>
                <div class="form-media--preview" v-if="slide.media">
                    <img :src="slide.media.path" alt="">
                    {{slide.media.file_name}}
                </div>
                <button class="btn btn-secondary mt-1" @click="openPopup('media')">Open media</button>
            </div>
            <div class="form-group mt-3">
                <button class="btn btn-success">
                    Add
                </button>
            </div>
        </div>

        <Modal
            v-model="modal.isOpen"
            :close="closePopup"
        >
            <media :is-popup="true" @close-media="closePopup" @select-media="selectMedia"></media>
        </Modal>
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
                media: '',
            },
            modal: {
                isOpen: false,
                id: false
            }
        }
    },
    mounted() {
        if(this.blockData){
            this.slider = this.blockData
        }
    },
    methods: {
        selectMedia(media){
            console.log(media)
            this.slide.media = media
        },
        closePopup(id){
            this.modal.isOpen = false
        },
        openPopup(id){
            this.modal.isOpen = true
        },
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

<style scoped lang="scss">
    .form-media--preview{
        display: flex;
        justify-content: flex-start;
        align-items: center;

        img{
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-right: 15px;
        }
    }
</style>
