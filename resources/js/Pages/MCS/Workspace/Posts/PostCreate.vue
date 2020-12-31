<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"

export default {
   layout: Layout,
   metaInfo: { title: "Create a New Post" },

   components: {
      Workspace,
   },

   props: {
      templates: Array,
   },

   data() {
      return {
         sending: false,
         form: {
            title: null,
            visibility: this.$page.props.app.roles.PUBLIC_ACCESS,
            slug: null,
         },
      }
   },

   methods: {
      submit() {
         this.$inertia.post(route("post.store"), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="posts">
      <template #header>Create a New Post</template>
      <template #body>
         <form class="layout__main" action="post" @submit.prevent="submit">
            <section class="grid">
               <FormField validate="title" class="col-10--centered wd::col-6--centered">
                  <FieldLabel>Post Title</FieldLabel>
                  <FormInput v-model="form.title" />
               </FormField>

               <FormField validate="slug" class="col-10--centered wd::col-3:at-4">
                  <FieldLabel>Post URL</FieldLabel>
                  <FormInput v-model="form.slug" slugify />
               </FormField>

               <FormField validate="visibility" class="col-10--centered wd::col-3">
                  <FieldLabel>Who can see this post?</FieldLabel>
                  <FormSelect v-model="form.visibility" :options="$page.props.app.roles" />
               </FormField>

               <Button class="col-10--centered md::col-6--centered button" type="submit" :disable="sending">Make</Button>
            </section>
         </form>
      </template>
   </Workspace>
</template>

<style lang="scss"></style>
