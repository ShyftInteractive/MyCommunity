<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"

export default {
   layout: Layout,
   metaInfo: { title: "Design Settings" },

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
   <Workspace nav="site-settings" secondary="design">
      <template #header>Design Settings</template>
      <template v-slot:body>
         <div class="grid"></div>
      </template>
   </Workspace>
</template>
