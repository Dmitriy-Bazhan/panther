<template>
    <div class="admin-dashboard-left-panel">
        <h5>
            Left Panel
        </h5>

        <ul class="list-group list-group-flush">
            <li class="list-group-item"><router-link :to="{ name : 'AdminDashboard' }">Dashboard</router-link></li>
            <li class="list-group-item">Clients</li>
            <li class="list-group-item"><router-link :to="{ name : 'AdminDashboardNurses' }">Nurses</router-link></li>
            <li class="list-group-item"><router-link :to="{ name : 'AdminDashboardSettings' }">Settings</router-link></li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "LeftPanel"
}
</script>

<style scoped>
.admin-dashboard-left-panel {
    height: 100%;
    background: #d9d9d9;
    min-height: calc(100vh - 50px);
}
.list-group-item {
    background: #d9d9d9;
}

.list-group-item:hover {
    background: #f8f7f7;
}
</style>
