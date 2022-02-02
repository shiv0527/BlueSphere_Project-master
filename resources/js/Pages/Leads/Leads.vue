<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">My Leads</h1>
        <pagination class="my-6" :links="sample.links" />
        <div v-if="sample.length === 0">
            <h2 class="mb-8 font-bold text-2xl">No Leads found.</h2>
        </div>
        <div v-else class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap table-fixed">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Lead Name</th>
                    <th class="px-6 pt-6 pb-4">Lead Email</th> 
                    <!-- <th class="px-6 pt-6 pb-4">Lead Description</th>
                    <th class="px-6 pt-6 pb-4">Lead Company Name</th> -->
                    <!-- <th class="px-6 pt-6 pb-4">Notepad</th> -->
                    <th class="px-6 pt-6 pb-4">Status</th>
                    <th class="px-6 pt-6 pb-4">Action</th>
                </tr>
                <tr v-for="sam in sample.data" :key="sam.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t px-6 pt-6 pb-4">
                            {{ sam.lead_name }} {{ sam.lead_last_name }}
                        </td>
                        <td class="border-t px-6 pt-6 pb-4">
                            {{ sam.lead_email }}
                        </td>

                        <!-- <td class="border-t px-6 pt-6 pb-4 overflow-y-auto">
                            {{ sam.lead_description }} 
                        </td>
                        <td class="border-t px-6 pt-6 pb-4">
                            {{ sam.lead_company_name }}
                        </td> -->
                        <!-- <td class="border-t px-6 pt-6 pb-4"> -->
                            <!-- notepad -->
                        <!-- </td> -->
                        <td class="border-t px-6 pt-6 pb-4">
                            <!-- dropdown list - contacted, converted, not contacted, closed -->
                            <div v-if="sam.lead_status === null">
                                <span>None</span>
                            </div>
                            <div v-else>
                                {{ sam.lead_status }}
                            </div>
                        </td>
                        <td class="border-t w-px px-6 pt-6 pb-4"> 
                            <div class="inline-flex space-x-4">
                                <inertia-link :href="route('leads.update')" :data="{ id: sam.id }">
                                    <icon name="update" />
                                </inertia-link>
                                <!-- <inertia-link :href="route('leads.destroy', sam.id)">
                                    <icon name="remove" />
                                </inertia-link> -->
                            </div> 
                        </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    import Layout from '@/Shared/Layout'
    import Icon from '@/Shared/Icon'
    import Pagination from '@/Shared/Pagination'

    export default {
        metaInfo: { title: 'Leads' },
        layout: Layout,
        components: {
            Icon,
            Pagination,
        },
        props: {
            sample: Object,
        },

        // data() {
        //     return {
        //         search: '',
        //         form: this.$inertia.form({
                    
        //         }),
        //     }
        // },

        // methods: {
        //     store() { 
        //     },
        // },
    }
</script>

