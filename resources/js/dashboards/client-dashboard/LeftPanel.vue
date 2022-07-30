<template>
    <ul class="pt-dashboard--menu">
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'ClientDashboard' }">
                <pt-icon type="overview"></pt-icon>
                {{ $t('overview') }}
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'ClientDashboardMessages' }">
                <pt-icon type="messages"></pt-icon>
                {{ $t('messages') }}
                <span v-if="showAlarmNewMessage" class="alarm-signal blink"></span>
            </router-link>
        </li>
<!--        <li class="pt-dashboard&#45;&#45;menu-item">-->
<!--            <router-link :to="{ name: 'ClientDashboardRatings' }">-->
<!--                <pt-icon type="star"></pt-icon>-->
<!--                {{ $t('ratings') }}-->
<!--            </router-link>-->
<!--        </li>-->
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'ClientDashboardBookings' }">
                <pt-icon type="calendar"></pt-icon>
                {{ $t('bookings') }}
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'ClientDashboardPayments' }">
                <pt-icon type="card"></pt-icon>
                {{ $t('payments') }}
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'ClientDashboardMyInformation' }">
                <pt-icon type="user"></pt-icon>
                {{ $t('my_information') }}
            </router-link>
        </li>
        <li class="pt-dashboard--menu-item">
            <router-link :to="{ name: 'ClientDashboardHelpEndService' }">
                <pt-icon type="help"></pt-icon>
                {{ $t('help_and_service') }}
            </router-link>
        </li>
    </ul>
</template>

<script>
export default {
    name: "LeftPanel",
    props: ['showAlarmNewMessage']
}
</script>

<style scoped>

</style>
