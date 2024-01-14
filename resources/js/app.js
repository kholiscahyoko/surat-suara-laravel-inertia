import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
import Layout from './Shared/Layout.vue';

createInertiaApp({
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
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component("Link", Link)
      .component("Head", Head)
      .mount(el)
  },
  title: title => `My App - ${title}`
})