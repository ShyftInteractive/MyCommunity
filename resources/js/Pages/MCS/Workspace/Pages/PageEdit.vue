<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import Icon from "@/Components/Rebase/Icon"
import Editor from "@/Components/Rebase/Form/Editor"

export default {
   layout: Layout,
   metaInfo: { title: "Pages" },

   components: {
      Workspace,
      Icon,
      Editor,
   },

   props: {
      page: Array | Object,
   },

   data() {
      return {
         sending: false,
         tools: [],
         form: {
            page: this.page,
         },
      }
   },

   mounted: function () {},

   methods: {
      check(target, event, info) {
         if (target.classList.contains("js-bg-image")) {
            target.style.backgroundImage = `url(${event.target.value})`
         } else if (info === "url") {
            target.href = event.target.value
         } else {
            target.innerHTML = event.target.value
         }

         target.closest(".js-block").classList.add("block-is-dirty")
      },
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

      resize(update, row, col, centered) {
         let currentSize = this.form.page.content[row][col].span
         if (centered) {
            update *= 2
         }

         let newSize = currentSize + update
         let totalSpanCount = this.spanCount(this.form.page.content[row]) + update

         if (newSize >= 1 && newSize <= 12 && totalSpanCount <= 12) {
            this.form.page.content[row][col].span = newSize
         }
      },
   },
}
</script>

<template>
   <Workspace nav="pages" :useDrawer="true">
      <template #header>Pages</template>
      <template #body>
         <div class="grid--top">
            <div class="col-12 sm::col-10">one</div>
         </div>
      </template>
      <template #drawer> </template>
   </Workspace>
</template>

<style lang="scss">
@import "@@/abstract";

.page--editor {
   position: absolute;
   background-color: var(--color-coolGray-600);
   color: var(--color-coolGray-100);
   top: 40px;
   right: 0;
   bottom: 0;
   width: 100vw;

   @media ($sm-and-up) {
      width: 50%;
   }

   @media ($md-and-up) {
      width: 40%;
   }
}
</style>
