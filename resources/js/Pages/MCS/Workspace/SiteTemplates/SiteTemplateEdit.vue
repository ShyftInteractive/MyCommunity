<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import Icon from "@/Components/Rebase/Icon"
import Editor from "@/Components/Rebase/Form/Editor"

export default {
   layout: Layout,
   metaInfo: { title: "Edit Template" },

   components: {
      Workspace,
      Icon,
      Editor,
   },

   props: {
      template: Array | Object,
   },

   data() {
      return {
         sending: false,
         form: {
            template: this.template,
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
               if (row) vm.form.template.content[row][col].height = t.style.height
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
         this.$inertia.put(route("site-template.update", { templateID: this.form.template.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },

      pickComponent(event, row, col) {
         const uri = {
            templateID: this.form.template.id,
            id: event.target.value,
         }
         const data = {
            row: row,
            column: col,
         }
         this.$inertia.get(route("component.show", uri), data, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },

      addColumn(index) {
         this.form.template.content[index].push({ span: 2 })
      },

      resize(update, row, col, centered) {
         let currentSize = this.form.template.content[row][col].span
         if (centered) {
            update *= 2
         }

         let newSize = currentSize + update
         let totalSpanCount = this.spanCount(this.form.template.content[row]) + update

         if (newSize >= 1 && newSize <= 12 && totalSpanCount <= 12) {
            this.form.template.content[row][col].span = newSize
         }
      },

      remove(row, col) {
         this.form.template.content[row].splice(col, 1)

         if (this.form.template.content[row].length <= 0) {
            this.form.template.content.splice(row, 1)
         }
      },

      toggleCenter(row, col, centered) {
         let currentCol = this.form.template.content[row][col]
         if (this.form.template.content[row].length > 1) {
            return false
         }

         if (!currentCol.center && currentCol.span % 2 !== 0) {
            currentCol.span++
         }

         this.form.template.content[row][col].center = !this.form.template.content[row][col].center
      },

      spanCount(row) {
         let total = 0
         row.forEach(function (col) {
            total += col.span
         })

         return total
      },
      allowMoreColumns(rowIndex) {
         let row = this.form.template.content[rowIndex]
         if (row.length == 1 && row[0].center) {
            return false
         }

         return this.spanCount(row) < 12
      },

      addNewRow() {
         this.form.template.content.push([{ span: 4 }])
      },
   },
}
</script>

<template>
   <Workspace nav="site-settings" secondary="design" tertiary="templates">
      <template #header>Edit a Template</template>
      <template #body>
         <div class="grid--top">
            <div class="col-12 sm::col-10">
               <div class="js-content">
                  <div id="editor" class="mcs--template">
                     <div class="grid" v-for="(row, index) in form.template.content" :key="index">
                        <div
                           class="col-12"
                           v-for="(col, key) in row"
                           :class="col.center ? `md::col-${col.span}--centered` : `md::col-${col.span}`"
                           :key="`row-${index}-col-${key}`"
                           :style="{ height: `${col.height}` }"
                           :data-row="index"
                           :data-col="key"
                        >
                           <div class="mcs--component js-component">
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
                                    <li>
                                       <select @change="pickComponent($event, index, key)">
                                          <option value="">Pick a Component</option>
                                          <option value="hero">Hero</option>
                                          <option value="mediabox">Mediabox</option>
                                          <option value="card">Card</option>
                                       </select>
                                    </li>
                                    <li>
                                       <button @click="remove(index, key)"><Icon name="close" size="18" /></button>
                                    </li>
                                 </ul>
                              </div>
                              <div v-html="col.component"></div>
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
