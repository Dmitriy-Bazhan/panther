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

        <div class="row mt-5 mb-5" v-for="(block, index) in blockList">
            <div class="col-12">
                {{block}}
                <component v-bind:is="block" :index="index" @update="updateState"></component>
            </div>
        </div>


        <div class="row mt-2">
            <div class="col-3">
                <select name="" class="form-select" v-model="selectedBlock">
                    <option value="head-block">Head block</option>
                    <option value="about-block">About block</option>
                </select>
            </div>
            <div class="col-3">
                <button class="btn btn-success" @click.prevent="addBlock">Add block</button>
            </div>
        </div>
    </div>
</template>

<script>
    import HeadBlock from "../pageBlocks/HeadBlock";

    export default {
        name: "EditPage",
        components: {
            'head-block': HeadBlock,
            // 'test-chat' : TestChat,
        },
        data() {
            return {
                selectedBlock: false,
                blockList: [],
                pageData: [],
            }
        },
        mounted() {
            this.getPage();
        },
        methods: {
            addBlock() {
                if (this.selectedBlock) {
                    this.blockList.push(this.selectedBlock)
                    this.selectedBlock = false
                }
            },
            savePage() {
                console.log('Save');
                console.log(this.pageData);
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
                            console.log(this.pageData);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },


            updateState(e, index) {
                console.log('Update')
                this.pageData[index] = {}
                this.pageData[index].data = e
                this.pageData[index].name = this.blockList[index]
            }
        }
    }
</script>

<style scoped>

</style>
