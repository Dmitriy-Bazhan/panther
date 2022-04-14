<template>
    <form class="form">
        <h2>
            Info Block
        </h2>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <p class="form-label">
                        Title
                    </p>
                    <input type="text" class="form-control" v-model="nurseTitle" @change="update">
                </div>
                <div class="form-group">
                    <p class="form-label">
                        Text
                    </p>
                    <textarea type="text" class="form-control" v-model="nurseText" @change="update"></textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <p class="form-label">
                        Title
                    </p>
                    <input type="text" class="form-control" v-model="clientTitle" @change="update">
                </div>
                <div class="form-group">
                    <p class="form-label">
                        Text
                    </p>
                    <textarea type="text" class="form-control" v-model="clientText" @change="update"></textarea>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "InfoBlock",
    props: ['blockData', 'index'],
    data(){
        return {
            nurseText: '',
            nurseTitle: '',
            clientText: '',
            clientTitle: '',
        }
    },
    mounted() {
        if(this.blockData){
            this.nurseText = this.blockData.nurseText
            this.nurseTitle = this.blockData.nurseTitle
            this.clientText = this.blockData.clientText
            this.clientTitle = this.blockData.clientTitle
        }
    },
    methods: {
        update(){
            let self = this;
            let form = {}

            form.nurseText = self.nurseText
            form.nurseTitle = self.nurseTitle

            form.clientText = self.clientText
            form.clientTitle = self.clientTitle

            this.$emit('update', form, self.index)
        }
    }
}
</script>

<style scoped>

</style>
