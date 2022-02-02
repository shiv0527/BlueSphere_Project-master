<template>
  <div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center"> 
        <t-modal header="Error">
            {{ message }}            
        </t-modal>
  </div>
</template>

<script>
import Logo from '@/Shared/Logo'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TModal from 'vue-tailwind/dist/t-modal'



export default {
  metaInfo: { title: 'Register' },
  components: {
    LoadingButton,
    Logo,
    TextInput,
    SelectInput,
    TModal,
  },
  props: {
    message: String,
  },
}
</script>
