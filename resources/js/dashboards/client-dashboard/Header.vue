<template>
    <div class="pt-dashboard--header">
        <div class="pt-dashboard--header-left">
            <a href="/" class="pt-dashboard--header-logo">
                <img src="/images/logo.png" alt="logo">
            </a>
        </div>
        <div class="pt-dashboard--header-right">
            <h3 class="pt-dashboard--header-title">
                {{$route.meta.title}}
            </h3>
            <div class="pt-dashboard--header-block">
                <pt-dropdown icon="email" href="ClientDashboardMessages">
                    <template v-slot:counter>54</template>
                </pt-dropdown>
            </div>
            <div class="pt-dashboard--header-block">
                <pt-dropdown icon="bell">
                    <template v-slot:menu>
                        <div class="pt-dropdown--menu-item">
                            <div class="pt-notification">
                                <div class="pt-notification--number">
                                    1
                                </div>
                                <div class="pt-notification--body">
                                    <p class="pt-notification--date">
                                        22.03.2022, 14:45
                                    </p>
                                    <p class="pt-notification--title">
                                        New Notification
                                    </p>
                                </div>
                                <button class="pt-notification--close">
                                    <pt-icon type="cross"></pt-icon>
                                </button>
                            </div>
                        </div>
                    </template>
                </pt-dropdown>
            </div>
            <div class="pt-dashboard--header-block">
                <localization-component></localization-component>
            </div>
            <div class="pt-dashboard--header-block">
                <div class="pt-dashboard--header-block--inner">
                    <logout-component></logout-component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Localization from "../../pages/components/Localization";
import Logout from "../../pages/components/Logout";

export default {
name: "Header",
    components : {
        'localization-component' : Localization,
        'logout-component' : Logout,
    },
    mounted() {
        console.log('tetttt')
    },
    methods: {
        getNotice() {
            axios.get('get-notification/' + this.user.id)
                .then((response) => {
                    console.log(response)
                    if (response.data.success) {

                    }
                }).catch((error) => {
                console.log(error)
            });
        },
    }
}
</script>

<style scoped>
.client-dashboard-header {
    padding: 5px;
    background: #9dc3fc;
}
</style>
