<template>
    <div>
        <div class="pt-finder--form-block">
            <div class="pt-finder--form-group" v-show="contact.name">
                <p class="pt-form--label">
                    {{ $t('name') }}
                </p>
                <p class="pt-form--text">
                    {{ contact.name }}
                </p>
            </div>

            <div class="pt-finder--form-group" v-show="contact.email">
                <p class="pt-form--label">
                    {{ $t('email') }}
                </p>
                <p class="pt-form--text">
                    {{ contact.email }}
                </p>
            </div>

            <div class="pt-finder--form-group" v-show="contact.comment">
                <p class="pt-form--label">
                    {{ $t('comment') }}
                </p>
                <p class="pt-form--text">
                    {{ contact.comment }}
                </p>
            </div>

            <div class="pt-finder--form-group">
                <p class="pt-form--label">
                    {{ $t('answer') }}
                </p>
                <pt-textarea v-model="answer" @update:modelValue="newValue => answer = newValue"
                ></pt-textarea>
            </div>
        </div>

        <span class="register-form-error" v-if="error">{{ $t(error) }}</span>

        <button @click.prevent="answerContact()" class="pt-btn--primary pt-sm pt-m-a pt-mt-25">
            {{ $t('answer') }}
        </button>
    </div>
</template>

<script>
export default {
    name: "AnswerContact",
    props: ['contact'],
    data() {
        return {
            answer: '',
            error: false,
        }
    },
    methods: {
        answerContact() {
            //update method in AdminContactsController
            axios.put('/dashboard/admin/get-contacts/' + this.contact.id, {
                answer: this.answer,
            }).then((response) => {
                if (response.data.success) {
                    this.emitter.emit('close-modal');
                } else {
                    this.error = 'empty_answer';
                }
            }).catch((error) => {
                console.log(error);
            });


        }
    }
}
</script>

<style scoped>

</style>
