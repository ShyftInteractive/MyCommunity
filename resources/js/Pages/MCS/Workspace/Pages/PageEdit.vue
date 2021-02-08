<script>
import Icon from "@/Components/Rebase/Icon"
import EventBus from "@/Data/MCS/event-bus"
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"
import PageEditorTools from "@/Components/MCS/EditorTools/PageEditorTools"

export default {
   layout: Layout,
   metaInfo: { title: "Pages" },

   components: {
      Icon,
      EventBus,
      Workspace,
      ActionMenu,
      ActionButton,
      PageEditorTools,
   },

   props: {
      page: Array | Object,
      media: Array | Object,
   },

   data() {
      return {
         sending: false,
         targets: [],
         drawer: false,
         modal: false,
         form: {
            page: this.page,
         },
      }
   },

   mounted() {
      let vm = this
      document.addEventListener("keydown", (e) => {
         if (e.ctrlKey && e.which === 83) {
            this.save()
         }
      })
   },

   methods: {
      save() {
         this.dirtyCheck()
         EventBus.$emit("OPEN_DRAWER", false)

         this.$inertia.put(route("page.update", { pageID: this.form.page.id }), this.form.page, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
      edit(event) {
         let vm = this
         vm.targets = []
         let component = event.target.closest(".js-col").querySelector("[data-component]")
         let targets = component.querySelectorAll("[data-target]")

         targets.forEach(function (target) {
            vm.targets.push({
               t: target,
            })
         })

         EventBus.$emit("EDIT_COMPONENT", vm.targets)
         EventBus.$emit("OPEN_DRAWER", true)
      },
      dirtyCheck() {
         let vm = this
         const dirtyblocks = document.querySelectorAll("[data-component='dirty']")

         dirtyblocks.forEach(function (block) {
            let row = block.parentElement.parentElement.dataset.row
            let col = block.parentElement.parentElement.dataset.col

            vm.form.page.content[row].cols[col].component = block.outerHTML
         })
      },
   },
}
</script>

<template>
   <Workspace nav="pages" :drawer="true">
      <template #header>Pages</template>
      <template #body>
         <div class="grid--top">
            <div class="col-11">
               <div class="grid--top">
                  <div class="col-12">
                     <div class="js-content">
                        <div class="mcs--template">
                           <div class="mcs--template">
                              <!-- SLOT : ACTION MENU -->

                              <div class="grid--page js-grid" v-for="(row, rowIndex) in form.page.content" :key="rowIndex" :style="`min-height: ${row.height}`">
                                 <!-- SLOT : ROW OPTIONS -->

                                 <div :class="`col-12 md::col-${col.span} js-col`" v-for="(col, colIndex) in row.cols" :key="`row-${rowIndex}-col-${colIndex}`" :data-row="rowIndex" :data-col="colIndex">
                                    <button class="button--icon action--icons" @click="edit($event)"><Icon name="edit" size="20" /></button>
                                    <div v-html="col.component" style="height: 100%"></div>
                                 </div>
                              </div>
                              <!-- SLOT : ACTION MENU BOTTOM -->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </template>
      <template #drawer>
         <div class="grid">
            <Button class="button col-12 sm::col-6" @click="save">Save</Button>
            <Button class="button--secondary col-12 sm::col-6" @click="save">Preview</Button>
         </div>
         <PageEditorTools :media="media" />
      </template>
   </Workspace>
</template>

<style lang="scss">
.grid--page {
   transition: all 250ms ease-in-and-out;
   &:hover {
      .row-options {
         opacity: 1;
         height: auto;
      }
   }
}
.component-picker {
   position: absolute;
   right: 20px;
   bottom: 0;
}
.row-options {
   position: absolute;
   bottom: 0;
   right: 0;
   width: 100%;
   margin: 0;
   z-index: 1;
   list-style-type: none;
   display: flex;
   justify-content: flex-end;

   li {
      background: rgba(255, 255, 255, 0.3);
      padding: 0 var(--px-12);
      display: inline-block;
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

.action--icons {
   position: absolute;
   bottom: 0;
   right: 10px;
   z-index: 2;
}
</style>
