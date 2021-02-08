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
   metaInfo: { title: "Events" },

   components: {
      Workspace,
      ActionButton,
      ActionLink,
      ActionMenu,
      DataTable,
   },
   props: {
      events: Array | Object,
   },

   data() {
      return {
         DTFormatter,
         sending: false,
         selectAll: false,
         form: {
            events: this.events,
            event: null,
            selected: [],
         },
      }
   },

   methods: {
      deleteSelected() {
         if (confirm(`Are you sure you want to delete ${this.form.selected.length} item(s)?`)) {
            this.$inertia.post(route("event.selected", { action: "delete" }), this.form, {
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
            })
         }
      },
      all() {
         this.form.selected = []
         if (!this.selectAll) {
            for (let i in this.events.data) {
               this.form.selected.push(this.events.data[i].id)
            }
         }
      },
      confirmDelete(id) {
         if (confirm("Are you sure you want to delete this event?")) {
            this.$inertia.delete(
               route("event.delete", { eventID: id }),
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
   <Workspace nav="events">
      <template #header>Events</template>
      <template #ribbon>
         <li><inertia-link :href="route('event.create')" class="button--secondary:small">Create a New Event</inertia-link></li>
         <li><Button @click="deleteSelected" class="button--secondary:small">Delete Selected Events</Button></li>
      </template>
      <template #body v-if="events.data.length > 0">
         <div class="grid">
            <div class="col-12">
               <DataTable :links="events.links">
                  <template #header>
                     <th>
                        <label>
                           <input v-model="selectAll" type="checkbox" @click="all" />
                        </label>
                     </th>
                     <th>Title</th>
                     <th>Starts At</th>
                     <th>Ends At</th>
                     <th>&nbsp;</th>
                  </template>
                  <template #contents>
                     <tr v-for="event in events.data" :key="event.id">
                        <td><input v-model="form.selected" type="checkbox" :value="event.id" /></td>
                        <td>{{ event.title }}</td>
                        <td>{{ DTFormatter(new Date(event.start_at)) }}</td>
                        <td>{{ event.end_at !== null ? DTFormatter(new Date(event.end_at)) : "All Day" }}</td>
                        <td>
                           <ActionMenu>
                              <ActionLink :inertia="true" :link="route('event.edit', { eventID: event.id })">Edit</ActionLink>
                              <ActionButton @click="confirmDelete(event.id)">Delete</ActionButton>
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
               <inertia-link :href="route('event.create')" class="button:xlarge">Create Your First Event</inertia-link>
            </div>
         </div>
      </template>
   </Workspace>
</template>
