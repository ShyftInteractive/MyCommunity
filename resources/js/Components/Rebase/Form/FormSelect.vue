<script>
export default {
   inheritAttrs: false,
   components: {},

   props: {
      defaultText: {
         type: String,
         default: "Select",
      },
      value: [String, Number, Boolean],
      options: Array | Object,
   },

   methods: {
      handleInput(e) {
         this.$emit("input", e.target.value)
      },
   },
}
</script>

<template>
   <select class="form-item--select" ref="select" v-bind="$attrs" @input="handleInput">
      <option value="" v-if="defaultText !== ''">{{ defaultText }}</option>
      <option v-for="option in options" :key="option" :value="option" :selected="option === value">{{ option }}</option>
      <slot></slot>
   </select>
</template>

<style lang="scss" scoped>
@import "@@/abstract";

.form-item--select {
   @include form-element {
      -moz-appearance: none;
      -webkit-appearance: none;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-chevron-down'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
      background-position: calc(100% - 10px) center;
      background-repeat: no-repeat, repeat;
      background-size: var(--px-16) auto;
      cursor: pointer;
      max-width: 100%;
      padding-right: var(--px-24);

      > option {
         padding: 0;
      }
   }
}

@-moz-document url-prefix() {
   .form-item__select {
      padding-left: var(--px-4); // This is needed for Firefox which does something shitty with padding
   }
}
</style>
