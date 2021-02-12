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
   metaInfo: { title: "Edit your group" },

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
      group: Object,
   },

   data() {
      return {
         sending: false,
         form: {
            name: this.group.name,
            tags: this.group.tags,
         }
      }
   },

   methods: {
      submit() {
         this.$inertia.put(route("group.update", {groupID: this.group.id}), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },

      addTag(searchQuery, id) {
         const tag = {
            name: searchQuery,
         }
         this.mediaList.data[id].tags.push(tag)
         this.tagList.push(tag)

         const item = this.mediaList.data[id]

         this.$inertia.post(route("tag.store", { mediaID: item.id }), tag, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="pages">
      <template #header>Edit Group: {{group.name}}</template>
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
            <Button class="col-10--centered md::col-6--centered button" type="submit" :disable="sending">Update Group</Button>
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
