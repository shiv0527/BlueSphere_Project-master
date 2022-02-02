<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('contacts')">Lead</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Update
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
            <!-- <p>{{ lead.lead_name }}</p> -->
            <label for="id" class="font-bold">Lead ID</label>
            <br>
            <input id="id" v-model="form.id" :error="form.errors.first_name" class="mt-4 pr-6 pb-8 w-full" readonly/>

            <label for="lead_name" class="font-bold">Lead Name</label>
            <br>
            <input id="lead_name" v-model="form.lead_name" :error="form.errors.first_name" class="mt-4 pr-6 pb-8 w-full" readonly/>
            
            <label for="lead_email" class="font-bold">Lead Email</label>
            <br>
            <input id="lead_email" v-model="form.lead_email" :error="form.errors.last_name" class="mt-4 pr-6 pb-8 w-full" readonly/>
            
            <!-- <label for="lead_desc" class="font-bold">Lead Description</label>
            <br>
            <input id="lead_desc" v-model="form.lead_description" :error="form.errors.last_name" class="mt-4 pr-6 pb-8 w-full"/>
            
            <label for="lead_comp" class="font-bold">Lead Company</label>
            <br>
            <input id="lead_comp" v-model="form.lead_company_name" :error="form.errors.last_name" class="mt-4 pr-6 pb-8 w-full"/> -->
            
            <label for="notepad" class="font-bold">Notepad</label>
            <br>
            <textarea id="notepad" v-model="form.notepad" class="w-full mt-4 form-input" placeholder="add a note"></textarea>
          
            <select-input v-model="form.lead_status" :error="form.errors.email" class="mt-4 pr-6 pb-8 w-full lg:w-1/2 font-bold" label="Status">
              <option :value="null" />
              <option v-for="yn in status" :key="yn" :value="yn">{{ yn }}</option>
            </select-input>
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Save</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import Icon from '@/Shared/Icon'

export default {
  metaInfo: { title: 'Update Lead' },
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
    Icon,
  },
  layout: Layout,
  props: {
    lead: Object,
    status: Array,
  },

  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.lead.id,
        lead_name: this.lead.lead_name,
        lead_email: this.lead.lead_email,
        // lead_description: this.lead.lead_description,
        // lead_company_name: this.lead.lead_company_name,
        notepad: this.lead.lead_notes,
        lead_status: this.lead.lead_status,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('leads.store'))
    },
  },
}
</script>
