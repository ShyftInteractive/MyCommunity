<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import { DTF } from "@/Data/MCS/Globals"

export default {
   layout: Layout,
   metaInfo: { title: "Dashboard" },

   components: {
      Workspace,
   },

   props: {
      events: Array | Object,
   },

   data: () => ({
      sending: false,
      DTF: DTF,
      form: {},
   }),

   methods: {},
}
</script>

<template>
   <Workspace nav="dashboard">
      <template #header>Dashboard</template>
      <template v-slot:body>
         <div class="grid">
            <div class="col-12 wd::col-8">
               <h3>Your Notices</h3>
               <p>No notices at this time</p>
            </div>
            <div class="col-12 wd::col-4">
               <h2>Upcoming Events</h2>
               <div v-if="events.length < 1">
                  <p>No upcoming events</p>
               </div>
               <ul v-else class="dashboard--events">
                  <li v-for="event in events" :key="event.id" class="grid">
                     <div class="col-12 sm::col-2">
                        <h5>{{ DTF(event.start_at).shortMonth() }}</h5>
                        <h1>
                           {{ DTF(event.start_at).day() }}
                        </h1>
                     </div>
                     <div class="col-12 sm::col-10">
                        <h3>{{ event.title }}</h3>
                        <p>{{ DTF(event.start_at).fullTime() }}</p>
                        <span v-html="event.description"></span>
                        <p>
                           <small><inertia-link :href="route('event.show', { eventID: event.id })">Learn More</inertia-link></small>
                        </p>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </template>
   </Workspace>
</template>

<style lang="scss">
.dashboard--events {
   list-style-type: none;
   padding: 0;
   margin: 0;

   li {
      border-bottom: 1px solid var(--color-gray-500);
      padding: var(--px-16);
      border-top: 1px solid var(--color-gray-500);

      &:last-of-type {
         border-bottom: 0;
      }
   }
}
</style>
