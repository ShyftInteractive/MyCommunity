<script>
import Layout from "@/Templates/Rebase/Layout"
import Register from "@/Templates/Rebase/Page/Register"
import { CardNumber, CardExpiry, CardCvc, handleCardSetup } from "vue-stripe-elements-plus"
import { states } from "@/Data/Rebase/consts"

export default {
   layout: Layout,
   metaInfo: { title: "Step 3: ACH Payment Info" },

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
            payment_type: 'ach',
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
      plan: String,
      sub: String,
      name: String,
      email: String,
      options: Array | Object,
      pickedProduct: Object | Array,
   },
   computed: {},
   methods: {
      pay() {
            this.$inertia.post(route("register.pay.process"), this.form, {
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
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

   dt, dd {
      padding: var(--px-8);
      border-bottom: 1px solid var(--color-trueGray-300);

      &:last-of-type {
         border-bottom: 0;
      }
   }

}
</style>
