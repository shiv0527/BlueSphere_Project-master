<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Packages</h1>
        <div class="mb-6 flex justify-between items-right">
            <inertia-link class="btn-indigo" :href="route('admin.package.create')">
                <span>Create</span>
                <span class="hidden md:inline">Package</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Package Name</th>
                    <th class="px-6 pt-6 pb-4">Package Benefits</th>
                    <th class="px-6 pt-6 pb-4">Package Duration</th>
                    <th class="px-6 pt-6 pb-4" colspan="2">Active?</th>
                </tr>
                <tr v-for="packages in packages" :key="packages.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', packages.id)">
                            {{ packages.package_name.toUpperCase() }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', packages.id)" tabindex="-1">
                        <div v-if="packages.package_benefits">
                            {{ packages.package_benefits }}
                        </div>
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', packages.id)" tabindex="-1">
                        {{ packages.package_duration }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', packages.id)" tabindex="-1">
                            {{ packages.is_active }}
                        </inertia-link>
                    </td>
                    
                    <td class="border-t w-px px-4">                            
                        <button class="btn btn-indigo" @click="showModal=true">
                            Delete
                        </button>
                        
                        <!-- confirm modal -->
                        <t-modal v-model="showModal" header="Delete Package">
                            Are you sure you want to delete this package?
                            <template v-slot:footer>
                                <div class="flex justify-between">
                                    <inertia-link class="btn-indigo" :href="route('',)">
                                        <span>Cancel</span>
                                    </inertia-link>
                                    <inertia-link class="btn-indigo" :href="route('package.delete', packages.id)">
                                        <span>OK</span>
                                    </inertia-link>
                                </div>
                            </template>
                        </t-modal>
                    </td>
                </tr>
                <tr v-if="packages.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No package(s) found.</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
import AdminLayout from '@/Shared/AdminLayout'
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

  layout: AdminLayout,
  props: {
    packages: Array,
  },
  methods: {
      
  },
}
</script>