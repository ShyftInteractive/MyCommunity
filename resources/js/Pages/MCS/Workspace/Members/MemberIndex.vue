<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"
import ActionLink from "@/Components/Rebase/Actions/ActionLink"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import DataTable from "@/Components/Rebase/DataTable"
import { DTFormatter } from "@/Data/MCS/Globals"
import Listing from "@/Mixins/Listing"

export default {
   layout: Layout,
   metaInfo: { title: "Members" },
   mixins: [Listing],

   components: {
      Workspace,
      ActionButton,
      ActionLink,
      ActionMenu,
      DataTable,
   },
   props: {
      members: Array | Object,
   },

   data() {
      return {
         DTFormatter,
         sending: false,
         selectAll: false,
         form: {
            members: this.member,
            member: null,
            selected: [],
         },
      }
   },

   methods: {
      selectedAction(type, message) {
         let fullMessage = message ?? `Are you sure you want to ${type} ${this.form.selected.length} item(s)?`
         if (confirm(fullMessage)) {
            this.$inertia.post(route("member.selected", { action: type }), this.form, {
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
            })
         }
      },
      all() {
         this.form.selected = []
         if (!this.selectAll) {
            for (let i in this.members.data) {
               this.form.selected.push(this.members.data[i].id)
            }
         }
      },
   },
}
</script>

<template>
   <Workspace nav="site-settings" secondary="member">
      <template #header>Members</template>
      <template #ribbon>
         <li><inertia-link :href="route('member.create')" class="button:small">Add A Member</inertia-link></li>
      </template>
      <template #body>
         <div class="grid">
            <div class="col-12">
               <DataTable :links="members.links" routeName="member.index">
                  <template #tableActions>
                     <ActionMenu>
                        <ActionButton @click="selectedAction('delete')">Remove Selected</ActionButton>
                        <ActionButton @click="selectedAction('activate')">Activate Selected</ActionButton>
                        <ActionButton @click="selectedAction('deactivate')">Deactivate Selected</ActionButton>
                        <ActionButton @click="selectedAction('reset')">Reset Passwords</ActionButton>
                        <ActionButton @click="selectedAction('activate-all', 'Are you sure you want to activate everyone?')">Activate All</ActionButton>
                        <ActionButton @click="selectedAction('deactivate-all', 'Are you sure you want to deactivate everyone (you will not be deactivated)')">Deactivate All</ActionButton>
                     </ActionMenu>
                  </template>
                  <template #header>
                     <th>
                        <label>
                           <input v-model="selectAll" type="checkbox" @click="all" />
                        </label>
                     </th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Role</th>
                     <th>Activated</th>
                     <th>Verified</th>
                     <th>&nbsp;</th>
                  </template>
                  <template #contents v-if="members.data.length > 0">
                     <tr v-for="member in members.data" :key="member.id">
                        <td><input v-model="form.selected" type="checkbox" :value="member.id" /></td>
                        <td>{{ member.name }}</td>
                        <td>{{ member.email }}</td>
                        <td>{{ member.role }}</td>
                        <td>
                           <template v-if="member.activated">Activated</template>
                           <template v-else>Not Activated</template>
                        </td>
                        <td>
                           <template v-if="member.email_verified_at !== null">{{ DTFormatter(member.email_verified_at) }}</template>
                           <template v-else>Never Logged In</template>
                        </td>
                        <td>
                           <ActionMenu>
                              <ActionLink :inertia="true" :link="route('member.edit', { memberID: member.id })">Edit</ActionLink>
                              <ActionButton @click="confirmDelete(member.id)">Force Password Reset</ActionButton>
                              <ActionButton @click="listingDelete(route('member.delete', { memberID: member.id }))">Delete</ActionButton>
                           </ActionMenu>
                        </td>
                     </tr>
                  </template>
                  <template #contents v-else>
                     <tr>
                        <td colspan="7">No Items Found</td>
                     </tr>
                  </template>
               </DataTable>
            </div>
         </div>
      </template>
   </Workspace>
</template>
