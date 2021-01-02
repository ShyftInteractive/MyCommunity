<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import Editor from "@/Components/MCS/EditorTools/Editor"
import DatePicker from "vue2-datepicker"
import "vue2-datepicker/index.css"

export default {
   layout: Layout,
   metaInfo: { title: "Edit the Post" },

   components: {
      DatePicker,
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
      notBeforeToday(date) {
         return date < new Date(new Date().setHours(0, 0, 0, 0))
      },
      save() {
         this.$inertia.put(route("post.update", { postID: this.form.post.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
      togglePublish() {
         this.form.published = !!this.form.published
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
            <FormField validate="visibility" class="col-12 sm::col-6">
               <FieldLabel>Schedule</FieldLabel>
               <date-picker
                  v-model="form.post.published_at"
                  :shortcuts="[
                     {
                        text: 'Publish Now',
                        onClick() {
                           const date = new Date()
                           return date
                        },
                     },
                  ]"
                  type="datetime"
                  :disabled="form.post.published"
                  :disabled-date="notBeforeToday"
                  :editable="false"
                  value-type="YYYY-MM-DDTHH:mm:ss"
                  format="MM-DD-YYYY hh:mm:ss A"
                  :time-picker-options="{
                     start: '00:00',
                     step: '00:15',
                     end: '23:45',
                  }"
               >
               </date-picker>
            </FormField>

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

<style lang="scss">
@import "@@/abstract";

.mx-datepicker {
   width: 100%;
}
.mx-input {
   @include form-element;
}
</style>
