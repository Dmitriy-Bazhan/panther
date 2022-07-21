import * as VueRouter from "vue-router";
import Home from '../pages/home/Home';
import Login from '../pages/auth/Login';
import StartRegister from '../pages/auth/StartRegister';
import NurseRegister from '../pages/auth/NurseRegister';
import ClientRegister from '../pages/auth/ClientRegister';
import EmailVerify from '../WaitVerify';
import YouWelcome from "../YouWelcome";
import Finder from '../pages/listing/Finder';
import Listing from '../pages/listing/Listing';
import NurseProfile from '../pages/listing/NurseProfile';
import Booking from '../pages/booking/Booking';
import SendBooking from "../SendBooking";
import BookingVerify from "../BookingVerify";
import BookingNotExists from "../BookingNotExists";

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
        path: "/booking-not-exists",
        component: BookingNotExists
    },
    {
        path: "/finder",
        name: 'Finder',
        component: Finder,
        props: true,
    },
    {
        path: "/listing",
        name: 'Listing',
        component: Listing,
        props: true,
    },
    {
        path: '/nurse/:id',
        component: NurseProfile,
        children: [
            { path: '', component: NurseProfile },
        ],
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
