<script>
import Icon from "@/Components/Rebase/Icon"
export default {
   components: {
      Icon,
   },

   props: {
      page: Array | Object,
   },

   data() {
      return {
         structure: this.page,
      }
   },

   mounted: function () {},

   methods: {},
}
</script>

<template>
   <div class="grid--top">
      <div class="col-12">
         <div class="js-content">
            <div class="mcs--template">
               <div class="mcs--template">
                  <!-- SLOT : ACTION MENU -->
                  <div class="grid--page js-grid" v-for="(row, rowIndex) in structure.content" :key="rowIndex" :style="`min-height: ${row.height}`">
                     <!-- SLOT : ROW OPTIONS -->
                     <div :class="`col-12 md::col-${col.span}`" v-for="(col, colIndex) in row.cols" :key="`row-${rowIndex}-col-${colIndex}`" :data-row="rowIndex" :data-col="colIndex">
                        <section class="component-picker">
                           <ActionMenu>
                              <ActionButton @click="edit(rowIndex, colIndex)">Edit Content</ActionButton>
                           </ActionMenu>
                        </section>

                        <div v-html="col.component" style="height: 100%"></div>
                     </div>
                  </div>
                  <!-- SLOT : ACTION MENU BOTTOM -->
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<style lang="scss">
@import "@@/abstract";
</style>
