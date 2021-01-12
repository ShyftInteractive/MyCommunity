<script>
import EventBus from "@/Data/MCS/event-bus"

export default {
   components: {
      EventBus,
   },
   mounted: function () {
      let vm = this

      EventBus.$on("EDIT_COMPONENT", (targets) => {
         vm.targets = targets
         vm.targets.forEach((t) => {
            console.log(t.t.dataset.target.split(","))
         })
      })
   },

   data() {
      return {
         targets: [],
      }
   },

   methods: {
      check(target, event, info) {
         if (info === "bg-image") {
            target.style.backgroundImage = `url(${event.target.value})`
         } else if (info === "url") {
            target.href = event.target.value
         } else if (info === "box-align") {
            target.classList.remove("grid:top", "grid:middle", "grid:bottom")
            target.classList.add(event.target.value)
         } else if (info === "text-align") {
            target.classList.remove("text:left", "text:right", "text:center")
            target.classList.add(event.target.value)
         } else if (info === "opacity") {
            let opacity = parseInt(event.target.value) / 100
            target.style.backgroundColor = `rgba(255,255,255, ${opacity})`
         } else {
            target.innerHTML = event.target.value
         }

         target.closest("[data-component]").setAttribute("data-component", "dirty")
      },
   },
}
</script>

<template>
   <div>
      <div class="grid" v-for="(target, i) in targets" :key="i">
         <div class="col-12" v-for="(block, ii) in target.t.dataset.target.split(',')" :key="ii">
            <div class="grid" v-if="block == 'text'">
               <h5 class="col-12">Text</h5>
               <input type="text" class="form-item--textbox col-12" @input="check(target.t, $event)" :value="target.t.innerText" />
            </div>
            <div class="grid" v-if="block.trim() == 'box-align'">
               <h5 class="col-12">Vertical Alignment</h5>
               <label class="col-4">Top: <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid:top" :selected="target.t.classList.contains('grid:top')" /></label>
               <label class="col-4">Middle: <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid:middle" :selected="target.t.classList.contains('grid:middle')" /></label>
               <label class="col-4">Bottom: <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid:bottom" :selected="target.t.classList.contains('grid:bottom')" /></label>
            </div>
            <div class="grid" v-if="block.trim() == 'text-align'">
               <h5 class="col-12">Text Alignment</h5>
               <label class="col-4">Left: <input type="radio" name="text-align" @input="check(target.t, $event, 'text-align')" value="text:left" :selected="target.t.classList.contains('text:left')" /></label>
               <label class="col-4">Center: <input type="radio" name="text-align" @input="check(target.t, $event, 'text-align')" value="text:center" :selected="target.t.classList.contains('text:center')" /></label>
               <label class="col-4">Right: <input type="radio" name="text-align" @input="check(target.t, $event, 'text-align')" value="text:right" :selected="target.t.classList.contains('text:right')" /></label>
            </div>
            <div class="grid" v-if="block.trim() == 'link'">
               <h5 class="col-12">Button</h5>
               <label class="col-6"> Link Text: <input class="form-item--textbox col-6" type="text" @input="check(target.t, $event)" :value="target.t.innerText" /> </label>
               <label class="col-6"> URL: <input class="form-item--textbox" type="text" @input="check(target.t, $event, 'url')" :value="target.t.href" /> </label>
            </div>
            <div class="grid" v-if="block.trim() == 'bg-image'">
               <h5 class="col-12">Background Image</h5>
               <input type="text" class="form-item--textbox col-12" @input="check(target.t, $event, 'bg-image')" :value="target.t.style.backgroundImage.replace('url(', '').replace(')', '')" />
            </div>
            <div class="grid" v-if="block.trim() == 'opacity'">
               <h5 class="col-12">Background Opacity</h5>
               <input class="form-item--textbox col-12" type="range" min="1" max="100" value="0" @input="check(target.t, $event, 'opacity')" />
            </div>
         </div>
      </div>
   </div>
</template>

<style lang="scss">
@import "@@/abstract";

.form-item--textbox {
   @include form-element;
}
</style>
