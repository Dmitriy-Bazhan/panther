import * as VueRouter from "vue-router";
import Settings from '../dashboards/admin-dashboard/components/Settings'
import Dashboard from "../dashboards/admin-dashboard/components/Dashboard";

const routes = [
    {
        path: "/dashboard/admin",
        name: 'AdminDashboard',
        component: Dashboard
    },
    {
        path: "/dashboard/admin/settings",
        name: 'AdminDashboardSettings',
        component: Settings
    },
];

const router = VueRouter.createRouter({
    routes,
    history: VueRouter.createWebHistory(),
});


export default router;
