<script>
import Layout from "@/Templates/Rebase/Layout"
import Register from "@/Templates/Rebase/Page/Register"

export default {
   layout: Layout,
   metaInfo: { title: "Register" },

   components: {
      Register,
   },
   remember: "form",

   data: function () {
      return {
         sending: false,
         showAddress: false,
         states: states,
         form: {
            payment_method: null,
            ach: false,
            plan: null,
            name: this.name,
            email: this.email,
            sub: this.sub,
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
   },
   computed: {},
   methods: {},
}
</script>

<template>
   <Register :step="3">
      <form action="post">
         <section class="grid--center">
            <h3 class="col-10--centered md::col-8--centered">Please Pick a Plan</h3>

            <FormField class="col-10--centered md::col-8--centered" validation="plan">
               <FieldLabel>Please Select From One of the Following:</FieldLabel>
               <FormSelect v-model="form.plan" defaultText="Select an Option">
                  <option v-for="product in $page.props.app.pricing" :key="product.id" :value="product.id">{{ product.name }} ${{ product.price / 100 }}.00</option>
               </FormSelect>
            </FormField>

            <div class="col-6">
               <h1>Pay By ACH</h1>
               <p>
                  <small><em>Someone will contact you within 2 days to complete your setup. When paying this way your site is not finalized until the ACH has been set up.</em></small>
               </p>
            </div>
            <div class="col-6">
               <h1>Pay By Credit Card</h1>
            </div>

            <Button class="col-10--centered md::col-4--centered button" type="submit" :disable="sending">Go and Pay</Button>
         </section>
      </form>
   </Register>
</template>

<style lang="scss" scoped>
form {
   height: 100%;
}
</style>
