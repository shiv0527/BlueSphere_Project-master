<template>
  <div>
        <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
        <!-- <p class="mb-8 leading-normal">Hey there! Welcome to Ping CRM, a demo app designed to help illustrate how <a class="text-indigo-500 underline hover:text-orange-600" href="https://inertiajs.com">Inertia.js</a> works.</p> -->
        <div v-if="stripe == null">
            <!-- <h1>user not subscribed</h1> -->
            <div class="min-w-screen h-screen animated fadeIn faster left-0 top-0 flex justify-center items-start inset-0 z-50 outline-none focus:outline-none">
                <div class="flex flex-col p-8 bg-white shadow-md hover:shodow-lg rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-16 h-16 rounded-2xl p-3 border border-blue-100 text-blue-400 bg-blue-50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex flex-col ml-3">
                                <div class="font-medium leading-none pb-4">Subscribe to a Package ?</div>
                                <p class="text-md text-gray-600 leading-none mt-1">You don't have any subscribed package, By subscribing to a package you can have access to our services</p>
                            </div>
                        </div>
                        <div class="ml-4">
                            <inertia-link class="btn-indigo px-3" :href="route('package')">
                                <span>Packages</span>
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div v-if="sample.length == 0">
                <h2 class="mb-8 font-bold text-2xl">No Leads Found For You.</h2>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2">
                <div v-for="s in sample" :key="s.id" class="max-w-md py-4 px-8 bg-white shadow-lg rounded-lg my-20">
                    <div class="flex justify-center md:justify-end -mt-16">
                        <img class="w-20 h-20 object-cover rounded-full border-2 border-indigo-500" src="https://images.unsplash.com/photo-1499714608240-22fc6ad53fb2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80">
                    </div>
                    <div>
                        <h2 class="text-gray-800 text-3xl font-semibold">{{ s.lead_name }} {{ s.lead_last_name }}</h2>
                        <p class="mt-2 text-gray-600">{{ s.lead_company_name }}</p>
                        <p class="mt-2 text-gray-600">{{ s.lead_description }}  description.</p>
                    
                        <div class="mt-4">
                            <h3 class="text-gray-800 text-2xl font-semibold">Contact Information</h3>
                            <p class="mt-2 text-gray-600">{{ s.lead_email }}</p>
                            <p class="mt-2 text-gray-600">{{ s.lead_number }}</p>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <inertia-link class="text-med font-medium btn-indigo" :href="route('leads')">
                            View More
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  metaInfo: { title: 'Dashboard' },
  layout: Layout,
  props: {
      sample: Array,
      stripe: String,
  }
}
</script>
