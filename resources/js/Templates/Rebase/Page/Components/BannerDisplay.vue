<script>
export default {
   components: {},
   props: {
      message: {
         type: Object,
         default: false,
      },
   },
}
</script>

<template>
   <div class="banner-notification" v-if="message !== false">
      <div v-html="message"></div>
   </div>
</template>

<style lang="scss" scoped>
@import "@@/abstract";

.banner-notification {
   background-color: var(--color-coolGray-400);
   color: var(--color-coolGray-800);
   display: flex;
   padding: var(--px-16);
}
</style>
