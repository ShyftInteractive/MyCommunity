<script>
import Icon from "@/Components/Rebase/Icon"
import Layout from "@/Templates/Rebase/Layout"
import EventBus from "@/Data/MCS/event-bus"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"

export default {
   layout: Layout,
   metaInfo: { title: "Edit Template" },

   components: {
      Workspace,
      Icon,
      EventBus,
      ActionMenu,
      ActionButton,
   },

   props: {
      template: Array | Object,
      components: Array,
   },

   data() {
      return {
         sending: false,
         form: {
            template: this.template,
            component: {
               name: null,
               row: null,
               col: null,
            },
         },
      }
   },

   mounted() {
      document.addEventListener("keydown", (e) => {
         if (e.ctrlKey && e.which === 83) {
            this.save()
         }
      })
   },

   methods: {
      save() {
         EventBus.$emit("OPEN_DRAWER", false)
         this.$inertia.post(route("site-template.update", { templateID: this.form.template.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },

      pickComponent(name) {
         this.form.component["name"] = name

         this.save()
      },

      remove(row) {
         this.form.template.content.splice(row, 1)
      },
      readyContent(row, col) {
         this.form.component = {
            row: row,
            col: col,
         }

         EventBus.$emit("OPEN_DRAWER", true)
      },
      addNewRow(colCount, splits) {
         let colSpan = 12 / colCount
         let row = {
            height: "150px",
            cols: [],
         }

         let cols = []

         for (var i = 0; i < colCount; i++) {
            if (splits) {
               cols.push({
                  span: splits[i],
               })
            } else {
               cols.push({
                  span: colSpan,
               })
            }
         }
         row.cols = cols

         this.form.template.content.push(row)
      },

      adjustHeight(adjustment, index, e) {
         let currentHeight = this.form.template.content[index].height
         if (!currentHeight) {
            currentHeight = 150
         } else {
            currentHeight = parseInt(currentHeight)
         }

         currentHeight += adjustment
         this.form.template.content[index].height = `${currentHeight}px`
      },

      toggleLock(index) {},
   },
}
</script>

<template>
   <Workspace nav="site-settings" secondary="design" tertiary="templates" :drawer="true">
      <template #header>Editing Template: {{ form.template.name }}</template>
      <template #body>
         <div class="grid--top">
            <div class="col-11">
               <div class="js-content">
                  <div class="mcs--template">
                     <div class="grid--page js-grid" v-for="(row, index) in form.template.content" :key="index" :style="`min-height: ${row.height}`">
                        <ul class="row-options">
                           <li class="row-metadata">
                              <span class="help">
                                 <h2>Adjust the Row</h2>

                                 Row Height: {{ row.height }}
                              </span>
                           </li>
                           <li>
                              <button class="button--icon" @click="adjustHeight(-10, index, $event)" title="Decrease Height of Row"><Icon name="minus" size="20" /></button>
                           </li>
                           <li>
                              <button class="button--icon" @click="adjustHeight(10, index, $event)" title="Increase Height of Row"><Icon name="plus" size="20" /></button>
                           </li>
                           <li>
                              <Button class="button--icon" @click="remove(index)" title="Remove Whole Row"><Icon name="close" size="20" /></Button>
                           </li>
                        </ul>

                        <div :class="`col-12 md::col-${col.span}`" v-for="(col, key) in row.cols" :key="`row-${index}-col-${key}`" :data-row="index" :data-col="key">
                           <section class="component-picker">
                              <ActionMenu>
                                 <ActionButton @click="readyContent(index, key)">Add Content</ActionButton>
                              </ActionMenu>
                           </section>

                           <div v-html="col.component" style="height: 100%"></div>
                        </div>
                     </div>
                     <ActionMenu>
                        <template v-slot:buttonText><Icon name="plus-circle" /></template>
                        <ActionButton @click="addNewRow(1)">1 Column</ActionButton>
                        <ActionButton @click="addNewRow(2)">2 Columns</ActionButton>
                        <ActionButton @click="addNewRow(2, [8, 4])">2 80/20 Columns</ActionButton>
                        <ActionButton @click="addNewRow(2, [4, 8])">2 20/80 Columns</ActionButton>
                        <ActionButton @click="addNewRow(3)">3 Columns</ActionButton>
                        <ActionButton @click="addNewRow(4)">4 Columns</ActionButton>
                     </ActionMenu>
                  </div>
               </div>
            </div>
         </div>
      </template>
      <template #drawer>
         <div class="grid">
            <Button class="button col-12 sm::col-6" @click="save">Save</Button>
            <Button class="button--secondary col-12 sm::col-6" @click="save">Preview</Button>
            <img v-for="(component, i) in components" class="col-4" @click="pickComponent(component.name)" :src="`${component.image}`" />
         </div>
      </template>
   </Workspace>
</template>

<style lang="scss">
.grid--page {
   position: relative;

   .row-options:hover {
      background: rgba(#222, 0.8);
      width: calc(100% + 44px);
      color: #fff;

      .row-metadata {
         margin-bottom: -84px;
      }

      .help {
         display: block;
      }
   }
}
.component-picker {
   position: absolute;
   right: 20px;
   bottom: 0;
   z-index: 10;
}

.row-options {
   position: absolute;
   width: 40px;
   height: 100%;
   right: -44px;
   background: var(--color-coolGray-200);
   margin: 0;
   z-index: 1;
   list-style-type: none;
   border-bottom: 1px solid var(--color-coolGray-400);
   display: flex;
   align-items: flex-end;
   flex-direction: column;
   padding: var(--px-16) 0;
   transition: 250ms all;

   .row-metadata {
      font-size: var(--px-24);
      align-self: flex-start;
   }

   .help {
      display: none;
   }

   li {
      padding: 0 var(--px-16);

      &:last-of-type {
         flex-grow: 1;
         display: flex;
         align-items: flex-end;
      }
   }
}

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

.button--avatar {
   display: flex;
}
</style>
