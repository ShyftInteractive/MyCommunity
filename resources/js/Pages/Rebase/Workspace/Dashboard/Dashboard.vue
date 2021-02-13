<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import { DTF } from "@/Data/MCS/Globals"
import BannerDisplay from "@/Templates/Rebase/Page/Components/BannerDisplay"

export default {
   layout: Layout,
   metaInfo: { title: "Dashboard" },

   components: {
      BannerDisplay,
      Workspace,
   },

   props: {
      events: Array | Object,
      banner: {
         type: Object,
         default: null,
      },
      messages: Array,
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
      <template v-slot:banner>
         <BannerDisplay :message="banner"></BannerDisplay>
      </template>
      <template #header>Dashboard</template>
      <template v-slot:body>
         <div class="grid--top">
            <div class="col-12 wd::col-8">
               <h3>Your Notices</h3>
               <p v-if="messages.length < 1">No notices at this time</p>
               <dl v-else class="dashboard--message" v-for="(message, i) in messages" :key="i">
                  <dt>{{ message.message }}</dt>
                  <dd v-html="message.details"></dd>
               </dl>
            </div>
            <div class="col-12 wd::col-4">
               <h3>Upcoming Events</h3>
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
      background-color: var(--color-true-white);
      border-bottom: 1px solid var(--color-gray-300);
      padding: var(--px-16);
   }
}

.dashboard--message {
   background-color: var(--color-true-white);
   border-bottom: 1px solid var(--color-gray-300);
   padding: var(--px-16);
   margin: var(--px-16) 0 0 0;

   &:first-of-type {
      margin-top: 0;
   }

   dt {
      font-size: var(--px-24);
      font-weight: 900;
      margin-bottom: var(--px-4);
   }
}
</style>
