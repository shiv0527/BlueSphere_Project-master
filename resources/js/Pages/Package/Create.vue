<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('contacts')">Package</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input required v-model="form.package_name" class="pr-6 pb-8 w-full lg:w-1/2" label="* Package Name" />
          <text-input required v-model="form.package_benefits" class="pr-6 pb-8 w-full lg:w-1/2" label="* Package Benefits (# of Leads)" />
          <select-input required v-model="form.package_duration" class="pr-6 pb-8 w-full lg:w-1/2" label="* Package Duration">
            <option :value="null" />
            <option v-for="duration in durations" :key="duration" :value="duration">{{ duration }}</option>
          </select-input>
          <select-input required v-model="form.is_active" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="* Is Currently Active">
            <option :value="null" />
            <option v-for="yn in yesno" :key="yn" :value="yn">{{ yn }}</option>
          </select-input>
          <text-input required v-model="form.price" class="pr-6 pb-8 w-full lg:w-1/2" label="* Package Price" />
          <text-input v-model="form.offer_price" class="pr-6 pb-8 w-full lg:w-1/2" label="Offer Price" />
        
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Package</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import AdminLayout from '@/Shared/AdminLayout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  metaInfo: { title: 'Create Package' },
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: AdminLayout,
  props: {
    durations: Array,
    yesno: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        package_name: null,
        package_benefits: null,
        package_duration: null,
        is_active: null,
        price: null,
        offer_price: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('admin.package.store'))
    },
  },
}
</script>
