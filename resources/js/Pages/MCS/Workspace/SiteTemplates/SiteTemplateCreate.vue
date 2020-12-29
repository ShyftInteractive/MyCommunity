<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"
import ActionLink from "@/Components/Rebase/Actions/ActionLink"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import DataTable from "@/Components/Rebase/DataTable"

export default {
   layout: Layout,
   metaInfo: { title: "Create a New Website Template" },

   components: {
      Workspace,
   },

   props: {
      pages: Array | Object,
   },

   data() {
      return {
         sending: false,
         form: {
            name: null,
         },
      }
   },

   methods: {
      preview() {},
      submit() {
         this.$inertia.post(route("site-template.store"), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="site-settings" secondary="design" tertiary="templates">
      <template #header>Create a New Website Template</template>
      <template #body>
         <form class="layout__main" action="post" @submit.prevent="submit">
            <section class="grid">
               <FormField validate="name" class="col-10--centered wd::col-6--centered">
                  <FieldLabel>Template Name</FieldLabel>
                  <FormInput v-model="form.name" />
               </FormField>
               <Button class="col-10--centered md::col-6--centered button" type="submit" :disable="sending">Create Template</Button>
            </section>
         </form>
      </template>
   </Workspace>
</template>

<style lang="scss"></style>
