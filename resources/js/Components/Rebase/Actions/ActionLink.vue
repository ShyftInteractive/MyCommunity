<script>
export default {
   name: "ActionLink",
   inheritAttrs: false,
   props: {
      link: String,
      inertia: {
         default: true,
         type: Boolean,
      },
   },
}
</script>

<template>
   <li v-if="inertia">
      <inertia-link :v-bind="$attrs" :href="link"><slot></slot></inertia-link>
   </li>
   <li v-else>
      <a :href="link" v-bind="$attrs" :title="link"><slot></slot></a>
   </li>
</template>
