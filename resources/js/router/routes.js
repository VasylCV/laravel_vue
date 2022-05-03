const Welcome = () => import('../Views/Welcome.vue');
const Registration = () => import('../Views/Registration.vue');
const Login = () => import('../Views/Login.vue');
const Home = () => import('../Views/Home.vue');
const Articles = () => import('../Views/Articles/List.vue');
const AddArticle = () => import('../Views/Articles/Add.vue');
const EditArticle = () => import('../Views/Articles/Edit.vue');

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
