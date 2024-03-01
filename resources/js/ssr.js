import { createSSRApp, h } from 'vue'
import createServer from '@inertiajs/vue3/server'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
import Layout from './Shared/Layout.vue';

createServer (page =>
    createInertiaApp({
        page,
        render: renderToString,
        progress: {
          // The delay after which the progress bar will appear, in milliseconds...
          delay: 250,
      
          // Whether to include the default NProgress styles...
          includeCSS: false,
      
          // Whether the NProgress spinner will be shown...
          showSpinner: true,
        },
        resolve: async name => {
          let page = (await import(`./Pages/${name}.vue`)).default;
          page.layout ??= Layout;
          return page;
        },
        setup({ el, App, props, plugin }) {
          const vueApp = createSSRApp({ render: () => h(App, props) })
            .use(plugin)
            .component("Link", Link);
          vueApp.config.globalProperties.$slugify = function(str){
            return String(str)
              .normalize('NFKD') // split accented characters into their base characters and diacritical marks
              .replace(/[\u0300-\u036f]/g, '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
              .trim() // trim leading or trailing whitespace
              .toLowerCase() // convert to lowercase
              .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
              .replace(/\s+/g, '-') // replace spaces with hyphens
              .replace(/-+/g, '-'); // remove consecutive hyphens
          };
          vueApp.config.globalProperties.$setUrl = function(path){
            return `${import.meta.env.VITE_APP_URL??''}${path}`
          };
      
          // Provide the $setUrl function to components
          vueApp.provide('$setUrl', vueApp.config.globalProperties.$setUrl);
      
        //   vueApp.mount(el);
          return vueApp;
        },
        title: title => `${import.meta.env.VITE_APP_NAME} - ${title}`
    })
)
