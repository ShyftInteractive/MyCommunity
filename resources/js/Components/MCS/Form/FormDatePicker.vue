<script>
import DatePicker from "vue2-datepicker"
import "vue2-datepicker/index.css"

export default {
   name: "FormDatePicker",
   inheritAttrs: false,

   components: {
      DatePicker,
   },

   props: {
      value: [String, Number],
   },

   methods: {
      handleInput(e) {
         this.$emit("input", e)
      },
      notBeforeToday(date) {
         return date < new Date(new Date().setHours(0, 0, 0, 0))
      },
   },
}
</script>

<template>
   <date-picker
      v-bind="$attrs"
      :value="value"
      @input="handleInput"
      :shortcuts="[
         {
            text: 'Publish Now',
            onClick() {
               const date = new Date()
               return date
            },
         },
      ]"
      type="datetime"
      :disabled-date="notBeforeToday"
      :editable="false"
      value-type="YYYY-MM-DDTHH:mm:ss"
      format="MM-DD-YYYY hh:mm:ss A"
      :time-picker-options="{
         start: '00:00',
         step: '00:15',
         end: '23:45',
      }"
   >
   </date-picker>
</template>

<style lang="scss">
@import "@@/abstract";

.mx-datepicker {
   width: 100%;
}
.mx-input {
   @include form-element;
}
</style>
