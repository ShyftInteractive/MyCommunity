<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import { Inertia } from "@inertiajs/inertia"

export default {
   layout: Layout,
   metaInfo: { title: `Add a New Member` },

   components: {
      Workspace,
   },

   props: {},

   data() {
      return {
         sending: false,
         form: {
            name: null,
            email: null,
            role: null,
            activated: false,
         },
      }
   },

   methods: {
      save() {
         this.$inertia.post(route("member.store"), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="site-settings" secondary="member">
      <template #header>Create a New Member</template>
      <template #body>
         <form class="layout__main" action="post" @submit.prevent="save">
            <section class="grid">
               <FormField validate="name" class="col-10--centered md::col-8--centered lg::col-6--centered">
                  <FieldLabel>Name:</FieldLabel>
                  <FormInput v-model="form.name" />
               </FormField>

               <FormField validate="email" class="col-10--centered md::col-8--centered lg::col-6--centered">
                  <FieldLabel>Email:</FieldLabel>
                  <FormInput v-model="form.email" />
               </FormField>

               <FormField class="col-3:at-2 md::col-3:at-3 lg::col-3:at-4 justify:end">
                  <FormCheckbox v-model="form.activated">Activate</FormCheckbox>
               </FormField>

               <FormField class="col-7 md::col-5 lg::col-3" validation="role">
                  <FieldLabel>Role:</FieldLabel>
                  <FormSelect v-model="form.role" defaultText="Select an Option" :options="$page.props.app.roles" />
               </FormField>

               <Button type="submit" class="button col-10--centered md::col-8--centered lg::col-6--centered" :disable="sending">Create</Button>
            </section>
         </form>
      </template>
   </Workspace>
</template>

<style lang="scss">
.avatar-large {
   border: 2px solid #ddd;
   background-size: cover;
   background-position: 50% 50%;
}
</style>
