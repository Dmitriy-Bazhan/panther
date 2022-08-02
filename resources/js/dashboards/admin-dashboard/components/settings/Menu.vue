<template>
    <div>

<!--        <div v-bind:class="[active === 'other' ? 'menu-item-active' :'menu-item']"-->
<!--             v-on:click="showComponent('other')">-->
<!--            <span>{{ $t('other') }}</span>-->
<!--        </div>-->

        <div v-bind:class="[active === 'site_settings' ? 'menu-item-active' :'menu-item']"
             v-on:click="showComponent('site_settings')">
            <span>{{ $t('site_settings') }}</span>
        </div>

        <div v-bind:class="[active === 'time_intervals' ? 'menu-item-active' :'menu-item']"
             v-on:click="showComponent('time_intervals')">
            <span>{{ $t('time_intervals') }}</span>
        </div>

        <div v-bind:class="[active === 'hear_about_us' ? 'menu-item-active' :'menu-item']"
             v-on:click="showComponent('hear_about_us')">
            <span>{{ $t('hear_about_us') }}</span>
        </div>

        <div v-bind:class="[active === 'type_of_learning' ? 'menu-item-active' :'menu-item']"
             v-on:click="showComponent('type_of_learning')">
            <span>{{ $t('type_of_learning') }}</span>
        </div>

        <div v-bind:class="[active === 'mail_template' ? 'menu-item-active' :'menu-item']"
             v-on:click="showComponent('mail_template')">
            <span>{{ $t('mail_template') }}</span>
        </div>

        <div v-bind:class="[active === 'faq' ? 'menu-item-active' :'menu-item']"
             v-on:click="showComponent('faq')">
            <span>{{ $t('faq') }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Menu",
        data() {
            return {
                active: 'site_settings',
            }
        },
        methods: {
            showComponent(component){
                this.active = component;
                this.emitter.emit('show-settings-menu-component', component);
            }
        }
    }
</script>

<style scoped>
    .menu-item-active {
        background: #36e64e;
        padding: 10px;
        border: solid 1px #14991b;
    }

    .menu-item {
        background: #78886c;
        padding: 10px;
        border: solid 1px white;
        cursor: pointer;
    }
</style>
