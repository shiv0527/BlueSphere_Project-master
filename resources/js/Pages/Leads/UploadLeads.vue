<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Customers</h1>
        <div class="p-10">
            <div class="bg-white flex items-center rounded-full shadow-xl h-16">
                <input v-model="search" class="rounded-l-full w-full pl-4 text-gray-700 leading-tight focus:outline-none" id="search" type="text" placeholder="Search by first name">

                <div class="p-4">
                    <button class="bg-blue-500 text-white rounded-full p-2 hover:bg-blue-400 focus:outline-none w-12 h-10 flex items-center justify-center"
                            style="background-color: rgba(47, 54, 95)">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('', )" tabindex="-1">
                            <div>
                                <icon name="search"/>
                            </div>
                        </inertia-link>
                    </button>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-4 pt-6 pb-4">ID</th>
                    <th class="px-4 pt-6 pb-4">Customer Name</th>
                    <th class="px-4 pt-6 pb-4">Subsc. Package</th>
                    <th class="px-4 pt-6 pb-4">Total Leads</th>
                    <th class="px-4 pt-6 pb-4">Leads Left</th>
                    <th class="px-4 pt-6 pb-4">
                        <div class="flex flex-row">
                            Upload Leads 
                            <button @click="showModal=true">
                                <icon class="ml-4" name="info" />
                            </button>
                        </div>
                    </th>

                    <!-- info modal -->
                    <t-modal v-model="showModal" header="Upload Format">
                        <span class="font-sans">Excel file upload format</span>
                        <div class="flex justify-between">
                            <div>
                                <p>user_id</p>
                                <p>lead_name</p>
                                <p>lead_last_name</p>
                                <p>lead_email</p>
                                <!-- <p>lead_description</p>
                                <p>lead_company_name</p> -->
                                <p>lead_number</p>
                                <!-- <p>lead_notes</p>
                                <p>lead_status</p> -->
                            </div>
                        </div>
                        <template v-slot:footer>
                            <p>Make Sure to keep this header row in each file:</p>
                        </template>
                    </t-modal>
                </tr>
                <tr v-for="client in filteredList.sort(function(a, b){return a.leads_left - b.leads_left})" :key="client.user_id" :class="computedClass">
                    <td class="border-t px-4 pt-6 pb-4">
                        {{ client.user_id }}
                    </td>
                    <td class="border-t px-4 pt-6 pb-4 hover:underline">
                        <div class="flex">
                            <p class="underline font-bold"><inertia-link :href="route('admin.user.view', client.user_id)">
                                {{ client.first_name }}  {{ client.last_name }}
                            </inertia-link></p>
                            <div v-if="client.deleted_at != null"><icon class="ml-4" name="block" /></div>
                        </div>
                    </td>
                    <td class="border-t px-4 pt-6 pb-4">
                        {{ client.package_name }}
                    </td>
                    <td class="border-t px-4 pt-6 pb-4">
                        {{ client.package_benefits }}
                    </td>
                    <td class="border-t px-4 pt-6 pb-4">
                        <inertia-link :href="route('', )">
                            <span>{{ client.leads_left }}</span>
                        </inertia-link>
                    </td>
                    <td class="border-t w-px px-4 pt-6 pb-4">
                        <form @submit.prevent="store">
                            <div>
                                <input type="file" 
                                        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                        required @input="form.avatar = $event.target.files[0]">
                                <button type="submit" class="btn-indigo" @click="form.user_id=client.user_id">Import Leads</button>
                            </div>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
import AdminLayout from '@/Shared/AdminLayout'
import Icon from '@/Shared/Icon'
import SearchFilter from '@/Shared/SearchFilter'
import TModal from 'vue-tailwind/dist/t-modal'


export default {
  metaInfo: { title: 'Leads' },
  components: {
    Icon,
    SearchFilter,
    TModal,
  },
  layout: AdminLayout,
  props: {
    clients: Array,
  },

  data() {
      return {
        search: '',
        showModal: false,
        showModal2: false,
        form: this.$inertia.form({
            avatar: null,
            user_id: null,
        }),
      }
  },

  computed: {
    filteredList() {
        // this.clients = this.clients.sort(function(a, b){return a.leads_left - b.leads_left});
        // console.log(res);
        return this.clients.filter(post => {
            return post.first_name.toLowerCase().includes(this.search.toLowerCase())
      })
    },

    computedClass() {
        let className = 'hover:bg-gray-100 focus-within:bg-gray-100';

        
        return className;
    }
  },

  methods: {
    onFileChange(e) {
        this.import_file = e.target.files[0];
    },
    store() {
        if(!this.form.avatar){
            this.showModal2 = true;
            // alert("file upload required!");
        }
        else{
            this.form.post(this.route('import.leads'))
        }
    },
    proceedAction() {
        let formData = new FormData();
        formData.append('import_file', this.import_file);

        axios.post('/import', formData, {
            headers: { 'content-type': 'multipart/form-data' }
        })
        .then(response => {
            if(response.status === 200) {
                // codes here after the file is upload successfully
            }
        })
        .catch(error => {
            // code here when an upload is not valid
            this.uploading = false
            this.error = error.response.data
            console.log('check error: ', this.error)
        });
    },
  },
}
</script>