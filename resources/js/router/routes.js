const Welcome = () => import('../Views/Welcome.vue');
const Registration = () => import('../Views/Registration.vue');
const Login = () => import('../Views/Login.vue');
const Home = () => import('../Views/Home.vue');
const Articles = () => import('../Views/Articles/List.vue');
const AddArticle = () => import('../Views/Articles/Add.vue');
const EditArticle = () => import('../Views/Articles/Edit.vue');
const ForgotPassword = () => import('../Views/ForgotPassword.vue');
const VerifyEmail = () => import('../Views/VerifyEmail.vue');
const ResetPassword = () => import('../Views/ResetPassword.vue');

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
        path: '/forgot-password',
        component: ForgotPassword,
        name: 'forgot-password',
        meta : {
            guard : 'guest'
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
            guard: 'auth'
        }
    },
    {
        path: '/add-article',
        component: AddArticle,
        name: 'addArticle',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/edit-article/:articleId',
        component: EditArticle,
        name: 'editArticle',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/home',

    }
];
