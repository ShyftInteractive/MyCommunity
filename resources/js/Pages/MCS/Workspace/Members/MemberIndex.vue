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
   metaInfo: { title: "Members" },

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
      deleteSelected() {
         if (confirm(`Are you sure you want to delete ${this.form.selected.length} item(s)?`)) {
            this.$inertia.post(route("member.selected", { action: "delete" }), this.form, {
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
      confirmDelete(id) {
         if (confirm("Are you sure you want to delete this member?")) {
            this.$inertia.delete(
               route("member.delete", { memberID: id }),
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
   <Workspace nav="site-settings" secondary="member">
      <template #header>Members</template>
      <template #ribbon>
         <li><Button @click="deleteSelected" class="button--secondary:small">Remove Selected Members</Button></li>
      </template>
      <template #body v-if="members.data.length > 0">
         <div class="grid">
            <div class="col-12">
               <DataTable :links="members.links" routeName="member.index">
                  <template #header>
                     <th>
                        <label>
                           <input v-model="selectAll" type="checkbox" @click="all" />
                        </label>
                     </th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Role</th>
                     <th>Verified</th>
                     <th>&nbsp;</th>
                  </template>
                  <template #contents>
                     <tr v-for="member in members.data" :key="member.id">
                        <td><input v-model="form.selected" type="checkbox" :value="member.id" /></td>
                        <td>{{ member.name }}</td>
                        <td>{{ member.email }}</td>
                        <td></td>
                        <td>
                           <template v-if="member.email_verified_at !== null">{{ DTFormatter(member.email_verified_at) }}</template>
                           <template v-else>Never Logged In</template>
                        </td>
                        <td>
                           <ActionMenu>
                              <ActionLink :inertia="true" :link="route('member.edit', { memberID: member.id })">Edit</ActionLink>
                              <ActionButton @click="confirmDelete(member.id)">Force Password Reset</ActionButton>
                              <ActionButton @click="confirmDelete(member.id)">Delete</ActionButton>
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
            <div class="col-8--centered sm::col-6--centered md::col-4--centered"></div>
         </div>
      </template>
   </Workspace>
</template>
