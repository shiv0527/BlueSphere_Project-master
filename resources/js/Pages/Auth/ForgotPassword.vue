<template>
	<div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <logo class="block mx-auto w-full max-w-xs fill-white" height="50" /> 
        <form @submit.prevent="submit" class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden">
          <div v-if="status" class="mb-4 text-success h-12 bg-green-300 font-bold">
            <span>{{ status }}</span>
          </div>
          <div class="px-10">
            <h1 class="text-center font-bold text-3xl pt-6">Forgot Password?</h1> 
            <div class="mx-auto mt-6 w-24 border-b-2" />             
            <text-input 
              type="email"
              v-model="form.email" 
              :error="form.errors.email"  
              placeholder="Email" 
              class="mt-10"
              label="Enter the email you used to register"
              required 
              autofocus />
          </div>
          <div class="px-10 py-4 mt-6 bg-gray-100 border-t border-gray-100 flex">
            <loading-button 
              type='submit'
              class="ml-auto btn-indigo px-4" 
              :loading="form.processing">
                Email Password Reset Link
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
    metaInfo: { title: 'Forgot Password' },
    components: {
      LoadingButton,
      TextInput,
      Logo,
    },
    props: {
      status: String,
    },
    data() {
      return {
        form: this.$inertia.form({
          email: '',
        }),
      }
    },
    methods: {
      submit() {
          this.form.post(this.route('password.email'))
      }
    }
  };
</script>