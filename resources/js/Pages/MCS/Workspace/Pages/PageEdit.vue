<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"
import ActionLink from "@/Components/Rebase/Actions/ActionLink"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import DataTable from "@/Components/Rebase/DataTable"
import Icon from "@/Components/Rebase/Icon"

export default {
   layout: Layout,
   metaInfo: { title: "Pages" },

   components: {
      Workspace,
      ActionButton,
      ActionLink,
      ActionMenu,
      DataTable,
      Icon,
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

   methods: {
      save() {
         this.$inertia.put(
            route("page.update", { pageID: page.id }),
            {},
            {
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
            }
         )
      },
      addColumn(index) {
         this.form.page.content[index].push({
            span: 1,
            component: "",
            content: "",
            height: "400px",
         })
      },
      resize(update, row, col, centered) {
         let currentSize = this.form.page.content[row][col].span
         if (centered) {
            update *= 2
         }

         let newSize = currentSize + update

         if (newSize >= 1 && newSize <= 12) {
            this.form.page.content[row][col].span = newSize
         }
      },
      remove(row, col) {
         this.form.page.content[row].splice(col, 1)
         if (this.form.page.content[row].length <= 0) {
            this.form.page.content.splice(row, 1)
         }
      },
      toggleCenter(row, col, centered) {
         let currentCol = this.form.page.content[row][col]
         if (this.form.page.content[row].length > 1) {
            return false
         }

         if (!currentCol.center && currentCol.span % 2 !== 0) {
            currentCol.span++
         }

         this.form.page.content[row][col].center = !this.form.page.content[row][col].center
      },
      allowMoreColumns(row) {
         row = this.form.page.content[row]
         if (row.length == 1 && row[0].center) {
            return false
         }

         let total = 0
         row.forEach(function (col) {
            total += col.span
         })

         return total < 12
      },
      addNewRow() {
         this.form.page.content.push([
            {
               span: 4,
               center: true,
            },
         ])
      },
      componentPicker() {
         // this does need to trigger a save too
         this.$inertia.get(
            route("component.show", { componentID: "mediabox" }),
            {},
            {
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
            }
         )
      },
   },
}
</script>

<template>
   <Workspace nav="pages">
      <template #header>Pages</template>
      <template #body>
         <div class="grid--top">
            <div class="col-12 sm::col-10">
               <div class="js-content">
                  <div class="mcs--template">
                     <div class="grid" v-for="(row, index) in form.page.content" :key="index">
                        <div
                           v-model="form.page.content[index]"
                           class="col-12"
                           v-for="(col, key) in row"
                           :class="col.center ? `md::col-${col.span}--centered` : `md::col-${col.span}`"
                           :key="`row-${index}-col-${key}`"
                           :style="{ height: `${col.height}` }"
                        >
                           <div class="inner-stuff">
                              <button @click="resize(-1, index, key, col.center)"><Icon name="minus" /></button>
                              <button @click="resize(1, index, key, col.center)"><Icon name="plus" /></button>
                              <button @click="toggleCenter(index, key, col.center)" :disabled="row.length > 1">
                                 <Icon v-if="col.center" name="left" />
                                 <Icon v-else name="center" />
                              </button>
                              <button @click="remove(index, key)"><Icon name="close" /></button>
                           </div>
                           <div class="mcs--component">
                              <button @click="componentPicker">Pick a Component</button>
                           </div>
                        </div>
                        <button v-if="allowMoreColumns(index)" @click="addColumn(index)"><Icon name="plus" /></button>
                     </div>
                  </div>
                  <button @click="addNewRow">Add New Row</button>
               </div>
            </div>
            <div class="col-12 sm::col-2">
               <p>PREVIEW</p>
               <p>Save</p>
               <p>Publish</p>
               <p>Visible</p>
               <p>Change SLug</p>
               <p>Change Title</p>
               <p>Move</p>
               <p>Update Template</p>
            </div>
         </div>
      </template>
   </Workspace>
</template>

<style lang="scss">
.mcs--component {
}
</style>
