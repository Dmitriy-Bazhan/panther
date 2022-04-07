import * as VueRouter from "vue-router";
import Test from '../pages/test';
import Home from '../pages/home/Home';
import Login from '../pages/auth/Login';
import StartRegister from '../pages/auth/StartRegister';
import NurseRegister from '../pages/auth/NurseRegister';
import ClientRegister from '../pages/auth/ClientRegister';
import EmailVerify from '../WaitVerify';
import YouWelcome from "../YouWelcome";
import Listing from '../pages/listing/index';
import Booking from '../pages/booking/index';
import SendBooking from "../SendBooking";
import BookingVerify from "../BookingVerify";

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
        path: "/booking",
        component: Booking,
        props: true,
    },
    {
        path: "/booking/:id",
        component: Booking,
        props: true,
    },
    {
        path: "/register",
        component: StartRegister,
        props: true,
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
        path: "/booking-verify",
        component: BookingVerify
    },
    {
        path: "/test",
        component: Test
    },
    {
        path: "/listing",
        name: 'Listing',
        component: Listing,
        props: true,
    },
    {
        path: "/send-booking-message",
        component: SendBooking
    },
];

const router = VueRouter.createRouter({
    routes,
    history: VueRouter.createWebHistory(),
});


export default router;
