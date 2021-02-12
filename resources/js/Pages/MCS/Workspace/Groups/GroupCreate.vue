<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"
import ActionLink from "@/Components/Rebase/Actions/ActionLink"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import DataTable from "@/Components/Rebase/DataTable"
import Multiselect from "vue-multiselect"
import "vue-multiselect/dist/vue-multiselect.min.css"

export default {
   layout: Layout,
   metaInfo: { title: "Create a new group" },

   components: {
      Workspace,
      Multiselect,
      ActionButton,
      ActionLink,
      ActionMenu,
      DataTable,
   },

   props: {
      tags: Array | Object,
   },

   data() {
      return {
         sending: false,
         tagList: this.tags,
         form: {
            name: null,
            tags: [],
         },
      }
   },

   methods: {
      submit() {
         this.$inertia.post(route("group.store"), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
      addTag(searchQuery, id) {
         const tag = {
            name: searchQuery,
         }

         this.form.tags.push(tag);
         this.tagList.push(tag)

         this.$inertia.post(route("tag.store"), tag, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="groups">
      <template #header>Create a New Group</template>
      <template #ribbon>
         <li><inertia-link :href="route('page.create')" class="button--secondary:small">Create a New Group</inertia-link></li>
      </template>
      <template #body>
         <form class="grid--top" action="post" @submit.prevent="submit">
            <FormField validate="title" class="col-10--centered wd::col-6--centered">
               <FieldLabel>Group Name</FieldLabel>
               <FormInput v-model="form.name" />
            </FormField>

            <multiselect
               class="col-10--centered wd::col-6--centered"
               v-model="form.tags"
               tag-placeholder="Add Tag"
               placeholder="Search or add a tag"
               label="name"
               track-by="name"
               :options="tags"
               :multiple="true"
               :taggable="true"
               @tag="addTag"
            ></multiselect>
            <Button class="col-10--centered md::col-6--centered button" type="submit" :disable="sending">Save Group</Button>
         </div>
         </form>
      </template>
   </Workspace>
</template>

<style lang="scss">
.list-group {
}
.list-group-item {
   border: 1px solid #ddd;
   padding: 10px 20px;
   background-color: #fff;
   cursor: move;
}
</style>
