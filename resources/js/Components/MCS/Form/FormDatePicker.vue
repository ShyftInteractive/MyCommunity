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
      value: [String, Number, Date],
   },

   data() {
      return {
         dt: this.value === null ? null : new Date(this.value),
      }
   },

   methods: {
      handleInput(newDT) {
         this.dt = newDT
         this.$emit("input", newDT)
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
      :value="dt"
      @input="handleInput"
      :shortcuts="[
         {
            text: 'Now',
            onClick() {
               const date = new Date()
               return date
            },
         },
      ]"
      type="datetime"
      :disabled-date="notBeforeToday"
      :editable="false"
      value-type="date"
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
