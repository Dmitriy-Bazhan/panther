import * as VueRouter from "vue-router";
import Settings from '../dashboards/admin-dashboard/components/settings/index'
import Dashboard from "../dashboards/admin-dashboard/components/Dashboard";
import Nurses from "../dashboards/admin-dashboard/components/nurses/index";
import Client from '../dashboards/admin-dashboard/components/clients/index';

const routes = [
    {
        path: "/dashboard/admin",
        name: 'AdminDashboard',
        component: Dashboard
    },
    {
        path: "/dashboard/admin/clients",
        name: 'AdminDashboardClients',
        component: Client,
        props: true,
    },
    {
        path: "/dashboard/admin/settings",
        name: 'AdminDashboardSettings',
        component: Settings,
        props: true,
    },
    {
        path: "/dashboard/admin/nurses",
        name: 'AdminDashboardNurses',
        component: Nurses,
        props: true,
    },
];

const router = VueRouter.createRouter({
    routes,
    history: VueRouter.createWebHistory(),
});


export default router;
