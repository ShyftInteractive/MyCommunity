<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"
import ActionLink from "@/Components/Rebase/Actions/ActionLink"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import DataTable from "@/Components/Rebase/DataTable"
import { DTFormatter } from "@/Data/MCS/Globals"

export default {
   layout: Layout,
   metaInfo: { title: "Notification Center" },

   components: {
      Workspace,
      ActionButton,
      ActionLink,
      ActionMenu,
      DataTable,
   },

   props: {
      banners: Object | Array,
   },
   data() {
      return {
         DTFormatter,
         sending: false,
         selectAll: false,
         form: {
            selected: [],
         },
      }
   },
   methods: {
      all() {
         this.form.selected = []
         if (!this.selectAll) {
            for (let i in this.banners.data) {
               this.form.selected.push(this.banners.data[i].id)
            }
         }
      },
      confirmDelete(id) {
         if (confirm("Are you sure you want to delete this notification?")) {
            this.$inertia.delete(
               route("notification.delete", { notificationID: id }),
               {},
               {
                  onStart: () => (this.sending = true),
                  onFinish: () => (this.sending = false),
               }
            )
         }
      },
      toggleActivation(notification) {
         let confirmMessage = null
         if (notification.active === false) {
            confirmMessage = "Only one banner can be active at a time. Activating this banner will hide any currently active banners. OK?"
         } else {
            confirmMessage = "Are you sure you want to hide this banner?"
         }

         if (confirm(confirmMessage)) {
            this.$inertia.put(
               route("notification.update", { notificationID: notification.id }),
               {
                  active: !notification.active,
               },
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
   <Workspace nav="notification">
      <template #header>Notification Center</template>
      <template #ribbon>
         <li><inertia-link :href="route('notification.create')" class="button--secondary:small">Make a New Notification</inertia-link></li>
      </template>
      <template #body v-if="banners.data.length > 0">
         <div class="grid">
            <div class="col-12">
               <h3>Site Banners</h3>
               <DataTable :links="banners.links">
                  <template #header>
                     <th>
                        <label>
                           <input v-model="selectAll" type="checkbox" @click="all" />
                        </label>
                     </th>
                     <th>Message</th>
                     <th>Currently Active?</th>
                     <th>Show On</th>
                     <th>Remove On</th>
                     <th>&nbsp;</th>
                  </template>
                  <template #contents>
                     <tr v-for="banner in banners.data" :key="banner.id">
                        <td><input v-model="form.selected" type="checkbox" :value="banner.id" /></td>
                        <td v-html="banner.message"></td>
                        <td>{{ banner.active ? `Active` : `` }}</td>
                        <td>{{ banner.banner_display_at ? DTFormatter(new Date(banner_display_at)) : `` }}</td>
                        <td>{{ banner.banner_hide_at ? DTFormatter(new Date(banner_hide_at)) : `` }}</td>
                        <td>
                           <ActionMenu>
                              <ActionLink :inertia="true" :link="route('notification.edit', { notificationID: banner.id })">Edit</ActionLink>
                              <ActionButton @click="toggleActivation(banner)">
                                 <template v-if="banner.active">Deactivate</template>
                                 <template v-else>Activate</template>
                              </ActionButton>
                              <ActionButton @click="confirmDelete(banner.id)">Delete</ActionButton>
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
               <inertia-link :href="route('notification.create')" class="button:xlarge">Make Your First Notification</inertia-link>
            </div>
         </div>
      </template>
   </Workspace>
</template>
