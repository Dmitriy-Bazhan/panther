<template>
    <form action="" @submit.prevent="startSearch" class="pt-search">
        <input type="text" class="pt-search--input" v-model="search" placeholder="Suchen">
        <button class="pt-search--btn">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>

        <button class="pt-search--btn pt-search--btn_remove" @click.prevent="clear" v-if="search.length > 0 && searchStart">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </form>
</template>

<script>
export default {
    name: "Search",
    data(){
        return {
            search: '',
            searchStart: false,
        }
    },
    watch: {
        search(e){
            if(e.length === 0){
                this.startSearch()
            }
        }
    },
    methods: {
        startSearch(){
            this.emitter.emit('pt-search', this.search);
            if(this.search === 0){
                this.searchStart = false
            }
            else{
                this.searchStart = true
            }
        },
        clear(){
            this.search = ''
            this.startSearch()
        }
    }
}
</script>

<style scoped>

</style>
