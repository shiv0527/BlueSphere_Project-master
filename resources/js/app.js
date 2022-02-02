import Vue from 'vue'
import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress/src'
import VueCardFormat from 'vue-credit-card-validation'
import VueTailwind from 'vue-tailwind'
import TModal from 'vue-tailwind/dist/t-modal'

Vue.use(VueCardFormat);
Vue.config.productionTip = false
Vue.mixin({ methods: { route: window.route } })
Vue.use(plugin)
Vue.use(PortalVue)
Vue.use(VueMeta)
Vue.use(VueTailwind)

const settings = {
  't-modal': {
    component: TModal,
    props: {
      classes: 'block w-full px-3 py-2 text-black transition duration-100 ease-in-out bg-white border border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed',
      // ...More settings
    }
  },
}

Vue.use(VueTailwind, settings)

InertiaProgress.init()

const el = document.getElementById('app')

new Vue({
  metaInfo: {
    titleTemplate: title => (title ? `${title} - Ping CRM` : 'Ping CRM'),
  },
  render: h =>
    h(App, {
      props: {
        initialPage: JSON.parse(el.dataset.page),
        resolveComponent: name => require(`./Pages/${name}`).default,
      },
    }),
}).$mount(el)
