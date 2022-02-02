<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">My Subscribed Package</h1>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Package Name</th>
                    <th class="px-6 pt-6 pb-4">Package Benefits</th>
                    <th class="px-6 pt-6 pb-4">Package Duration</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Package Price</th>
                    <th class="px-6 pt-6 pb-4">Action</th>
                </tr>
                <tr v-for="userpack in userpack" :key="userpack.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', )">
                            {{ userpack.package_name }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', )">
                            {{ userpack.package_benefits }} Leads
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', )">
                            {{ userpack.package_duration }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', )">
                            ${{ userpack.price }}
                        </inertia-link>
                    </td>
                    <td class="border-t" colspan="2">
                        <button class="btn btn-indigo" @click="showModal=true">
                            Cancel Subscription
                        </button>

                        <!-- confirmation  -->
                        <t-modal v-model="showModal" header="Delete Package">
                            Are you sure you want to cancel this subscription?
                            <template v-slot:footer>
                                <div class="flex justify-between">
                                    <inertia-link class="btn-indigo" :href="route('',)">
                                        <span>Cancel</span>
                                    </inertia-link>
                                    <inertia-link class="btn-indigo" :href="route('subscribe.cancel', userpack.subscription_id)">
                                        <span>OK</span>
                                    </inertia-link>
                                </div>
                            </template>
                        </t-modal>
                    </td>
                </tr>
            </table>
        </div>

        <h1 class="mb-8 mt-8 font-bold text-3xl">Other Packages</h1>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Package Name</th>
                    <th class="px-6 pt-6 pb-4">Package Benefits</th>
                    <th class="px-6 pt-6 pb-4">Package Duration</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Package Price</th>
                    <th class="px-6 pt-6 pb-4">Buy Now</th>
                </tr>
                <tr v-for="allpack in allpack" :key="allpack.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', )">
                            {{ allpack.package_name.toUpperCase() }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', )">
                            {{ allpack.package_benefits }} Leads
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', )">
                            {{ allpack.package_duration }}
                        </inertia-link>
                    </td>
                    <td class="border-t" colspan="2">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', )">
                            ${{ allpack.price }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="btn-indigo" :href="route('payment')" :data="{ id: allpack.price_id }">
                            <span>Buy Subscription</span>
                        </inertia-link>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import Icon from '@/Shared/Icon'
import TModal from 'vue-tailwind/dist/t-modal'

export default {
  metaInfo: { title: 'Packages' },
  components: {
    Icon,
    TModal,
  },

  data() {
      return {
          showModal: false,
      }
  },

  layout: Layout,
  props: {
    userpack: Array,
    allpack: Array,
  }
}
</script>