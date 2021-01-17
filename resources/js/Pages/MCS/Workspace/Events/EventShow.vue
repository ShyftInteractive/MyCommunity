<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import { DTF } from "@/Data/MCS/Globals"

export default {
   layout: Layout,
   metaInfo: { title: `View Event` },

   components: {
      Workspace,
   },

   props: {
      event: Object,
   },
   data() {
      return {
         DTF,
         sending: false,
      }
   },

   methods: {},
}
</script>

<template>
   <Workspace nav="events">
      <template #header>{{ event.title }}</template>
      <template #body>
         <section class="grid">
            <div class="col-12 sm::col-4">
               <h1>{{ DTF(event.start_at).fullMonth() }} {{ DTF(event.start_at).day() }}</h1>

               <template v-if="DTF(event.start_at).day() !== DTF(event.end_at).day()">
                  <h1>{{ DTF(event.end_at).fullMonth() }} {{ DTF(event.end_at).day() }}</h1>
                  <h4>{{ DTF(event.end_at).fullTime() }}</h4>
               </template>
               <template v-else>
                  <h4>{{ DTF(event.start_at).fullTime() }} &mdash; {{ DTF(event.end_at).fullTime() }}</h4>
               </template>
            </div>
            <div class="col-12 sm::col-8">
               <h2>{{ event.title }}</h2>
               <div v-html="event.description"></div>
            </div>
         </section>
      </template>
   </Workspace>
</template>

<style lang="scss">
.quillWrapper {
   display: flex;
   flex-direction: column;
   background: #fbfbfb;
}
.ql-toolbar {
   background-color: var(--color-true-white);
}
.ql-editor {
   font-size: var(--px-16);
   line-height: 1.3;
   min-height: 300px;
}
</style>
