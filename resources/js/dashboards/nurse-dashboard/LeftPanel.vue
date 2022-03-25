<template>
    <div class="nurse-dashboard-left-panel">
        <h5>
            Left Panel
        </h5>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <router-link :to="{ name: 'NurseDashboard' }">{{ $t('overview') }}</router-link>
            </li>
            <li class="list-group-item">
                <router-link :to="{ name: 'NurseDashboardMessages' }">{{ $t('messages') }}</router-link>
                <span v-if="showAlarmNewMessage" class="alarm-signal blink"></span>
            </li>
            <li class="list-group-item">
                <router-link :to="{ name: 'NurseDashboardRatings' }">{{ $t('ratings') }}</router-link>
            </li>
            <li class="list-group-item">
                <router-link :to="{ name: 'NurseDashboardBookings' }">{{ $t('bookings') }}</router-link>
            </li>
            <li class="list-group-item">
                <router-link :to="{ name: 'NurseDashboardPayments' }">{{ $t('payments') }}</router-link>
            </li>
            <li class="list-group-item">
                <router-link :to="{ name: 'NurseDashboardMyInformation' }">{{ $t('my_information') }}</router-link>
            </li>
            <li class="list-group-item">
                <router-link :to="{ name: 'NurseDashboardHelpEndService' }">{{ $t('help_and_service') }}</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "LeftPanel",
    props: ['showAlarmNewMessage']
}
</script>

<style scoped>
.nurse-dashboard-left-panel {
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
