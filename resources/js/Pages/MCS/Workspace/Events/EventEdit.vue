<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import FormDatePicker from "@/Components/MCS/Form/FormDatePicker"
import { VueEditor } from "vue2-editor/dist/vue2-editor.core.js"
import "quill/dist/quill.snow.css"

export default {
   layout: Layout,
   metaInfo: { title: `Edit Your Event` },

   components: {
      FormDatePicker,
      Workspace,
      VueEditor,
   },

   props: {
      event: Object,
   },
   computed: {
      editorOptions() {
         return { theme: "snow" }
      },
   },
   data() {
      return {
         sending: false,
         form: this.event,
      }
   },

   methods: {
      save() {
         this.$inertia.put(route("event.update", { eventID: this.form.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="events">
      <template #header>Create a New Event</template>
      <template #body>
         <form class="layout__main" action="post" @submit.prevent="save">
            <section class="grid">
               <FormField validate="title" class="col-10--centered wd::col-6--centered">
                  <FieldLabel>Title for your event</FieldLabel>
                  <FormInput v-model="form.title" />
               </FormField>
               <FormField class="col-10--centered wd::col-2:at-4">
                  <FieldLabel>Starts At</FieldLabel>
                  <FormDatePicker v-model="form.start_at" />
               </FormField>
               <FormField class="col-10--centered wd::col-2">
                  <FieldLabel>Ends At</FieldLabel>
                  <FormDatePicker v-model="form.end_at" />
                  <small><em>You can leave this empty</em></small>
               </FormField>
               <FormField validate="visibility" class="col-10--centered wd::col-2">
                  <FieldLabel>Who can see this event?</FieldLabel>
                  <FormSelect v-model="form.visibility" :options="$page.props.app.roles" />
               </FormField>
               <div class="col-10--centered wd::col-6--centered">
                  <vue-editor
                     :editorOptions="editorOptions"
                     :editor-toolbar="[[{ size: ['small', false, 'large', 'huge'] }], ['bold', 'italic', 'underline', 'strike'], ['link'], [{ list: 'ordered' }, { list: 'bullet' }]]"
                     v-model="form.description"
                  ></vue-editor>
               </div>

               <Button class="col-10--centered md::col-6--centered button" type="submit" :disable="sending">Update</Button>
            </section>
         </form>
      </template>
   </Workspace>
</template>

<style lang="scss">
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
}
</style>
