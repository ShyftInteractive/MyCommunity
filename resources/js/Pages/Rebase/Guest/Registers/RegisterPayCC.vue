<script>
import Layout from "@/Templates/Rebase/Layout"
import Register from "@/Templates/Rebase/Page/Register"
import { CardNumber, CardExpiry, CardCvc, handleCardSetup } from "vue-stripe-elements-plus"
import { states } from "@/Data/Rebase/consts"

export default {
   layout: Layout,
   metaInfo: { title: "Register" },

   components: {
      Register,
      CardNumber,
      CardExpiry,
      CardCvc,
   },
   remember: "form",

   data: function () {
      return {
         sending: false,
         showAddress: false,
         states: states,
         form: {
            payment_type: 'cc',
            payment_method: null,
            plan: this.plan,
            name: this.name,
            email: this.email,
            sub: this.sub,
            line1: null,
            line2: null,
            line3: null,
            unit_number: null,
            city: null,
            state: null,
            postal_code: null,
            agreed_to_terms: false,
            agreed_to_privacy: false,
         },
      }
   },

   props: {
      sub: String,
      name: String,
      email: String,
      stripe: String,
      options: Array | Object,
      stripe_key: String,
      intent: Object,
      pickedProduct: Object | Array,
      plan: String,
   },
   computed: {},
   methods: {
      pay() {
         this.sending = true
         let vm = this

         handleCardSetup(this.intent.client_secret, {
            payment_method_data: {
               billing_details: {
                  name: vm.form.name,
                  email: vm.form.email,
                  address: {
                     city: vm.form.city,
                     line1: vm.form.line1,
                     line2: vm.form.line2,
                     postal_code: vm.form.postal_code,
                     state: vm.form.state,
                  },
               },
            },
         }).then(function (result) {
            if (result.error) {
               alert("Your payment was declined for some reason")
               vm.sending = false
               return false
            }

            vm.form.payment_method = result.setupIntent.payment_method

            vm.$inertia.post(route("register.pay.process"), vm.form, {
               onStart: () => (vm.sending = true),
               onFinish: () => (vm.sending = false),
            })
         })
      },
   },
}
</script>

<template>
   <Register :step="3">
      <form action="post" @submit.prevent="pay">
         <section class="grid--center">
            <div class="col-10--centered md::col-8--centered">
               <h3>OK here's what we've got:</h3>
               <dl>
                  <dt>Your name:</dt>
                  <dd>{{ name }}</dd>
                  <dt>Your email:</dt>
                  <dd>{{ email }}</dd>
                  <dt>Your URL:</dt>
                  <dd>{{ sub }}.{{ $page.props.app.domain }}</dd>
                  <dt>Your Plan:</dt>
                  <dd>{{ pickedProduct.name }} at ${{ pickedProduct.price / 100 }}.00</dd>
               </dl>
               <p><inertia-link :href="route('register.basic-info')"></a>Start Over</inertia-link></p>
            </div>

            <h3 class="col-10--centered md::col-8--centered">Billing Address</h3>
            <FormField validate="line1" class="col-10--centered md::col-6:at-3">
               <FieldLabel>Address Line 1:</FieldLabel>
               <FormInput v-model="form.line1" />
            </FormField>

            <FormField validate="unit_number" class="col-10--centered md::col-1">
               <FieldLabel>Unit Number:</FieldLabel>
               <FormInput v-model="form.unit_number" />
            </FormField>

            <div class="col-10--centered md::col-1 justify:end">
               <Button class="button--link" @click="showAddress = showAddress ? false : true">{{ showAddress ? `Hide` : `More` }} </Button>
            </div>

            <template v-if="showAddress">
               <FormField validate="line2" class="col-10--centered md::col-8--centered">
                  <FieldLabel>Address Line 2:</FieldLabel>
                  <FormInput v-model="form.line2" />
               </FormField>

               <FormField validate="line3" class="col-10--centered md::col-8--centered">
                  <FieldLabel>Address Line 3:</FieldLabel>
                  <FormInput v-model="form.line3" />
               </FormField>
            </template>

            <FormField validate="city" class="col-10--centered md::col-4:at-3">
               <FieldLabel>City:</FieldLabel>
               <FormInput v-model="form.city" />
            </FormField>

            <FormField validate="state" class="col-10--centered md::col-2">
               <FieldLabel>State:</FieldLabel>
               <FormSelect v-model="form.state" defaultText="Select" :options="states" />
            </FormField>

            <FormField validate="postal_code" class="col-10--centered md::col-2">
               <FieldLabel>Postal Code:</FieldLabel>
               <FormInput v-model="form.postal_code" maxlength="5" />
            </FormField>

            <h3 class="col-10--centered md::col-8--centered">Credit Card Information</h3>
            <FormField class="col-10--centered md::col-8--centered">
               <FieldLabel>Card Number:</FieldLabel>
               <card-number ref="cardNumber" :stripe="stripe_key" />
            </FormField>

            <FormField class="col-5:at-2 md::col-6:at-3">
               <FieldLabel>Expires:</FieldLabel>
               <card-expiry ref="cardExpiry" :stripe="stripe_key" />
            </FormField>

            <FormField class="col-5 md::col-2">
               <FieldLabel>CVC:</FieldLabel>
               <card-cvc ref="cardCvc" :stripe="stripe_key" />
            </FormField>

            <FormField validate="agreed_to_terms" class="col-10--centered md::col-8--centered">
               <FormCheckbox v-model="form.agreed_to_terms">I agree with the Terms of Service</FormCheckbox>
            </FormField>

            <FormField validate="agreed_to_privacy" class="col-10--centered md::col-8--centered">
               <FormCheckbox v-model="form.agreed_to_privacy">I agree with the Privacy Policy</FormCheckbox>
            </FormField>
            <Button class="col-10--centered md::col-4--centered button" type="submit" :disable="sending">Pay</Button>
         </section>
      </form>
   </Register>
</template>

<style lang="scss" scoped>
@import "@@/abstract";
form {
   height: 100%;
}

dl {
   margin: var(--px-16) 0;
   display: grid;
   grid-template-columns: 1fr 2fr;
   background: var(--color-true-white);
   border: 1px solid var(--color-trueGray-300);

   dt,
   dd {
      padding: var(--px-8);
      border-bottom: 1px solid var(--color-trueGray-300);

      &:last-of-type {
         border-bottom: 0;
      }
   }
}
</style>
