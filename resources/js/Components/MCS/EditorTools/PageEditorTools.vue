<script>
import EventBus from "@/Data/MCS/event-bus"
import Modal from "@/Components/Rebase/Modal"
import Icon from "@/Components/Rebase/Icon"
import { VueEditor } from "vue2-editor/dist/vue2-editor.core.js"
import "quill/dist/quill.snow.css"

export default {
   components: {
      Icon,
      Modal,
      EventBus,
      VueEditor,
   },

   props: {
      media: Object | Array,
   },
   computed: {
      editorOptions() {
         return { theme: "snow" }
      },
   },
   mounted: function () {
      let vm = this

      EventBus.$on("EDIT_COMPONENT", (targets) => {
         vm.show = true
         vm.targets = targets
      })
      EventBus.$on("CLOSE_DRAWER", () => {
         vm.show = false
      })
   },

   data() {
      return {
         show: false,
         targets: [],
         mediaTarget: null,
         gallery: this.media,
      }
   },

   methods: {
      loadImage(url, target) {
         target.style.backgroundImage = `url(${url})`
         EventBus.$emit("MODAL_CLOSE")
      },
      openMediaModal(target) {
         this.mediaTarget = target
         EventBus.$emit("MODAL_OPEN")
      },
      check(target, event, info) {
         if (info === "bg-image") {
            target.style.backgroundImage = `url(${event.target.value})`
         } else if (info === "url") {
            target.href = event.target.value
         } else if (info === "box-align") {
            target.classList.remove("grid--content-y:start", "grid--content-y:center", "grid--content-y:end")
            target.classList.add(event.target.value)
         } else if (info === "text-align") {
            target.classList.remove("text:left", "text:right", "text:center")
            target.classList.add(event.target.value)
         } else if (info === "opacity") {
            console.log("opacity")
            if (target.style.backgroundColor) {
               let opacity = parseInt(event.target.value) / 100
               opacity = opacity === 1 ? 0.99 : opacity === 0 ? 0.01 : opacity
               target.style.backgroundColor = target.style.backgroundColor.replace(/[^,]+(?=\))/, opacity)
            } else {
               target.style.backgroundColor = "rgba(255, 255, 255, 0.1)"
            }
         } else if (info === "opacity-color") {
            if (target.style.backgroundColor) {
               let current = target.style.backgroundColor
               target.style.backgroundColor = current.replace("255, 255, 255", event).replace("0, 0, 0", event)
            } else {
               target.style.backgroundColor = "rgba(255, 255, 255, 0.1)"
            }
         } else if (info === "flip") {
            if (target.style.direction) {
               target.style.direction = ""
            } else {
               target.style.direction = "rtl"
            }
         } else if (info === "editor") {
            target.innerHTML = event
            // console.log("Editor")
            console.log(target.innerHTML)
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
               <vue-editor
                  class="col-12"
                  :editorOptions="editorOptions"
                  :editor-toolbar="[['bold', 'italic', 'underline', 'strike'], [{ align: [false, 'center', 'right'] }], ['link'], [{ list: 'ordered' }, { list: 'bullet' }]]"
                  v-model="target.t.innerHTML"
                  @input="check(target.t, target.t.innerHTML, 'editor')"
               ></vue-editor>
            </div>
            <div class="grid" v-if="block.trim() == 'box-align'">
               <h5 class="col-12">Vertical Alignment</h5>
               <label class="col-4"
                  ><Icon name="align-top" /> <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid--content-y:start" :selected="!!target.t.classList.contains('grid--content-y:start')"
               /></label>
               <label class="col-4"
                  ><Icon name="align-middle" /> <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid--content-y:center" :selected="!!target.t.classList.contains('grid--content-y:center')"
               /></label>
               <label class="col-4"
                  ><Icon name="align-bottom" /> <input type="radio" name="box-align" @input="check(target.t, $event, 'box-align')" value="grid--content-y:end" :selected="!!target.t.classList.contains('grid--content-y:end')"
               /></label>
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
               <Button class="button--icon" @click="openMediaModal(target.t)"><Icon name="image" />&nbsp; &nbsp;Open Gallery</Button>
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
      <Modal>
         <template #header>Pick an Image</template>
         <template #body>
            <div class="grid">
               <div class="col-6 sm::col-4" v-for="(item, i) in gallery">
                  <img :src="item.url" alt="" @click="loadImage(item.url, mediaTarget)" />
               </div>
            </div>
         </template>
      </Modal>
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

.quillWrapper {
   display: flex;
   flex-direction: column;
   background: #fbfbfb;
}
.ql-toolbar {
   background-color: var(--color-true-white);
}
.ql-editor {
   font-size: var(--px-16);
   line-height: 1.3;
   min-height: 300px;
}
</style>
