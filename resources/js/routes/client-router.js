import * as VueRouter from "vue-router";
import Overview from "../dashboards/client-dashboard/components/Overview";
import Messages from "../dashboards/components/messages/Messages";
import Ratings from "../dashboards/client-dashboard/components/Ratings";
import Bookings from "../dashboards/client-dashboard/components/bookings/Booking";
import Payments from "../dashboards/client-dashboard/components/payments/index";
import MyInformation from "../dashboards/client-dashboard/components/my-information/MyInformation";
import HelpAndService from "../dashboards/components/HelpAndService";

const routes = [
    {
        path: "/dashboard/client",
        name: 'ClientDashboard',
        component: Overview,
        meta: {title: 'Overview', showInMenu: true},
    },
    {
        path: "/dashboard/client/messages",
        name: 'ClientDashboardMessages',
        component: Messages,
        meta: {title: 'Messages', showInMenu: true},
        props: true,
    },
    {
        path: "/dashboard/client/ratings",
        name: 'ClientDashboardRatings',
        meta: {title: 'Ratings', showInMenu: true},
        component: Ratings
    },
    {
        path: "/dashboard/client/bookings",
        name: 'ClientDashboardBookings',
        meta: {title: 'Bookings', showInMenu: true},
        component: Bookings,
        props: true,
    },
    {
        path: "/dashboard/client-bookings/:id",
        name: 'ClientDashboardBookingsWithId',
        component: Bookings,
        meta: {title: 'Bookings'},
        props: true,
    },
    {
        path: "/dashboard/client/payments",
        name: 'ClientDashboardPayments',
        meta: {title: 'Payments', showInMenu: true},
        component: Payments
    },
    {
        path: "/dashboard/client/my-information",
        name: 'ClientDashboardMyInformation',
        component: MyInformation,
        meta: {title: 'My information', showInMenu: true},
        props: true,
    },
    {
        path: "/dashboard/client/help-end-service",
        name: 'ClientDashboardHelpEndService',
        component: HelpAndService,
        meta: {title: 'Help and service', showInMenu: true},
    },

];

const router = VueRouter.createRouter({
    routes,
    history: VueRouter.createWebHistory(),
});


export default router;
