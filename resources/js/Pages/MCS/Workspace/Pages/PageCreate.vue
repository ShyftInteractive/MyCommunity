<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import { slugify } from "@/Data/MCS/Globals"

export default {
   layout: Layout,
   metaInfo: { title: "Pages" },

   components: {
      Workspace,
   },

   props: {
      templates: Array,
   },

   watch: {
      "form.title": function (newTitle, oldTitle) {
         this.form.slug = slugify(newTitle)
      },
   },

   data() {
      return {
         sending: false,
         form: {
            slug: null,
            title: null,
            isHomepage: false,
            visibility: this.$page.props.app.roles.PUBLIC_ACCESS,
            template: null,
            content: null,
         },
      }
   },

   methods: {
      preview() {},
      submit() {
         this.$inertia.post(route("page.store"), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="pages">
      <template #header>Create a Page</template>
      <template #body>
         <form class="layout__main" action="post" @submit.prevent="submit">
            <section class="grid">
               <FormField validate="title" class="col-10--centered wd::col-6--centered">
                  <FieldLabel>Page Title</FieldLabel>
                  <FormInput v-model="form.title" />
               </FormField>

               <FormField validate="slug" class="col-10--centered wd::col-6--centered">
                  <FieldLabel>Page URL</FieldLabel>
                  <FormInput v-model="form.slug" :slugify="true" />
               </FormField>

               <FormField validate="visibility" class="col-10--centered wd::col-3:at-4">
                  <FieldLabel>Page Visibility:</FieldLabel>
                  <FormSelect v-model="form.visibility" defaultText="Select" selected="$page.props.app.roles.PUBLIC_ACCESS" :options="$page.props.app.roles" />
               </FormField>

               <FormField validate="template" class="col-10--centered wd::col-3">
                  <FieldLabel>Pick a Template:</FieldLabel>
                  <FormSelect v-model="form.template" defaultText="Select" :options="templates" />
               </FormField>

               <Button class="col-10--centered wd::col-1 button--link" type="submit" @click="preview">Preview</Button>

               <FormField validate="isHomepage" class="col-10--centered wd::col-3:at-4">
                  <FormCheckbox v-model="form.isHomepage">Set as Homepage</FormCheckbox>
               </FormField>
               <Button class="col-10--centered md::col-6--centered button" type="submit" :disable="sending">Make</Button>
            </section>
         </form>
      </template>
   </Workspace>
</template>

<style lang="scss"></style>
