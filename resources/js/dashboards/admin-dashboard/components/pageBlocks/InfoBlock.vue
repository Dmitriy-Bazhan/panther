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
                    <input type="text" class="form-control" v-model="form.nurseTitle">
                </div>
                <div class="form-group">
                    <p class="form-label">
                        Text
                    </p>
                    <textarea type="text" class="form-control" v-model="form.nurseText"></textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <p class="form-label">
                        Title
                    </p>
                    <input type="text" class="form-control" v-model="form.clientTitle">
                </div>
                <div class="form-group">
                    <p class="form-label">
                        Text
                    </p>
                    <textarea type="text" class="form-control" v-model="form.clientText"></textarea>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import AdminPageBlockInit from "../../../mixins/AdminPageBlockInit";

export default {
    name: "InfoBlock",
    mixins: [AdminPageBlockInit],
    props: ['blockData', 'index'],
    data(){
        return {
            form: {
                nurseText: '',
                nurseTitle: '',
                clientText: '',
                clientTitle: '',
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
