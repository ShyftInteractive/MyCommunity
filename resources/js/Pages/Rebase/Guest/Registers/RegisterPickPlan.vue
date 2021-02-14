<script>
import Layout from "@/Templates/Rebase/Layout"
import Register from "@/Templates/Rebase/Page/Register"

export default {
   layout: Layout,
   metaInfo: { title: "Step 2: Pick your plan and payment method" },

   components: {
      Register,
   },
   remember: "form",

   data: function () {
      return {
         sending: false,
         form: {
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
   },
   computed: {},
   methods: {
      payVia(ach) {
         this.form.ach = ach
         console.log(this.form)
         this.$inertia.post(route("register.pick-plan.process"), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Register :step="2">
      <form action="post">
         <section class="grid--center">
            <h3 class="col-10--centered md::col-8--centered">Please Pick a Plan</h3>

            <FormField class="col-10--centered md::col-8--centered" validation="plan">
               <FieldLabel>Please Select From One of the Following:</FieldLabel>
               <FormSelect v-model="form.plan" defaultText="Select an Option">
                  <option v-for="product in $page.props.app.pricing" :key="product.id" :value="product.id">{{ product.name }} ${{ product.price / 100 }}.00</option>
               </FormSelect>
            </FormField>

            <div class="col-10--centered md::col-4:at-3">
               <Button class="button" :disable="sending" @click="payVia(false)">Pay by Credit Card</Button>
            </div>

            <div class="col-10--centered md::col-4:at-7">
               <Button class="button" :disable="sending" @click="payVia(true)">Pay via ACH</Button>
               <p>
                  <small><em>Someone will contact you within 2 business-days to complete your setup. When paying this way your site is not finalized until the ACH has been authorized.</em></small>
               </p>
            </div>
         </section>
      </form>
   </Register>
</template>

<style lang="scss" scoped>
@import "@@/abstract";

form {
   height: 100%;
}
</style>
