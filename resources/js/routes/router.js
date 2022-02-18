import * as VueRouter from "vue-router";
import Test from '../pages/test';
import Home from '../pages/home/Home';
import Login from '../pages/auth/Login';
import StartRegister from '../pages/auth/StartRegister';
import NurseRegister from '../pages/auth/NurseRegister';
import ClientRegister from '../pages/auth/ClientRegister';
import EmailVerify from '../WaitVerify';
import YouWelcome from "../YouWelcome";

const routes = [
    {
        path: "/",
        component: Home
    },
    {
        path: "/login",
        component: Login
    },
    {
        path: "/register",
        component: StartRegister
    },
    {
        path: "/nurse-register",
        component: NurseRegister
    },
    {
        path: "/client-register",
        component: ClientRegister
    },
    {
        path: "/email/verify",
        component: EmailVerify
    },
    {
        path: "/you-welcome",
        component: YouWelcome
    },
    {
        path: "/test",
        component: Test
    }
];

const router = VueRouter.createRouter({
    routes,
    history: VueRouter.createWebHistory(),
});


export default router;
