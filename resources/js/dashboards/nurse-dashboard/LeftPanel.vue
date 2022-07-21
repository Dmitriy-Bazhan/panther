<template>
    <ul class="pt-dashboard--menu">
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'NurseDashboard' }">
                <pt-icon type="overview"></pt-icon>
                {{ $t('overview') }}
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'NurseDashboardMessages' }">
                <pt-icon type="messages"></pt-icon>
                {{ $t('messages') }}
                <span v-if="showAlarmNewMessage" class="alarm-signal blink"></span>
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'NurseDashboardRatings' }">
                <pt-icon type="star"></pt-icon>
                {{ $t('ratings') }}
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'NurseDashboardBookings' }">
                <pt-icon type="calendar"></pt-icon>
                {{ $t('bookings') }}
                <span v-if="showAlarmHaveNotApproved" class="alarm-signal blink"></span>
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'NurseDashboardPayments' }">
                <pt-icon type="card"></pt-icon>
                {{ $t('payments') }}
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'NurseDashboardMyInformation' }">
                <pt-icon type="user"></pt-icon>
                {{ $t('my_information') }}
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'NurseDashboardHelpEndService' }">
                <pt-icon type="help"></pt-icon>
                {{ $t('help_and_service') }}
            </router-link>
        </li>
    </ul>
</template>

<script>
export default {
    name: "LeftPanel",
    props: ['showAlarmNewMessage', 'showAlarmHaveNotApproved']
}
</script>

<style scoped>

</style>
