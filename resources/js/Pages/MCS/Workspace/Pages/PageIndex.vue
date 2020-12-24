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

   methods: {},
}
</script>

<template>
   <Workspace nav="pages">
      <template #header>Pages</template>
      <template #body v-if="pages.data.length > 0">
         <DataTable :links="pages.links">
            <template #header>
               <th>&nbsp;</th>
               <th>Title</th>
               <th>URL</th>
               <th>Status</th>
               <th>Role</th>
               <th>&nbsp;</th>
            </template>
            <template #contents>
               <tr v-for="page in pages.data" :key="page.id">
                  <td><input type="checkbox" /></td>
                  <td title="Name">{{ page.title }}</td>
                  <td title="Slug">{{ page.slug }}</td>
                  <td></td>
                  <td></td>
                  <td>
                     <ActionMenu>
                        <ActionLink link="#">Edit</ActionLink>
                        <ActionLink link="#">Publish</ActionLink>
                        <ActionButton>Delete</ActionButton>
                     </ActionMenu>
                  </td>
               </tr>
            </template>
         </DataTable>
      </template>
      <template #body v-else>
         <inertia-link :href="route('page.create')" class="button:xlarge">Add Your First Page</inertia-link>
      </template>
   </Workspace>
</template>

<style lang="scss">
.content-container {
   display: grid;
   justify-content: center;
   align-content: center;
   height: 100%;
}
</style>
