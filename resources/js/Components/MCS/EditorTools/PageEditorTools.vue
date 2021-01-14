<script>
import EventBus from "@/Data/MCS/event-bus"
import Editor from "@/Components/MCS/EditorTools/Editor"

export default {
   components: {
      EventBus,
      Editor,
   },
   mounted: function () {
      let vm = this

      EventBus.$on("EDIT_COMPONENT", (targets) => {
         console.log("edit ")
         vm.targets = []
         vm.targets = targets

         console.log(vm.targets)
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
            opacity = opacity === 1 ? 0.99 : opacity === 0 ? 0.01 : opacity
            target.style.backgroundColor = target.style.backgroundColor.replace(/[^,]+(?=\))/, opacity)
         } else if (info === "opacity-color") {
            let current = target.style.backgroundColor
            target.style.backgroundColor = current.replace("255, 255, 255", event).replace("0, 0, 0", event)
         } else if (info === "flip") {
            if (target.style.direction) {
               target.style.direction = ""
            } else {
               target.style.direction = "rtl"
            }
         } else if (info === "editor") {
            target.innerHTML = event
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
            <div class="grid" v-if="block == 'headline'">
               <h5 class="col-12">Headline</h5>
               <input type="text" class="form-item--textbox col-12" @input="check(target.t, $event)" :value="target.t.innerText" />
            </div>
            <div class="grid" v-if="block.trim() === 'editor'">
               <h5 class="col-12">Editor</h5>
               <input type="text" class="form-item--textbox col-12" @input="check(target.t, $event)" :value="target.t.innerText" />
            </div>
            <div class="grid" v-if="block.trim() == 'box-align'">
               <h5 class="col-12">Vertical Alignment</h5>
               <label class="col-4">Top: <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid:top" :selected="!!target.t.classList.contains('grid:top')" /></label>
               <label class="col-4">Middle: <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid:middle" :selected="!!target.t.classList.contains('grid:middle')" /></label>
               <label class="col-4">Bottom: <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid:bottom" :selected="!!target.t.classList.contains('grid:bottom')" /></label>
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
               <ul class="opacity-color-picker col-12">
                  <li class="white" @click="check(target.t, '255, 255, 255', 'opacity-color')"></li>
                  <li class="black" @click="check(target.t, '0, 0, 0', 'opacity-color')"></li>
               </ul>
               <input class="form-item--textbox col-12" type="range" min="1" max="100" name="opacity-value" :value="0" @input="check(target.t, $event, 'opacity')" />
            </div>
            <div class="grid" v-if="block.trim() == 'flip'">
               <h5 class="col-12">Reverse Image Text</h5>
               <label class="col-4">Reverse: <input type="checkbox" name="reverse" @input="check(target.t, $event, 'flip')" :value="!!target.t.style.direction" :checked="target.t.style.direction" /></label>
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

.form-item--editor {
   @include form-element;
   min-height: 120px;
}

.opacity-color-picker {
   list-style-type: none;
   display: inline-block;
   padding: 0;
   margin: 0;

   li {
      display: inline-block;
      border: 1px solid #ddd;
      width: 20px;
      height: 20px;
      margin: 0px;
      cursor: pointer;
      &.white {
         background: var(--color-true-white);
      }

      &.black {
         background: var(--color-true-black);
      }
   }
}
</style>
