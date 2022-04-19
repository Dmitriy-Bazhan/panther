<template>
    <div class="">
        <div class="row mt-2">
            <div class="col-6">
                <h1>Edit Page - {{ $route.params.id }}</h1>
            </div>
            <div class="col-6">
                <button class="btn btn-success" @click.prevent="savePage">Save</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="tabs">
                    <draggable class="tabs-list" :list="pageData.data">
                        <div v-for="(block, index) in pageData.data">
                            <button class="btn"
                                    @click.prevent="activeTab = index"
                                    :key="index"
                                    :class="{'btn-primary': activeTab === index, 'btn-secondary': activeTab !== index}"
                            >
                                {{block.name}}
                            </button>
                            <button class="btn btn-sm btn-danger"
                                    @click.prevent="deleteBlock(block, index)"
                            >
                                X
                            </button>
                        </div>
                    </draggable>
                </div>
            </div>
        </div>

        <div class="row mt-5 mb-5" v-show="activeTab === index" v-for="(block, index) in pageData.data">
            <div class="col-12">
                <component v-bind:is="block.name" :blockData="block.data" :index="index" @update="updateState"></component>
            </div>
        </div>

        <div class="row mt-2 mb-5">
            <div class="col-3">
                <select name="" class="form-select" v-model="selectedBlock">
                    <option :value="option.val" v-for="option in blockList">{{option.name}}</option>
                </select>
            </div>
            <div class="col-3">
                <button class="btn btn-success" @click.prevent="addBlock">Add block</button>
            </div>
        </div>
    </div>
</template>

<script>
import { VueDraggableNext } from 'vue-draggable-next'
import HeadBlock from "../pageBlocks/HeadBlock";
import AboutBlock from "../pageBlocks/AboutBlock";
import BenefitsBlock from "../pageBlocks/BenefitsBlock";
import FaqBlock from "../pageBlocks/FaqBlock";
import InfoBlock from "../pageBlocks/InfoBlock";
import UsersBlock from "../pageBlocks/UsersBlock";


export default {
    name: "EditPage",
    components: {
        draggable: VueDraggableNext,
        'head-block': HeadBlock,
        'about-block': AboutBlock,
        'benefits-block': BenefitsBlock,
        'users-block': UsersBlock,
        'info-block': InfoBlock,
        'faq-block': FaqBlock,
    },
    data(){
        return {
            items: [1,2,3,4],
            activeTab: 0,
            selectedBlock: false,
            blockList: [],
            pageData: {
                page: '',
                data: []
            },
        }
    },
    mounted() {
        this.getPage();

        for(let key in this.$options.components){
            if(key.indexOf('-block') !== -1){
                let name = key.replace('-', ' ')
                name = name[0].toUpperCase() + name.slice(1);

                this.blockList.push({
                    val: key,
                    name: name,
                })
            }
        }
    },
    methods: {
        deleteBlock(block, index){
            this.pageData.data.splice(index, 1)
        },
        addBlock() {
            if(this.selectedBlock){
                this.pageData.data.push({
                    name: this.selectedBlock
                })
                this.activeTab = this.pageData.data.length - 1
                this.selectedBlock = false
            }
        },
        savePage() {
            axios.post('/dashboard/admin/save-page/home', {'pageData': this.pageData})
                .then((response) => {
                    if(response.data.success){
                        this.emitter.emit('response-success-true');
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getPage() {
            axios.get('/dashboard/admin/get-page/home')
                .then((response) => {
                    if(response.data.success){
                        this.pageData = response.data.page;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        updateState(e, index) {
            this.pageData.page = this.$route.params.id
            if(typeof this.pageData.data[index] !== 'object'){
                this.pageData.data[index] = {}
            }
            this.pageData.data[index].data = e
            //this.pageData.data[index].name = this.blockList[index]
        }
    }
}
</script>

<style lang="scss">

</style>
