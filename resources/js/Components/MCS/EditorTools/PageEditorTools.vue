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
         if (target.dataset.target === "bg-image") {
            target.style.backgroundImage = `url(${event.target.value})`
         } else if (info === "url") {
            target.href = event.target.value
         } else if (info === "box-align") {
            target.classList.remove("grid:top", "grid:middle", "grid:bottom")
            target.classList.add(event.target.value)
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
         <h5 class="col-12">{{ target.label }}</h5>
         <div class="grid" v-for="(block, ii) in target.t.dataset.target.split(',')" :key="ii">
            <input v-if="block == 'text'" type="text" class="form-item--textbox col-12" @input="check(target.t, $event)" :value="target.t.innerText" />

            <template v-if="block.trim() == 'box-align'">
               <label>Top: <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid:top" :selected="target.t.classList.contains('grid:top')" /></label>
               <label>Middle: <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid:middle" :selected="target.t.classList.contains('grid:middle')" /></label>
               <label>Bottom: <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid:bottom" :selected="target.t.classList.contains('grid:bottom')" /></label>
            </template>
            <label v-if="block.trim() == 'link'" class="col-6"> Link Text: <input class="form-item--textbox col-6" type="text" @input="check(target.t, $event)" :value="target.t.innerText" /> </label>
            <label v-if="block.trim() == 'link'" class="col-6"> URL: <input class="form-item--textbox" type="text" @input="check(target.t, $event, 'url')" :value="target.t.href" /> </label>
            <input v-if="block.trim() == 'bg-image'" type="text" class="form-item--textbox col-12" @input="check(target.t, $event)" :value="target.t.style.backgroundImage.replace('url(', '').replace(')', '')" />
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
