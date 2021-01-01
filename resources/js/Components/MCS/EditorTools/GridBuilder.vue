<script>
export default {
   components: {},

   props: {
      page: Array | Object,
   },

   data() {
      return {
         structure: this.page,
      }
   },

   mounted: function () {
      const vm = this
      const targetNode = document.querySelector(".js-content")
      const config = { attributes: true, childList: true, subtree: true }

      const callback = function (mutationsList, observer) {
         for (const mutation of mutationsList) {
            if (mutation.type === "attributes" && mutation.attributeName === "style") {
               let t = mutation.target
               if (t.dataset.row) vm.structure.content[t.dataset.row][t.dataset.col].height = t.style.height
            }
         }
      }

      // Create an observer instance linked to the callback function
      const observer = new MutationObserver(callback)

      // Start observing the target node for configured mutations
      observer.observe(targetNode, config)
   },

   methods: {
      resize(update, row, col, centered) {
         let currentSize = this.structure.content[row][col].span
         if (centered) {
            update *= 2
         }

         let newSize = currentSize + update
         let totalSpanCount = this.spanCount(this.structure.content[row]) + update

         if (newSize >= 1 && newSize <= 12 && totalSpanCount <= 12) {
            this.structure.content[row][col].span = newSize
         }
      },
   },
}
</script>

<template>
   <div class="grid--top">
      <div class="col-12 sm::col-10">
         <div class="js-content">
            <div class="mcs--template">
               <div class="grid" v-for="(row, rowIndex) in structure.content" :key="rowIndex">
                  <div
                     class="js-block col-12"
                     v-for="(col, colIndex) in row"
                     :class="col.center ? `md::col-${col.span}--centered` : `md::col-${col.span}`"
                     :key="`row-${rowIndex}-col-${colIndex}`"
                     :style="{ height: `${col.height}` }"
                     :data-row="rowIndex"
                     :data-col="colIndex"
                  >
                     <div class="js-component mcs--component" v-html="col.component"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<style lang="scss">
@import "@@/abstract";
</style>
