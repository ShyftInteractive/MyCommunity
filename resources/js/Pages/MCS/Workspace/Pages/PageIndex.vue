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

   data: () => ({
      sending: false,
      form: {},
   }),

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
   },
}
</script>

<template>
   <Workspace nav="pages">
      <template #header>Pages</template>
      <template #ribbon>
         <li><inertia-link :href="route('page.create')" class="button:small">Make a New Page</inertia-link></li>
      </template>
      <template #body v-if="pages.data.length > 0">
         <div class="grid">
            <div class="col-12">
               <DataTable :links="pages.links">
                  <template #header>
                     <th>&nbsp;</th>
                     <th>Title</th>
                     <th>URL</th>
                     <th>&nbsp;</th>
                  </template>
                  <template #contents>
                     <tr v-for="page in pages.data" :key="page.id">
                        <td><input type="checkbox" /></td>
                        <td title="Name">{{ page.title }}</td>
                        <td title="Slug">{{ page.slug }}</td>
                        <td>
                           <ActionMenu>
                              <ActionLink :inertia="true" :link="route('page.edit', { pageID: page.id })">Edit</ActionLink>
                              <ActionLink link="#">Publish</ActionLink>
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
