<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import { VueEditor } from "vue2-editor/dist/vue2-editor.core.js"
import "quill/dist/quill.snow.css"

export default {
   layout: Layout,
   metaInfo: { title: "Create a New Notification" },

   watch: {},
   components: {
      Workspace,
      VueEditor,
   },
   props: {
      templates: Array,
   },
   computed: {
      editorOptions() {
         return { theme: "snow" }
      },
   },
   data() {
      return {
         sending: false,
         form: {
            type: this.$page.props.app.notifications.BANNER,
            message: null,
            details: null,
            active: false,
            visibility: this.$page.props.app.roles.PUBLIC_ACCESS,
            banner_display_at: null,
            banner_hide_at: null,
         },
      }
   },

   methods: {
      submit() {
         this.$inertia.post(route("notification.store"), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="posts">
      <template #header>Create a New Notification</template>
      <template #body>
         <form class="layout__main" action="post" @submit.prevent="submit">
            <section class="grid">
               <FormField validate="visibility" class="col-10--centered wd::col-6--centered">
                  <FieldLabel>What Type of Notification Are You Making</FieldLabel>
                  <FormSelect v-model="form.type" :options="$page.props.app.notifications" />
               </FormField>

               <template v-if="form.type === $page.props.app.notifications.MESSAGE">
                  <p class="col-10 wd::col-6--centered" v-if="form.type === $page.props.app.notifications.MESSAGE">
                     <small>
                        Messages are longer form notices, they live in your members dashboard area and they can be viewed by users whenever the member chooses. Messages do not disappear and members will receive a email notification telling
                        them they have a new notification. They will only receive ONE email per-day. You also get more formatting capabilities in messages.
                     </small>
                  </p>
                  <FormField validate="message" class="col-10--centered wd::col-6--centered">
                     <FieldLabel>Title</FieldLabel>
                     <FormInput v-model="form.message" />
                  </FormField>
                  <FormField validate="details" class="col-10--centered wd::col-6--centered">
                     <FieldLabel>Message</FieldLabel>
                     <vue-editor
                        class="col-12"
                        :editorOptions="editorOptions"
                        :editor-toolbar="[[{ size: ['small', false, 'large', 'huge'] }], ['bold', 'italic', 'underline', 'strike'], [{ align: [false, 'center', 'right'] }], ['link'], [{ list: 'ordered' }, { list: 'bullet' }]]"
                        v-model="form.message"
                     ></vue-editor>
                  </FormField>
               </template>
               <template v-if="form.type === $page.props.app.notifications.BANNER">
                  <p class="col-10 wd::col-6--centered">
                     <small> A Site Banner will go across the top of all pages on your website, it will stay there until you remove it or a pre-defined date that you set. </small>
                  </p>
                  <FormField ="message" class="col-10--centered wd::col-6--centered">
                     <FieldLabel>Message</FieldLabel>
                     <vue-editor class="col-12" :editorOptions="editorOptions" :editor-toolbar="[['bold', 'italic', 'underline', 'strike'], ['link']]" v-model="form.message"></vue-editor>
                  </FormField>
               </template>

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

<style lang="scss">
@import "@@/abstract";
.quillWrapper {
   display: flex;
   flex-direction: column;
   background: #fbfbfb;
}
.ql-toolbar {
   background-color: var(--color-true-white);
}
.ql-editor {
   font-size: var(--px-16);
   line-height: 1.3;
   min-height: 300px;
   max-height: 600px;
   overflow-y: auto;
}
</style>
