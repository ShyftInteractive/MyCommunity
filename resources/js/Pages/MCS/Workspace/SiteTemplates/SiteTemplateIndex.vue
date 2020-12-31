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
      templates: Array | Object,
   },

   data: () => ({
      sending: false,
   }),

   methods: {
      confirmActivate(id) {
         if (confirm("Activating this template means others can create pages with it. Are you sure?")) {
            this.$inertia.put(
               route("site-template.update", { templateID: id }),
               {
                  template: {
                     active: true,
                  },
               },
               {
                  onStart: () => (this.sending = true),
                  onFinish: () => (this.sending = false),
               }
            )
         }
      },
      confirmDeactivate(id) {
         if (confirm("Deactivating a template means you won't be able to create new pages, all previously created pages will be untouched")) {
            this.$inertia.put(
               route("site-template.update", { templateID: id }),
               {
                  template: {
                     active: false,
                  },
               },
               {
                  onStart: () => (this.sending = true),
                  onFinish: () => (this.sending = false),
               }
            )
         }
      },
      confirmDelete(id) {
         if (confirm("Are you sure you want to delete this template?")) {
            this.$inertia.delete(
               route("site-template.delete", { templateID: id }),
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
   <Workspace nav="site-settings" secondary="design" tertiary="templates">
      <template #header>Website Templates</template>
      <template #ribbon>
         <li><inertia-link :href="route('site-template.create')" class="button:small">Make a New Page Template</inertia-link></li>
      </template>
      <template #body v-if="templates.data.length > 0">
         <div class="grid">
            <div class="col-12">
               <DataTable :links="templates.links">
                  <template #header>
                     <th>&nbsp;</th>
                     <th>Name</th>
                     <th>Active?</th>
                     <th>&nbsp;</th>
                  </template>
                  <template #contents>
                     <tr v-for="template in templates.data" :key="template.id">
                        <td><input type="checkbox" /></td>
                        <td title="Name">{{ template.name }}</td>
                        <td title="Active">{{ template.active ? `Yes` : `No` }}</td>
                        <td>
                           <ActionMenu>
                              <ActionLink :inertia="true" :link="route('site-template.edit', { templateID: template.id })">Update</ActionLink>
                              <ActionButton @click="confirmDeactivate(template.id)" v-if="template.active">Deactivate</ActionButton>
                              <ActionButton @click="confirmActivate(template.id)" v-else>Activate</ActionButton>
                              <ActionButton @click="confirmDelete(template.id)">Delete</ActionButton>
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
               <inertia-link :href="route('site-template.create')" class="button:xlarge">Make Your First Page Template</inertia-link>
            </div>
         </div>
      </template>
   </Workspace>
</template>

<style lang="scss"></style>
