<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import Icon from "@/Components/Rebase/Icon"
import PageEditorTools from "@/Components/MCS/EditorTools/PageEditorTools"
import GridBuilder from "@/Components/MCS/EditorTools/GridBuilder"

export default {
   layout: Layout,
   metaInfo: { title: "Pages" },

   components: {
      Icon,
      Workspace,
      GridBuilder,
      PageEditorTools,
   },

   props: {
      page: Array | Object,
   },

   data() {
      return {
         sending: false,
         form: {
            page: this.page,
         },
      }
   },

   mounted: function () {},

   methods: {
      save() {
         let dirtyblocks = document.querySelectorAll(".block-is-dirty")
         let vm = this
         dirtyblocks.forEach(function (block) {
            let row = block.dataset.row
            let col = block.dataset.col

            vm.form.page.content[row][col].component = block.querySelector(".mcs--component").innerHTML
         })

         this.$inertia.put(route("page.update", { pageID: this.form.page.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="pages" :useDrawer="true">
      <template #header>Pages</template>
      <template #body>
         <div class="grid--top">
            <div class="col-12 sm::col-10">
               <GridBuilder :page="form.page"></GridBuilder>
            </div>
         </div>
      </template>
      <template #drawer>
         <PageEditorTools targetClass=".js-target" />
         <p>PREVIEW</p>
         <Button @click="save">Save</Button>
         <p>Publish</p>
         <p>Visible</p>
         <p>Change SLug</p>
         <p>Change Title</p>
         <p>Move</p>
         <p>Update Template</p>
      </template>
   </Workspace>
</template>

<style lang="scss">
@import "@@/abstract";
</style>
