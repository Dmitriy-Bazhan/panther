<template>
    <ul class="pt-dashboard--menu">
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'AdminDashboard' }">
                <pt-icon type="overview"></pt-icon>
                Dashboard
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'AdminDashboardClients' }">
                <pt-icon type="overview"></pt-icon>
                Clients
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'AdminDashboardNurses' }">
                <pt-icon type="overview"></pt-icon>
                Nurses
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'AdminDashboardComplaints' }">
                <pt-icon type="overview"></pt-icon>
                Complaints
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'AdminDashboardSettings' }">
                <pt-icon type="overview"></pt-icon>
                Settings
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'AdminDashboardPages' }">
                <pt-icon type="overview"></pt-icon>
                Pages
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'AdminDashboardTranslationPage' }">
                <pt-icon type="overview"></pt-icon>
                Translation
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'AdminDashboardMediaPage' }">
                <pt-icon type="overview"></pt-icon>
                Media
            </router-link>
        </li>
    </ul>
</template>

<script>
export default {
    name: "LeftPanel"
}
</script>

<style scoped>

</style>
