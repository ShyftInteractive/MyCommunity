<script>
import Layout from "@/Templates/Rebase/Layout"
import Register from "@/Templates/Rebase/Page/Register"

export default {
   layout: Layout,
   metaInfo: { title: "Step 1: Get Some Basic Info" },

   components: {
      Register,
   },

   data() {
      return {
         sending: false,
         form: {
            sub: null,
            name: null,
            email: null,
         },
      }
   },

   props: {
      sub: {
         type: String,
         default: null,
      },
   },

   methods: {
      check() {
         this.sending = true

         this.$inertia.post(route("register.basic-info.process"), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Register :step="1">
      <form class="layout__main" action="post" @submit.prevent="check">
         <section class="grid--center">
            <div class="col-10--centered md::col-8--centered xw::col-6--centered">
               <h3>Let's Get Started</h3>
               <p>First thing we need is what you want to call your website. This will become your URL, what people will type in to pull up your website.</p>
            </div>
            <FormField class="col-10--centered md::col-8--centered xw::col-6--centered" validate="sub">
               <FieldLabel>What's your website's name:</FieldLabel>
               <FormGroup>
                  <FormInput v-model="form.sub" :slugify="true" />
                  <template #post> .{{ $page.props.app.domain }} </template>
               </FormGroup>
            </FormField>
            <div class="col-10--centered md::col-8--centered xw::col-6--centered">
               <h3>About You</h3>
               <p>We need a little information about you. You're going to become the <strong>Account Owner</strong> which means you'll have access to payment information and access to who can access the site.</p>
            </div>
            <FormField class="col-10--centered md::col-8--centered xw::col-6--centered" validate="name">
               <FieldLabel>What's your name?</FieldLabel>
               <FormInput v-model="form.name" />
            </FormField>
            <FormField class="col-10--centered md::col-8--centered xw::col-6--centered" validate="email">
               <FieldLabel>What's your email address?</FieldLabel>
               <FormInput v-model="form.email" />
            </FormField>
            <Button class="col-10--centered md::col-8--centered xw::col-6--centered button:block" type="submit" :disable="sending">Check</Button>
         </section>
      </form>
   </Register>
</template>

<style lang="scss">
@import "@@/abstract";

.layout__main {
   @media ($md-and-up) {
      height: 100%;
   }
}
</style>
