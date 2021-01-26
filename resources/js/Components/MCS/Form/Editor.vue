<script>
import { VueEditor } from "vue2-editor/dist/vue2-editor.core.js"
import EventBus from "@/Data/MCS/event-bus"
import "quill/dist/quill.snow.css"
import "quill/dist/quill.bubble.css"

export default {
   name: "Editor",

   components: {
      EventBus,
      VueEditor,
   },

   props: {
      bubble: {
         default: false,
         type: Boolean,
      },
      tools: {
         type: Array,
         default: () => [["bold", "italic", "underline", "strike"], [{ align: [false, "center", "right"] }], ["link"], [{ list: "ordered" }, { list: "bullet" }]],
      },
      extraTools: {
         type: Array,
         default: () => [],
      },
      value: String,
   },

   data() {
      return {
         editorTools: this.tools,
      }
   },

   computed: {
      editorOptions() {
         return {
            theme: this.bubble ? "bubble" : "snow",
         }
      },
      editorContent: {
         get() {
            return this.content
         },
         set(updatedContent) {
            this.$emit("update:content", updatedContent)
         },
      },
   },

   methods: {
      handleInput(e) {
         let vm = this
      },
   },
}
</script>

<template>
   <vue-editor v-bind="$attrs" v-model="editorContent" :editorOptions="editorOptions" :editor-toolbar="editorTools" @input="handleInput($event)"></vue-editor>
</template>

<style lang="scss">
@import "@@/abstract";
</style>
