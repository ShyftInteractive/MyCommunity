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
      pages: Array | Object,
      content: String,
   },

   data: () => ({
      sending: false,
      form: {},
      page: [
         [
            {
               span: 6,
               center: true,
               component: "",
               content: "",
               height: "400px",
            },
         ],
         [
            {
               span: 6,
               component: "card",
               content: "",
               height: "400px",
            },
            {
               span: 6,
               component: "foo",
               content: "",
               height: "400px",
            },
         ],
         [
            {
               span: 4,
               component: "card",
               content: "",
               height: "400px",
            },
            {
               span: 8,
               component: "foo",
               content: "",
               height: "400px",
            },
         ],
         [
            {
               span: 4,
               component: "card",
               content: "",
               height: "400px",
            },
            {
               span: 4,
               component: "card",
               content: "",
               height: "400px",
            },
            {
               span: 4,
               component: "foo",
               content: "",
               height: "400px",
            },
         ],
      ],
   }),

   methods: {
      save() {},
      addColumn(index) {
         this.page[index].push({
            span: 1,
            component: "",
            content: "",
            height: "400px",
         })
      },
      resize(update, row, col, centered) {
         let currentSize = this.page[row][col].span
         if (centered) {
            update *= 2
         }

         let newSize = currentSize + update

         if (newSize >= 1 && newSize <= 12) {
            this.page[row][col].span = newSize
         }
      },
      remove(row, col) {
         this.page[row].splice(col, 1)
         if (this.page[row].length <= 0) {
            this.page.splice(row, 1)
         }
      },
      toggleCenter(row, col, centered) {
         let currentCol = this.page[row][col]
         if (this.page[row].length > 1) {
            return false
         }

         if (!currentCol.center && currentCol.span % 2 !== 0) {
            currentCol.span++
         }

         this.page[row][col].center = !this.page[row][col].center
      },
      allowMoreColumns(row) {
         row = this.page[row]
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
         this.page.push([
            {
               span: 4,
               center: true,
            },
         ])
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
                     <div class="grid" v-for="(row, index) in page" :key="index">
                        <div v-model="page[index]" class="col-12" v-for="(col, key) in row" :class="col.center ? `md::col-${col.span}--centered` : `md::col-${col.span}`" :key="`row-${index}-col-${key}`" :style="{ height: `${col.height}` }">
                           <div class="">
                              <button @click="resize(-1, index, key, col.center)"><Icon name="minus" /></button>
                              <button @click="resize(1, index, key, col.center)"><Icon name="plus" /></button>
                              <button @click="toggleCenter(index, key, col.center)" :disabled="row.length > 1">
                                 <Icon v-if="col.center" name="left" />
                                 <Icon v-else name="center" />
                              </button>
                              <button @click="remove(index, key)"><Icon name="close" /></button>
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

<style lang="scss"></style>
