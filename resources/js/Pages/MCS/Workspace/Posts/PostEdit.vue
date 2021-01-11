<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import Editor from "@/Components/MCS/EditorTools/Editor"
import FormDatePicker from "@/Components/MCS/Form/FormDatePicker"

export default {
   layout: Layout,
   metaInfo: { title: "Edit the Post" },

   components: {
      FormDatePicker,
      Workspace,
      Editor,
   },

   props: {
      post: Array | Object,
   },

   data() {
      return {
         sending: false,
         body: null,
         form: {
            post: this.post,
         },
      }
   },

   mounted() {
      document.addEventListener("keydown", (e) => {
         if (e.ctrlKey && e.which === 83) {
            this.save()
         }
      })
   },

   methods: {
      save() {
         this.$inertia.put(route("post.update", { postID: this.form.post.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },

      togglePublish() {
         if (this.form.post.published) {
            this.form.post.published_at = null
            this.form.post.published = false
         } else {
            this.form.post.published_at = new Date()
            this.form.post.published = true
         }

         this.$inertia.put(route("post.update", { postID: this.form.post.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="posts" :useDrawer="true">
      <template #header>Edit Post</template>
      <template #body>
         <div class="grid--top">
            <div class="col-12 sm::col-10">
               <div class="grid">
                  <div class="col-10--centered">
                     <Editor v-model="form.post.content" />
                  </div>
               </div>
            </div>
         </div>
      </template>
      <template #drawer>
         <div class="grid">
            <Button class="button--secondary col-12 sm::col-6" @click="save">Save</Button>
            <FormField v-if="!form.post.published" class="col-12 sm::col-3">
               <FieldLabel>Schedule</FieldLabel>
               <FormDatePicker v-model="form.post.published_at" />
            </FormField>
            <Button class="button col-12 sm::col-3" @click="togglePublish">
               <span v-if="!form.post.published">Publish Now</span>
               <span v-else>Unpublish</span>
            </Button>
            <FormField validate="visibility" class="col-12">
               <FieldLabel>Who can see this post?</FieldLabel>
               <FormSelect v-model="form.post.visibility" :options="$page.props.app.roles" />
               <small>
                  <em v-if="form.post.visibility !== $page.props.app.roles.PUBLIC_ACCESS">
                     You must be <strong>{{ form.post.visibility }}</strong> or above to see this post
                  </em>
                  <em v-else> Anyone can see this post </em>
               </small>
            </FormField>
            <FormField validate="form.post.title" class="col-12">
               <FieldLabel>Post Title</FieldLabel>
               <FormInput v-model="form.post.title" />
            </FormField>
            <FormField validate="form.post.slug" class="col-12">
               <FieldLabel>Post URL</FieldLabel>
               <FormInput v-model="form.post.slug" slugify />
               <small
                  ><em>https://joecianflone.mycommunity.test/{{ form.post.slug }}</em></small
               >
            </FormField>
         </div>
      </template>
   </Workspace>
</template>
