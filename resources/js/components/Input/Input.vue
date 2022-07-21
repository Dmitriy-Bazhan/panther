<template>
    <div class="pt-input">
        <div class="pt-input--icon" v-show="icon">
            <pt-icon :type="icon"></pt-icon>
        </div>
        <input :type="type" :placeholder="placeholder" :disabled="disabled" :value="modelValue" @input="update">
        <div class="pt-input--box"></div>
        <div class="pt-input--show" v-if="type === 'password'" @click="showPassword" :class="{active: isPasswordShow}">
            <pt-icon type="eye"></pt-icon>
        </div>
    </div>
</template>

<script>
export default {
    name: "Input",
    props: ['modelValue', 'type', 'placeholder', 'icon', 'disabled'],
    emits: ['update:modelValue'],
    data(){
        return {
            isPasswordShow: false
        }
    },
    methods: {
        update(e){
            this.$emit("update:modelValue", e.target.value);
        },
        showPassword(e){
            let input = this.$el.querySelector('input')
            if(input.type === 'text'){
                input.type = 'password'
                this.isPasswordShow = false
            }
            else{
                input.type = 'text'
                this.isPasswordShow = true
            }
        }
    }
}
</script>

<style scoped>

</style>
