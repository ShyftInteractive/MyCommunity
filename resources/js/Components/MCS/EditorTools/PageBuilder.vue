<script>
export default {
   components: {},

   props: {
      page: Array | Object,
   },

   data() {
      return {}
   },

   mounted: function () {
      const targets = document.querySelectorAll(".js-target")
      const vm = this

      targets.forEach(function (target) {
         vm.tools.push({
            label: target.getAttribute("data-label"),
            t: target,
            block: target.closest(".js-block"),
         })
      })

      const targetNode = document.querySelector(".js-content")
      const config = { attributes: true, childList: true, subtree: true }

      const callback = function (mutationsList, observer) {
         for (const mutation of mutationsList) {
            if (mutation.type === "attributes" && mutation.attributeName === "style") {
               let t = mutation.target
               let row = t.getAttribute("data-row")
               console.log(row)
               let col = t.getAttribute("data-col")
               if (row) vm.form.page.content[row][col].height = t.style.height
            }
         }
      }

      // Create an observer instance linked to the callback function
      const observer = new MutationObserver(callback)

      // Start observing the target node for configured mutations
      observer.observe(targetNode, config)
   },

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
   <div class="grid--top">
      <div class="col-12 sm::col-10">
         <div class="js-content">
            <div id="editor" class="mcs--template">
               <div class="grid" v-for="(row, index) in form.page.content" :key="index">
                  <div
                     class="js-block col-12"
                     v-for="(col, key) in row"
                     :class="col.center ? `md::col-${col.span}--centered` : `md::col-${col.span}`"
                     :key="`row-${index}-col-${key}`"
                     :style="{ height: `${col.height}` }"
                     :data-row="index"
                     :data-col="key"
                  >
                     <div class="mcs--component" v-html="col.component"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="page--editor">
            Tools:
            <div v-for="(tool, i) in tools" :key="i">
               {{ tool.label }}:<br />
               <div v-if="tool.t.classList.contains('js-link')">
                  <input type="text" @input="check(tool.t, $event)" />
                  <input type="text" @input="check(tool.t, $event, 'url')" />
               </div>
               <input v-else type="text" @input="check(tool.t, $event)" />
               <div v-if="tool.t.classList.contains('js-flex-alignment')">
                  <input type="radio" name="flex" value="top" @input="check(tool.t, $event)" />
                  <input type="radio" name="flex" value="middle" @input="check(tool.t, $event)" />
                  <input type="radio" name="flex" value="bottom" @input="check(tool.t, $event)" />
               </div>
            </div>
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
