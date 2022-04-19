const Welcome = () => import('../Views/Welcome.vue');
const Registration = () => import('../Views/Registration.vue');
const Login = () => import('../Views/Login.vue');
const Home = () => import('../Views/Home.vue');

export default [

    {
        path: '/',
        component: Welcome,
        name: 'welcome',
    },
    {
        path: '/registration',
        component: Registration,
        name: 'registration',
        meta : {
            guard : 'guest'
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta : {
            guard : 'guest'
        }
    },
    {
        path: '/home',
        component: Home,
        name: 'home',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/home',

    }
];
