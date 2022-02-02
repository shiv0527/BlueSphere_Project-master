<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Client Leads View</h1>
        
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap table-fixed">
                <tr class="text-left font-bold">
                    <th class="px-4 pt-6 pb-4">Name</th>
                    <th class="px-4 pt-6 pb-4">Email</th>
                    <!-- <th class="px-4 pt-6 pb-4" colspan="2">Description</th>
                    <th class="px-4 pt-6 pb-4">Company</th> -->
                    <th class="px-4 pt-6 pb-4">Number</th>
                    <th class="px-4 pt-6 pb-4">Status</th>
                </tr>
                <tr v-for="lead in leads" :key="lead.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t px-4 pt-6 pb-4">
                        {{ lead.lead_name }} {{ lead.lead_last_name }}
                    </td>
                    <!-- <td class="border-t px-4 pt-6 pb-4 overflow-y-auto" colspan="2">
                        {{ lead.lead_description }}
                    </td>
                    <td class="border-t px-4 pt-6 pb-4">
                        {{ lead.lead_company_name }}
                    </td> -->
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
                    
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
import AdminLayout from '@/Shared/AdminLayout'
import Icon from '@/Shared/Icon'

export default {
  metaInfo: { title: 'Leads View' },
  components: {
    Icon,
  },
  layout: AdminLayout,
  props: {
    leads: Array
  },

  data() {
      return {
        
      }
  },

  methods: {
    
  },
}
</script>