<template>
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

        <div class="pt-finder--form-group" v-show="contact.phone">
            <p class="pt-form--label">
                {{ $t('phone') }}
            </p>
            <p class="pt-form--text">
                {{ contact.phone }}
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

        <div v-if="contact.answer" class="pt-finder--form-group" v-show="contact.answer">
            <p class="pt-form--label">
                {{ $t('answer') }}
            </p>
            <p class="pt-form--text">
                {{ contact.answer }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: "ShowContact",
    props: ['contact'],
    mounted() {
        this.getContact();
    },
    methods: {
        //set contact status was viewed
        getContact() {
            axios.get('/dashboard/admin/get-contact/' + this.contact.id)
                .then((response) => {
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>
.pt-form--text {
    text-align: left;
}
</style>
