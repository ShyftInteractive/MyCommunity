<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"

export default {
   layout: Layout,
   metaInfo: { title: "Dashboard" },

   components: {
      Workspace,
   },

   data: () => ({
      sending: false,
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
               <h3>Upcoming Events</h3>
               <p>No upcoming events</p>
            </div>
         </div>
      </template>
   </Workspace>
</template>
