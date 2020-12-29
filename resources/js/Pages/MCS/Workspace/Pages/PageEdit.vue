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

   mounted: function () {
      const targetNode = document.querySelector(".js-content")
      const config = { attributes: true, childList: true, subtree: true }

      const vm = this
      const callback = function (mutationsList, observer) {
         for (const mutation of mutationsList) {
            if (mutation.type === "attributes" && mutation.attributeName === "style") {
               let t = mutation.target
               let row = t.getAttribute("data-row")
               let col = t.getAttribute("data-col")

               vm.form.page.content[row][col].height = t.style.height
            }
         }
      }

      // Create an observer instance linked to the callback function
      const observer = new MutationObserver(callback)

      // Start observing the target node for configured mutations
      observer.observe(targetNode, config)
   },

   methods: {
      save() {
         this.$inertia.put(route("page.update", { pageID: this.form.page.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
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
         let totalSpanCount = this.spanCount(this.form.page.content[row]) + update

         if (newSize >= 1 && newSize <= 12 && totalSpanCount <= 12) {
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
      spanCount(row) {
         let total = 0
         row.forEach(function (col) {
            total += col.span
         })

         return total
      },
      allowMoreColumns(rowIndex) {
         let row = this.form.page.content[rowIndex]
         if (row.length == 1 && row[0].center) {
            return false
         }

         return this.spanCount(row) < 12
      },
      addNewRow() {
         this.form.page.content.push([
            {
               span: 4,
            },
         ])
      },

      contentUpdate(event, rowIndex, column) {
         let p = event.target.closest(".js-component")
         this.form.page.content[rowIndex][column].component = p.innerHTML
      },
      componentPicker(row, column) {
         // this does need to trigger a save too
         this.$inertia.get(
            route("component.show", {
               pageID: this.form.page.id,
               id: "mediabox",
            }),
            {
               row: row,
               column: column,
            },
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
                           class="col-12"
                           v-for="(col, key) in row"
                           :class="col.center ? `md::col-${col.span}--centered` : `md::col-${col.span}`"
                           :key="`row-${index}-col-${key}`"
                           :style="{ height: `${col.height}` }"
                           :data-row="index"
                           :data-col="key"
                        >
                           <div class="column-menu">
                              <ul>
                                 <li>
                                    <button @click="resize(-1, index, key, col.center)"><Icon name="minus" size="18" /></button>
                                 </li>
                                 <li>
                                    <button @click="resize(1, index, key, col.center)"><Icon name="plus" size="18" /></button>
                                 </li>
                                 <li>
                                    <button @click="toggleCenter(index, key, col.center)" :disabled="row.length > 1">
                                       <Icon v-if="col.center" name="left" size="18" />
                                       <Icon v-else name="center" size="18" />
                                    </button>
                                 </li>
                                 <li><button @click="componentPicker(index, key)">Pick a Component</button></li>
                                 <li>
                                    <button @click="remove(index, key)"><Icon name="close" size="18" /></button>
                                 </li>
                              </ul>
                           </div>
                           <div class="mcs--component">
                              <div class="js-component" v-html="col.component" @focusout="contentUpdate($event, index, key)"></div>
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
               <Button @click="save">Save</Button>
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
.grid > .col-12 {
   position: relative;
}

.column-menu {
   position: absolute;
   width: 100%;

   ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      li {
         display: inline-block;
         margin: 0;
         padding: 0;
      }
   }

   button {
      border: 0;
      background: #ccc;
      padding: var(--px-4);
      margin: var(--px-4);
   }
}
</style>
