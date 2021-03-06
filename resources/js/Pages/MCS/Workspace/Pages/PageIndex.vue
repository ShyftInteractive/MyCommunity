<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"
import ActionLink from "@/Components/Rebase/Actions/ActionLink"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import DataTable from "@/Components/Rebase/DataTable"

export default {
   layout: Layout,
   metaInfo: { title: "Pages" },

   components: {
      Workspace,
      ActionButton,
      ActionLink,
      ActionMenu,
      DataTable,
   },

   props: {
      pages: Array | Object,
   },

   data() {
      return {
         sending: false,
         selectAll: false,
         form: {
            pages: this.pages,
            selected: [],
         },
      }
   },

   methods: {
      confirmDelete(id) {
         if (confirm("Are you sure you want to delete this page?")) {
            this.$inertia.delete(
               route("page.delete", { pageID: id }),
               {},
               {
                  onStart: () => (this.sending = true),
                  onFinish: () => (this.sending = false),
               }
            )
         }
      },
      togglePublish(page) {
         let message = "Ready to publish?"
         if (page.published === true) {
            message = "Are you sure you want to unpublish this page, people will no longer be able to visit it?"
         }

         page.published = this.update(message, page.id, { published: !page.published })
      },

      toggleHomepage(page) {
         let message = "Set as homepage? This will unset any other page you may have set as the homepage, ok?"
         if (page.is_homepage === true) {
            message = "Unset as homepage? Without a homepage people who come to you site may think it doesn't work"
         }

         this.update(message, page.id, { is_homepage: !page.is_homepage })
      },

      update(message, id, updates) {
         if (confirm(message)) {
            this.$inertia.put(route("page.update", { pageID: id }), updates, {
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
            })
         }
      },

      deleteSelected() {
         if (confirm(`Are you sure you want to delete ${this.form.selected.length} item(s)?`)) {
            this.$inertia.post(route("page.delete.selected"), this.form, {
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
            })
         }
      },
      all() {
         this.form.selected = []
         if (!this.selectAll) {
            for (let i in this.form.pages.data) {
               this.form.selected.push(this.form.pages.data[i].id)
            }
         }
      },
   },
}
</script>

<template>
   <Workspace nav="pages">
      <template #header>Pages</template>
      <template #ribbon>
         <li><inertia-link :href="route('page.create')" class="button--secondary:small">Make a New Page</inertia-link></li>
         <li><Button @click="deleteSelected" class="button--secondary:small">Delete Selected</Button></li>
      </template>
      <template #body v-if="pages.data.length > 0">
         <div class="grid">
            <div class="col-12">
               <DataTable :links="pages.links">
                  <template #header>
                     <th>
                        <label>
                           <input v-model="selectAll" type="checkbox" @click="all" />
                        </label>
                     </th>
                     <th>Title</th>
                     <th>URL</th>
                     <th>&nbsp;</th>
                  </template>
                  <template #contents>
                     <tr v-for="page in pages.data" :key="page.id">
                        <td><input v-model="form.selected" type="checkbox" :value="page.id" /></td>
                        <td title="Name">{{ page.title }}</td>
                        <td title="Slug">{{ page.slug }}</td>
                        <td>
                           <ActionMenu>
                              <ActionLink :inertia="true" :link="route('page.edit', { pageID: page.id })">Edit</ActionLink>
                              <ActionButton @click="toggleHomepage(page)">
                                 <template v-if="page.is_homepage">Unset Homepage</template>
                                 <template v-else>Set as Home</template>
                              </ActionButton>
                              <ActionButton @click="togglePublish(page)">
                                 <template v-if="page.published">Unpublish</template>
                                 <template v-else>Publish</template>
                              </ActionButton>
                              <ActionButton @click="confirmDelete(page.id)">Delete</ActionButton>
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
               <inertia-link :href="route('page.create')" class="button:xlarge">Make Your First Page</inertia-link>
            </div>
         </div>
      </template>
   </Workspace>
</template>

<style lang="scss"></style>
