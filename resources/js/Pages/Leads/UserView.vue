<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">User View</h1>
        <!-- <label class="block text-gray-700">Filter</label>
        <select class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="month">Monthly</option>
          <option value="year">Yearly</option>
        </select> -->
        <pagination class="my-6" :links="leads.links" />
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap table-fixed">
                <tr class="text-left font-bold">
                    <th class="px-4 pt-6 pb-4">Name</th>
                    <th class="px-4 pt-6 pb-4">Email</th>
                    <th class="px-4 pt-6 pb-4">Number</th>
                    <th class="px-4 pt-6 pb-4">Status</th>
                    <th class="px-4 pt-6 pb-4">Notes</th>
                    <th class="px-6 pt-6 pb-4">Action</th>
                </tr>
                <tr v-for="lead in filteredList" :key="lead.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t px-4 pt-6 pb-4">
                        {{ lead.lead_name }} {{ lead.lead_last_name }}
                    </td>
                    <td class="border-t px-4 pt-6 pb-4">
                        {{ lead.lead_email }}
                    </td>
                    <td class="border-t px-4 pt-6 pb-4">
                        {{ lead.lead_number }}
                    </td>
                    <td class="border-t px-4 pt-6 pb-4">
                        <div v-if="lead.lead_status == null">
                            None
                        </div>
                        <div v-else>
                            {{ lead.lead_status }}
                        </div>
                    </td>
                    <td class="border-t px-4 pt-6 pb-4 overflow-y-auto">
                        <div v-if="lead.lead_notes == null">
                            None
                        </div>
                        <div v-else>
                            {{ lead.lead_notes }}
                        </div>
                    </td>
                    <td class="border-t w-px px-6 pt-6 pb-4"> 
                        <div class="inline-flex space-x-4">
                            <inertia-link :href="route('leads.destroy')" :data="{ id: lead.id, user: lead.user_id }"> 
                                <icon name="remove" />
                            </inertia-link>
                        </div> 
                    </td>
                </tr>
            </table>
        </div>
        <div class="mt-6">
            <button v-if="!blocked" @click="showModal=true" class="text-red-600 hover:bg-red-700 hover:text-white p-4 rounded" tabindex="-1" type="button">Delete User</button>

            <inertia-link 
                v-else
                :href="route('admin.user.restore', user)" 
                class="text-green-600 hover:bg-green-700 hover:text-white p-4 rounded" 
                tabindex="-1">
                Restore User
            </inertia-link>

            <!-- confirm modal -->
            <t-modal v-model="showModal" header="Delete User">
                Are you sure you want to delete/block this user?
                <template v-slot:footer>
                    <div class="flex justify-between">
                        <inertia-link class="btn-indigo" :href="route('',)">
                            <span>Cancel</span>
                        </inertia-link>
                        <inertia-link class="btn-indigo" :href="route('admin.user.destroy', user)">
                            <span>OK</span>
                        </inertia-link>
                    </div>
                </template>
            </t-modal>
        </div>
    </div>
</template>

<script>
import AdminLayout from '@/Shared/AdminLayout'
import Icon from '@/Shared/Icon'
import TPagination from 'vue-tailwind/dist/t-pagination'
import Pagination from '@/Shared/Pagination'
import TModal from 'vue-tailwind/dist/t-modal'

export default {
  metaInfo: { title: 'Leads View' },
  components: {
    Icon,
    TPagination,
    Pagination,
    TModal,
  },
  layout: AdminLayout,
  props: {
    leads: Object,
    user: String,
    blocked: String,
  },

  data() {
      return {
        filteredList: this.leads.data,
        showModal: false,
      }
  },

  methods: {
    
  },
}
</script>