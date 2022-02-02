<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Reports</h1>
<!--     <div v-for="u in users" :key="u" class="mt-6">
      <t-card header="User - Lead status">
        <p>user id: {{ u.user_id }} </p> 

        <p>{{ u.lead_status }} : {{ u.status_count }}</p>
        <template v-slot:footer>     
        </template>
      </t-card>
    </div> -->
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4">User ID</th>
            <th class="px-6 pt-6 pb-4">Status</th>
            <th class="px-6 pt-6 pb-4">Count</th>
            <!-- <th class="px-6 pt-6 pb-4" colspan="2">Package Price</th>
            <th class="px-6 pt-6 pb-4">Action</th> -->
        </tr>
        <tr v-for="u in users" :key="u.user_id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
                <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', )">
                    {{ u.user_id }}
                </inertia-link>
            </td>
            <td class="border-t">
                <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', )">
                    {{ u.lead_status }}
                </inertia-link>
            </td>
            <td class="border-t">
                <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('', )">
                    {{ u.status_count }}
                </inertia-link>
            </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import AdminLayout from '@/Shared/AdminLayout'
import TCard from 'vue-tailwind/dist/t-card'

export default {
  metaInfo: { title: 'Reports' },
  layout: AdminLayout,
  components: {
    TCard,
  },

  props: {
    users: Array,
  }
}
</script>
