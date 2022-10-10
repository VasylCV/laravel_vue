const Welcome = () => import('../Views/Welcome.vue');
const Registration = () => import('../Views/Auth/Registration.vue');
const Login = () => import('../Views/Auth/Login.vue');
const Home = () => import('../Views/Home.vue');
const Articles = () => import('../Views/Articles/List.vue');
const AddArticle = () => import('../Views/Articles/Add.vue');
const EditArticle = () => import('../Views/Articles/Edit.vue');
const ForgotPassword = () => import('../Views/Auth/ForgotPassword.vue');
const VerifyEmail = () => import('../Views/Auth/VerifyEmail.vue');
const ResetPassword = () => import('../Views/Auth/ResetPassword.vue');
const Roles = () => import('../Views/Roles/List.vue');
const Constants = () => import('./routerConstants.js');

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
            guard : Constants.GUARD_GUEST
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta : {
            guard : Constants.GUARD_GUEST
        }
    },
    {
        path: '/forgot-password',
        component: ForgotPassword,
        name: 'forgot-password',
        meta : {
            guard : Constants.GUARD_GUEST
        }
    },
    {
        path: '/reset-password/:token',
        props: route => ({
            token: route.params.token,
            email: route.query.email
        }),
        component: ResetPassword,
        name: 'reset-password',
        meta : {
            guard : Constants.GUARD_GUEST
        }
    },
    {
        path: '/home',
        component: Home,
        name: 'home',
        meta: {
            guard: Constants.GUARD_AUTH
        }
    },
    {
        path: '/verify-email/:id/:hash',
        props: route => ({
            id: route.params.id,
            hash: route.params.hash
        }),
        component: VerifyEmail,
        name: 'verify-email',
    },
    {
        path: '/articles',
        component: Articles,
        name: 'articles',
        meta: {
            guard: Constants.GUARD_AUTH
        }
    },
    {
        path: '/add-article',
        component: AddArticle,
        name: 'addArticle',
        meta: {
            guard: Constants.GUARD_AUTH
        }
    },
    {
        path: '/edit-article/:articleId',
        component: EditArticle,
        name: 'editArticle',
        meta: {
            guard: Constants.GUARD_AUTH
        }
    },
    {
        path: '/roles',
        component: Roles,
        name: 'roles',
        meta: {
            guard: Constants.GUARD_AUTH,
            requiredRoles: [Constants.ROLE_ADMIN]
        }
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/home',

    }
];
