import * as VueRouter from "vue-router";
import Overview from "../dashboards/client-dashboard/components/Overview";
import Messages from "../dashboards/client-dashboard/components/messages/index";
import Ratings from "../dashboards/client-dashboard/components/Ratings";
import Bookings from "../dashboards/client-dashboard/components/bookings/index";
import Payments from "../dashboards/client-dashboard/components/Payments";
import MyInformation from "../dashboards/client-dashboard/components/my-information/index";
import HelpAndService from "../dashboards/client-dashboard/components/HelpAndService";

const routes = [
    {
        path: "/dashboard/client",
        name: 'ClientDashboard',
        component: Overview
    },
    {
        path: "/dashboard/client/messages",
        name: 'ClientDashboardMessages',
        component: Messages,
        props: true,
    },
    {
        path: "/dashboard/client/ratings",
        name: 'ClientDashboardRatings',
        component: Ratings
    },
    {
        path: "/dashboard/client/bookings",
        name: 'ClientDashboardBookings',
        component: Bookings,
        props: true,
    },
    {
        path: "/dashboard/client-bookings/:id",
        name: 'ClientDashboardBookingsWithId',
        component: Bookings,
        props: true,
    },
    {
        path: "/dashboard/client/payments",
        name: 'ClientDashboardPayments',
        component: Payments
    },
    {
        path: "/dashboard/client/my-information",
        name: 'ClientDashboardMyInformation',
        component: MyInformation,
        props: true,
    },
    {
        path: "/dashboard/client/help-end-service",
        name: 'ClientDashboardHelpEndService',
        component: HelpAndService
    },

];

const router = VueRouter.createRouter({
    routes,
    history: VueRouter.createWebHistory(),
});


export default router;
