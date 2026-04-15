import '../css/app.css';
import './bootstrap';

import { createInertiaApp, Link } from '@inertiajs/vue3'; 
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h, onMounted } from 'vue'; 
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import AOS from 'aos';
import 'aos/dist/aos.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
title: (title) => title ? `${title} - FSTI ITK` : 'FSTI ITK',    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ 
            setup() {
                onMounted(() => {
                    AOS.init({
                        duration: 800, 
                        once: true,    
                    });
                });
                return () => h(App, props);
            }
        });

        vueApp.use(plugin)
              .use(ZiggyVue)
              .component('Link', Link) 
              .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});