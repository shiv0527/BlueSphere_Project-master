<template>
	<div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <logo class="block mx-auto w-full max-w-xs fill-white" height="50" /> 
        <form @submit.prevent="submit" class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden">
          <div v-if="status" class="mb-4 text-success h-12 bg-green-300 font-bold">
            <span>{{ status }}</span>
          </div>
          <div class="px-10">
            <h1 class="text-center font-bold text-3xl pt-6">Reset Password</h1> 
            <div class="mx-auto mt-6 w-24 border-b-2" />             
            <text-input 
              type="email"
              v-model="form.email" 
              :error="form.errors.email"  
              placeholder="Email" 
              class="mt-10"
              label="Email"
              required 
              autofocus />
            <text-input 
              type="password"
              v-model="form.password"
              :error="form.errors.password"  
              placeholder="Password" 
              class="mt-10"
              required />
            <text-input 
              type="password"
              v-model="form.password_confirmation" 
              :error="form.errors.password_confirmation"  
              placeholder="Confirm Password" 
              class="mt-10 mb-6"
              required />
          </div>
          <div class="py-4 px-10 border-t bg-gray-100 border-gray-100 flex">
            <loading-button 
              type='submit'
              class="ml-auto btn-indigo px-4" 
              :loading="form.processing">
                Reset Password
            </loading-button>
          </div>
        </form>     
    </div>
  </div>
</template>

<script>
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import Logo from '@/Shared/Logo'

export default {
  metaInfo: { title: 'Reset Password' },
  components: {
    LoadingButton,
    TextInput,
    Logo,
  },
  props: {
    email: String,
    token: String,
    status: String,
  },
  data() {
    return {
      form: this.$inertia.form({
        token: this.token,
        email: this.email,
        password: '',
        password_confirmation: '',
      }),
    }
  },
    methods: {
      submit() {
          this.form.post(this.route('password.update'), {
              onFinish: () => this.form.reset('password', 'password_confirmation'),
          })
      }
    }
};
</script>