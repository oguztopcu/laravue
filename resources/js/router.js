import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'home',
        meta: {
            isAuthRequired: true
        },
        component: () => import('./pages/home.vue')
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('./pages/login.vue')
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('./pages/register.vue')
    },
    {
        path: '/api-keys',
        name: 'apiKeys',
        component: () => import('./pages/apiKeys.vue'),
        meta: {
            isAuthRequired: true
        }
    },
    {
        path: '/store',
        name: 'store',
        component: () => import('./pages/store/index.vue'),
        meta: {
            isAuthRequired: true
        }
    },
    {
        path: '/store/create',
        name: 'store.create',
        component: () => import('./pages/store/create.vue')
    },
    {
        path: '/store/:keyId',
        name: 'store.edit',
        component: () => import('./pages/store/edit.vue')
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import('./pages/notFound.vue')
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach(async (to, from, next) => {
    if (to.name === 'login') {
        next();
        return;
    }

    if (! to.meta.isAuthRequired) {
        next();
    }

    if (! localStorage.getItem('token')) {
        next({ name: 'login' });
    }

    try {
        const token = localStorage.getItem('token');
        let response = await window.axios.post('/auth/check', {}, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        });

        if (! response.data.user) {
            localStorage.removeItem('token');
            next({ name: 'login' });
        }

        next();
    } catch (err) {
        localStorage.removeItem('token');
        next({ name: 'login' });
    }
})

export default router;