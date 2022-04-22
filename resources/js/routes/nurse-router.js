import * as VueRouter from "vue-router";
import Overview from "../dashboards/nurse-dashboard/components/overview/index";
import Messages from "../dashboards/nurse-dashboard/components/messages/index";
import Ratings from "../dashboards/nurse-dashboard/components/Ratings";
import Bookings from "../dashboards/nurse-dashboard/components/bookings/index";
import Payments from "../dashboards/nurse-dashboard/components/payments/index";
import MyInformation from "../dashboards/nurse-dashboard/components/my-information/MyInformation";
import HelpAndService from "../dashboards/nurse-dashboard/components/HelpAndService";

const routes = [
    {
        path: "/dashboard/nurse",
        name: 'NurseDashboard',
        component: Overview,
        props: true,
    },
    {
        path: "/dashboard/nurse/messages",
        name: 'NurseDashboardMessages',
        component: Messages,
        props: true,
    },
    {
        path: "/dashboard/nurse/ratings",
        name: 'NurseDashboardRatings',
        component: Ratings
    },
    {
        path: "/dashboard/nurse/bookings",
        name: 'NurseDashboardBookings',
        component: Bookings
    },
    {
        path: "/dashboard/nurse/payments",
        name: 'NurseDashboardPayments',
        component: Payments,
        props: true,
    },
    {
        path: "/dashboard/nurse/my-information/",
        name: 'NurseDashboardMyInformation',
        component: MyInformation,
        props: true,
    },
    {
        path: "/dashboard/nurse/help-end-service",
        name: 'NurseDashboardHelpEndService',
        component: HelpAndService
    },

];

const router = VueRouter.createRouter({
    routes,
    history: VueRouter.createWebHistory(),
});


export default router;
