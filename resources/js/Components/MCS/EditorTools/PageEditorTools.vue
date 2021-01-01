<script>
export default {
   mounted: function () {
      const vm = this
      const targetList = document.querySelectorAll(vm.targetClass)

      targetList.forEach(function (target) {
         vm.targets.push({
            label: target.dataset.label,
            t: target,
            block: target.closest(".js-block"),
         })
      })
   },

   props: {
      targetClass: String,
   },
   data() {
      return {
         targets: [],
      }
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
   },
}
</script>

<template>
   <div>
      <div v-for="(target, i) in targets" :key="i">
         {{ target.label }}:<br />
         <div v-if="target.t.classList.contains('js-link')">
            <input type="text" @input="check(target.t, $event)" />
            <input type="text" @input="check(target.t, $event, 'url')" />
         </div>
         <input v-else type="text" @input="check(target.t, $event)" />
         <div v-if="target.t.classList.contains('js-flex-alignment')">
            <input type="radio" name="flex" value="top" @input="check(target.t, $event)" />
            <input type="radio" name="flex" value="middle" @input="check(target.t, $event)" />
            <input type="radio" name="flex" value="bottom" @input="check(target.t, $event)" />
         </div>
      </div>
   </div>
</template>

<style lang="scss">
@import "@@/abstract";
</style>
