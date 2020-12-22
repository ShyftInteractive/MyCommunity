<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"

export default {
   layout: Layout,
   metaInfo: { title: "Documents and Media" },

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
   <Workspace nav="documents">
      <template #header>Documents &amp; Media</template>
      <template v-slot:body>
         <div class="grid"></div>
      </template>
   </Workspace>
</template>
