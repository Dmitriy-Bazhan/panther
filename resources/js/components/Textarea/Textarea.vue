<template>
    <div class="pt-textarea">
        <textarea name="text" :placeholder="placeholder" :disabled="disabled" :value="modelValue" @input="update"></textarea>
        <div class="pt-textarea--box"></div>
    </div>
</template>

<script>
export default {
    name: "Textarea",
    props: ['modelValue', 'placeholder', 'disabled'],
    emits: ['update:modelValue'],
    data(){
        return {

        }
    },
    methods: {
        update(e){
            this.$emit("update:modelValue", e.target.value);
        },
    }
}
</script>

<style scoped>

</style>
