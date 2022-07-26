<template>
    <div class="pt-menu" :class="{active: isOpen}">
        <button class="pt-btn--round" @click="toggleMenu">
            <i class="fa-solid fa-ellipsis-vertical"></i>
        </button>

        <div class="pt-dropdown--menu" v-show="isOpen">
            <slot>

            </slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "pt-menu",
    data() {
        return {
            isOpen: false
        }
    },
    methods: {
        toggleMenu() {
            let self = this
            setTimeout(function (){
                self.isOpen = !self.isOpen
            },100)
        }
    },
    mounted() {
        let self = this;
        window.addEventListener('click', function (e) {
            let menus = document.querySelectorAll('.pt-menu.active')

            if (self.isOpen && e.target.closest('.pt-menu') == null || menus.length>0 && self.isOpen) {
                self.isOpen = false
            }
            else{
                self.isOpen = false
            }
        })
    }
}
</script>

<style scoped>
    .pt-menu.active .pt-btn--round{
        pointer-events: none;
    }
</style>
