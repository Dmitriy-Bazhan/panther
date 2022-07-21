<template>
    <div>
        <button class="btn btn-secondary mt-1" @click="openPopup('media')">Open media</button>

        <Modal
            v-model="isOpen"
            :close="closePopup"
        >
            <media :is-popup="true" @close-media="closePopup" @select-media="selectMedia"></media>
        </Modal>
    </div>
</template>

<script>
import MediaPopup from "../../dashboards/admin-dashboard/components/pages/Media";

export default {
    name: "MediaPopup",
    props: ['modelValue'],
    emits: ['update:modelValue'],
    components: {
        'media': MediaPopup
    },
    data(){
        return {
            isOpen: false
        }
    },
    methods: {
        selectMedia(media){
            this.$emit('update:modelValue', media)
        },
        closePopup(id){
            this.isOpen = false
        },
        openPopup(id){
            this.isOpen = true
        },
    }
}
</script>

<style lang="scss" scoped>

</style>
