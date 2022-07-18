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
        meta: {title: 'Overview'},
        props: true,
    },
    {
        path: "/dashboard/nurse/messages",
        name: 'NurseDashboardMessages',
        component: Messages,
        meta: {title: 'Messages'},
        props: true,
    },
    {
        path: "/dashboard/nurse/ratings",
        name: 'NurseDashboardRatings',
        component: Ratings,
        meta: {title: 'Ratings'},
    },
    {
        path: "/dashboard/nurse/bookings",
        name: 'NurseDashboardBookings',
        component: Bookings,
        meta: {title: 'Bookings'},
    },
    {
        path: "/dashboard/nurse/payments",
        name: 'NurseDashboardPayments',
        component: Payments,
        meta: {title: 'Payments'},
        props: true,
    },
    {
        path: "/dashboard/nurse/my-information/",
        name: 'NurseDashboardMyInformation',
        component: MyInformation,
        meta: {title: 'My information'},
        props: true,
    },
    {
        path: "/dashboard/nurse/help-end-service",
        name: 'NurseDashboardHelpEndService',
        component: HelpAndService,
        meta: {title: 'Help and service'},
    },

];

const router = VueRouter.createRouter({
    routes,
    history: VueRouter.createWebHistory(),
});


export default router;
