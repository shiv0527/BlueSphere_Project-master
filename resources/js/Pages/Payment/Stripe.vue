<template>
    <div>
        <h1 class="text-md font-bold text-3xl mb-4">Subscription</h1>
        <div>
            <h2 class="text-md font-bold text-1xl mb-4">Product Details</h2>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <tr class="text-left font-bold">
                        <th class="px-6 pt-6 pb-4">Package Name</th>
                        <th class="px-6 pt-6 pb-4">Package Benefits</th>
                        <th class="px-6 pt-6 pb-4">Package Duration</th>
                        <th class="px-6 pt-6 pb-4">Package Price</th>
                        <th class="px-6 pt-6 pb-4" colspan="2">Active?</th>
                    </tr>
                    <tr v-for="p in pck" :key="p.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t p-6">
                            
                                {{ p.package_name.toUpperCase() }}
                           
                        </td>
                        <td class="border-t">
                            
                            <div v-if="p.package_benefits">
                                {{ p.package_benefits }} Leads
                            </div>
                        
                        </td>
                        <td class="border-t">
                            
                            {{ p.package_duration }}
                            
                        </td>
                        <td class="border-t">
                            
                            ${{ p.price }}
                          
                        </td>
                        <td class="border-t">
                            
                                {{ p.is_active }}
                            
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="pt-6 font-sans font-bold text-1xl">
            <label for="card">Credit Card Information</label>
        </div>
        
        <div v-if="this.card != null" class="bg-white rounded-md py-4 px-2">
            You already have a default payment method.
            <br />
            <form @submit.prevent="store2">
                <div class="mt-4 mb-4">
                    <label for="cardtype" class="font-bold">Card Type: </label>
                    <span id="cardtype" class="font-mono">{{ this.card.card.brand.toUpperCase() }}</span>
                </div>
                    
                <div class="mb-4">
                    <label for="cardtype" class="font-bold">Card last 4-digits: </label>
                    <span id="cardtype" class="font-mono">{{ this.card.card.last4 }}</span>
                </div>
                
                <div class="mb-4">
                    <label for="cardtype" class="font-bold">Card Exp: </label>
                    <span id="cardtype" class="font-mono">{{ this.card.card.exp_month }}/{{ this.card.card.exp_year }}</span>
                </div>  
                <button type="submit" class="mt-4 btn btn-indigo">Use this Card</button>
                
            </form>
        </div>

        <div class="rounded-md py-4 px-2">
            <p v-if="errors.length">
                <b>Please correct the following error(s):</b>
                <ul>
                    <li v-for="error in errors" :key="error" class="form-error">{{ error }}</li>
                </ul>
            </p>

            <div id="card-element" class="bg-white p-6"></div>
            <button @click="store" class="mt-6 btn btn-indigo">Subscribe</button>
        </div>
    </div>
</template>

<script src="https://js.stripe.com/v3/"></script>
<script>
    import Layout from '@/Shared/Layout'
    import Icon from '@/Shared/Icon'
    import LoadingButton from '@/Shared/LoadingButton'
    import TextInput from '@/Shared/TextInput'

    export default {
        metaInfo: { title: 'Payment Gateway' },
        components: {
            Icon,
            LoadingButton,
            TextInput,
        },

        data() {
            return {
                errors: [],
                cardElement: null,
                stripe: null,
                paymentMethod_id: null,
                form: this.$inertia.form({ 
                    price_id: this.price_id,
                    package_id: this.pck[0].product_id,
                    package_leads: this.pck[0].package_benefits,
                    package_price: this.pck[0].price,
                    default_payment_method: null,
                }),
                
                
                form2: this.$inertia.form({
                    price_id: this.price_id,
                    package_id: this.pck[0].product_id,
                    package_leads: this.pck[0].package_benefits,
                    default_payment_method: null,
                    package_price: this.pck[0].price,
                    default_card: true,
                }),
                
            }
        },

        mounted: function () {
            this.stripe = new Stripe(process.env.STRIPE_KEY);
            let elements = this.stripe.elements();

            this.cardElement = elements.create('card');
            this.cardElement.mount('#card-element');
        },

        layout: Layout,
        props: {
            pck: Array,
            price_id: String,
            card: Object,
        },
        
        methods: {
            store() {
                this.errors = [];
                
                if (!this.errors.length){
                    this.validate();   
                }
            },

            async validate() {
                let id = undefined;
                const { paymentMethod, error } = await this.stripe.createPaymentMethod(
                        'card', this.cardElement, {
                            billing_details: { name:  this.form.cardname}
                        }
                    );

                    if (error) {
                        this.errors.push("There is an Error in the card details.");
                        console.log(error);
                    } else {
                        id = paymentMethod.id;
                    }
                // console.log(id);
                
                if(!this.errors.length){
                    this.$inertia.post(this.route('subscribe'), {
                        id: id,
                        price_id: this.price_id,
                        package_id: this.pck[0].product_id,
                        package_leads: this.pck[0].package_benefits,
                        package_price: this.pck[0].price,
                    });
                }
            },

            store2() {
                this.form2.default_payment_method = this.card.id;
                this.form2.post(this.route('subscribe'))
            },
        },
    }
</script>