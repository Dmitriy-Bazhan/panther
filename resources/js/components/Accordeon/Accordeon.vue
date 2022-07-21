<template>
    <transition name="faq"
                v-on:before-enter="beforeEnter" v-on:enter="enter"
                v-on:before-leave="beforeLeave" v-on:leave="leave">
        <slot></slot>
    </transition>
</template>

<script>
    export default {
        name: "accordeon",
        methods: {
            beforeEnter: function(el) {
                el.style.height = '0';
            },
            enter: function(el) {
                el.style.height = el.scrollHeight + 'px';
            },
            beforeLeave: function(el) {
                el.style.height = el.scrollHeight + 'px';
            },
            leave: function(el) {
                el.style.height = '0';
                el.style.padding = '0';
            }
        }
    }
</script>

<style scoped>

</style>
