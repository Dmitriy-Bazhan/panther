import * as VueRouter from "vue-router";
import Payments from "../dashboards/admin-dashboard/components/payments/Payments";
import Settings from '../dashboards/admin-dashboard/components/settings/index'
import Dashboard from "../dashboards/admin-dashboard/components/Dashboard";
import Nurses from "../dashboards/admin-dashboard/components/nurses/index";
import Client from '../dashboards/admin-dashboard/components/clients/index';
import Pages from '../dashboards/admin-dashboard/components/pages/Pages';
import EditPage from '../dashboards/admin-dashboard/components/pages/EditPage';
import EditDefaultPage from '../dashboards/admin-dashboard/components/pages/EditDefaultPage';
import TranslationPage from '../dashboards/admin-dashboard/components/translation/Translation';
import Media from '../dashboards/admin-dashboard/components/pages/Media';
import Complaint from '../dashboards/admin-dashboard/components/complaint/index';

const routes = [
    {
        path: "/dashboard/admin",
        name: 'AdminDashboard',
        component: Dashboard,
        props: true,
    },
    {
        path: "/dashboard/admin/payments",
        name: 'AdminDashboardPayments',
        component: Payments,
        props: true,
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
    {
        path: "/dashboard/admin/complaints",
        name: 'AdminDashboardComplaints',
        component: Complaint,
        props: true,
    },
    {
        path: "/dashboard/admin/pages",
        name: 'AdminDashboardPages',
        component: Pages,
        props: true,
    },
    {
        path: "/dashboard/admin/pages/home",
        name: 'AdminDashboardEditPage',
        component: EditPage,
        props: true,
    },
    {
        path: "/dashboard/admin/pages/:id",
        name: 'AdminDashboardEditDefaultPage',
        component: EditDefaultPage,
        props: true,
    },
    {
        path: "/dashboard/admin/translation",
        name: 'AdminDashboardTranslationPage',
        component: TranslationPage,
        props: true,
    },
    {
        path: "/dashboard/admin/media",
        name: 'AdminDashboardMediaPage',
        component: Media,
        props: true,
    },
];

const router = VueRouter.createRouter({
    routes,
    history: VueRouter.createWebHistory(),
});


export default router;
