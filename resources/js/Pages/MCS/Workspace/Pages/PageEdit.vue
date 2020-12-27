<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"
import ActionLink from "@/Components/Rebase/Actions/ActionLink"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import DataTable from "@/Components/Rebase/DataTable"

export default {
   layout: Layout,
   metaInfo: { title: "Pages" },

   components: {
      Workspace,
      ActionButton,
      ActionLink,
      ActionMenu,
      DataTable,
   },

   props: {
      pages: Array | Object,
      content: String,
   },

   data: () => ({
      sending: false,
      form: {},
   }),

   methods: {
      save() {
         const html = document.querySelector(".js-content").innerHTML
         console.log(html)
      },
   },
}
</script>

<template>
   <Workspace nav="pages">
      <template #header>Pages</template>
      <template #body>
         <div class="js-content" v-html="content"></div>
         <button @click="save">Save</button>
      </template>
   </Workspace>
</template>

<style lang="scss"></style>
