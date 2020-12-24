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
   },

   data: () => ({
      sending: false,
      form: {},
   }),

   methods: {},
}
</script>

<template>
   <Workspace nav="pages">
      <template #header>Pages</template>
      <template #body> Welcome to the edit screen </template>
   </Workspace>
</template>

<style lang="scss"></style>
