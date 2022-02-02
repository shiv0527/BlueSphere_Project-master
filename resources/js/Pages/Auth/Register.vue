<template>
  <div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />
      
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="login">
        <div class="px-10 py-2">
          <h1 class="text-center font-bold text-3xl">Registering</h1>
          <div class="mx-auto mt-6 w-24 border-b-2" />
      
            <text-input required v-model="form.first_name" :error="form.errors.first_name" class="mt-6" label="* First Name" type="text" autofocus autocapitalize="off" />
            <text-input required v-model="form.last_name" :error="form.errors.last_name" class="mt-6" label="* Last Name" type="text" autofocus autocapitalize="off" />
            <text-input required v-model="form.email" :error="form.errors.email" class="mt-6" label="* Email" type="email" autofocus autocapitalize="off" />
            <text-input required minlength="8" v-model="form.password" :error="form.errors.password" class="mt-6" label="* Password" type="password" />        

        </div>

        <div class="py-2 text-center">
          <span class="text-sm">Already exists?</span>
          <inertia-link class="hover:underline text-sm" :href="route('login')">
            LogIn
          </inertia-link>
        </div>

        <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
          <loading-button :loading="form.processing" class="ml-auto btn-indigo" type="submit">Register</loading-button>
        </div>
      </form> 
    </div>
  </div>
</template>

<script>
import Logo from '@/Shared/Logo'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'



export default {
  metaInfo: { title: 'Register' },
  components: {
    LoadingButton,
    Logo,
    TextInput,
    SelectInput,
  },
  props: {
    packages: Array,
  },
  data() {
    return {
      errors: [],
      form: this.$inertia.form({
        first_name: null,
        last_name: null,
        email: '@example.com',
        password: null,
      }),
      cardElement: {},
      stripe: {},
    }
  },
  methods: {
    async login() { 
        this.form.post(this.route('register.post'))
    },
  },
}
</script>
