<template>
    <div class="row mt-2">
        <div class="col-6">
            <h1>Edit Page - {{ $route.params.id }}</h1>
        </div>
        <div class="col-6">
            <button class="btn btn-success" @click.prevent="savePage">Save</button>
        </div>
    </div>
    <textarea v-model="pageData.data"></textarea>
</template>

<script>
export default {
    name: "EditDefaultPage",
    data(){
        return {
            pageData: {
                page: 'about',
                data: false
            },
        }
    },
    mounted() {
        this.getPage();
    },
    methods: {
        savePage() {
            axios.post('/dashboard/admin/save-page/about', {
                'pageData': this.pageData,
                'lang': window.locale,
            })
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
            axios.get('/dashboard/admin/get-page/about' + '?lang=' + window.locale)
                .then((response) => {
                    if(response.data.success){
                        this.pageData = response.data.page;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>

</style>
