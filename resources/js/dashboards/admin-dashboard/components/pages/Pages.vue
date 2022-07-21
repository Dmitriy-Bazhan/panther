<template>
    <div class="pt-admin--pages">
        <h1>Pages</h1>

        <ul class="pt-admin--pages-list">
            <li class="pt-admin--pages-list--item">
                <router-link :to="{ name : 'AdminDashboardEditPage', params: { id: 'home' } }">Home</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "Pages"
}
</script>

<style scoped>

</style>
