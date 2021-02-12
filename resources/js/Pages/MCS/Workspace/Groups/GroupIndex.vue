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
   metaInfo: { title: "Groups" },

   components: {
      Multiselect,
      Workspace,
      ActionButton,
      ActionLink,
      ActionMenu,
      DataTable,
   },

   props: {
      groups: Array | Object,
      tags: Array | Object,
   },

   data() {
      return {
         sending: false,
         selectAll: false,
         tagList: this.tags,
         form: {
            groups: this.groups,
            selected: [],
         },
      }
   },

   methods: {
      addTag(searchQuery, id) {
         const tag = {
            name: searchQuery,
         }

         this.form.groups.data[id].tags.push(tag)
         this.tagList.push(tag)

         const item = this.form.groups.data[id]

         this.$inertia.post(route("group.tag.create", { groupID: item.id }), tag, {
            onStart: () => (this.sending = true),
            onFinish: () => {},
         })
      },

      handleInput(item) {
         this.$inertia.put(route("group.update", { groupID: item.id }), item, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },

      all() {
         this.form.selected = []
         if (!this.selectAll) {
            for (let i in this.groups.data) {
               this.form.selected.push(this.groups.data[i].id)
            }
         }
      },
      confirmDelete(id) {
         if (confirm("Are you sure you want to delete this group?")) {
            this.$inertia.delete(
               route("group.delete", { groupID: id }),
               {},
               {
                  onStart: () => (this.sending = true),
                  onFinish: () => (this.sending = false),
               }
            )
         }
      },
   },
}
</script>

<template>
   <Workspace nav="pages">
      <template #header>Groups</template>
      <template #ribbon>
         <li><inertia-link :href="route('page.create')" class="button--secondary:small">Create a New Group</inertia-link></li>
      </template>
      <template #body v-if="form.groups.data.length > 0">
         <div class="grid">
            <div class="col-12">
               <DataTable :links="form.groups.links" :deleteRoute="route('group.selected', { action: 'delete' })">
                  <template #header>
                     <th>
                        <label>
                           <input v-model="selectAll" type="checkbox" @click="all" />
                        </label>
                     </th>
                     <th>Name</th>
                     <th>Tags</th>
                     <th>&nbsp;</th>
                  </template>
                  <template #contents>
                     <tr v-for="(group, i) in form.groups.data" :key="group.id">
                        <td><input v-model="form.selected" type="checkbox" :value="group.id" /></td>
                        <td>{{ group.name }}</td>
                        <td>
                           <multiselect
                              v-model="group.tags"
                              :id="i"
                              tag-placeholder="Add Tag"
                              placeholder="Search or add a tag"
                              label="name"
                              track-by="name"
                              :options="tagList"
                              :multiple="true"
                              :taggable="true"
                              @tag="addTag"
                              @input="handleInput(group)"
                           ></multiselect>
                        </td>
                        <td>
                           <ActionMenu>
                              <ActionLink :inertia="true" :link="route('group.edit', { groupID: group.id })">Edit</ActionLink>
                              <ActionButton @click="confirmDelete(group.id)">Delete</ActionButton>
                           </ActionMenu>
                        </td>
                     </tr>
                  </template>
               </DataTable>
            </div>
         </div>
      </template>
      <template #body v-else>
         <div class="grid--center">
            <div class="col-8--centered sm::col-6--centered md::col-4--centered">
               <inertia-link :href="route('group.create')" class="button:xlarge">Create Your First Group</inertia-link>
            </div>
         </div>
      </template>
   </Workspace>
</template>

<style lang="scss"></style>
