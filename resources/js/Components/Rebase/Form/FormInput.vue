<script>
import { slugify } from "@/Data/MCS/Globals"

export default {
   name: "FormInput",
   inheritAttrs: false,

   props: {
      slugify: {
         type: Boolean,
         default: false,
      },
      value: [String, Number],
   },

   methods: {
      handleInput(e) {
         if (this.slugify) {
            this.$emit("input", slugify(e.target.value))
         } else {
            this.$emit("input", e.target.value)
         }
      },
   },
}
</script>

<template>
   <input class="form-item--textbox" ref="input" v-bind="$attrs" :value="value" @input="handleInput" />
</template>

<style lang="scss" scoped>
@import "@@/abstract";

.form-item--textbox {
   @include form-element;
}
</style>
