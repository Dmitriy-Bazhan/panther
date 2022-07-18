<template>
    <div class="pt-dropdown" :class="{active: isOpen}">
        <button class="pt-dropdown--btn" @click="toggleMenu" v-if="!href">
            <div class="pt-dropdown--btn-wrapper">
                <pt-icon :type="icon"></pt-icon>
                <div class="pt-dropdown--btn-counter" v-if="!!$slots.counter">
                    <slot name="counter"></slot>
                </div>
            </div>
        </button>
        <router-link
            v-else
            :to="{ name: href }"
            class="pt-dropdown--btn"
        >
            <div class="pt-dropdown--btn-wrapper">
                <pt-icon :type="icon"></pt-icon>
                <div class="pt-dropdown--btn-counter" v-if="!!$slots.counter">
                    <slot name="counter"></slot>
                </div>
            </div>
        </router-link>

        <div class="pt-dropdown--menu" v-if="!!$slots.menu" v-show="isOpen">
            <slot name="menu">

            </slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "pt-dropdown",
    props: ['icon', 'href'],
    data() {
        return {
            isOpen: false
        }
    },
    methods: {
        toggleMenu() {
            if (!!this.$slots.menu) {
                this.isOpen = !this.isOpen
            }
        }
    },
    mounted() {
        let self = this;
        window.addEventListener('click', function (e) {
            if (self.isOpen && e.target.closest('.pt-dropdown') == null) {
                self.isOpen = false
            }
        })
    }
}
</script>

<style scoped>

</style>
