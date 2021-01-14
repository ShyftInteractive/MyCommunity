<script>
import Icon from "@/Components/Rebase/Icon"
import EventBus from "@/Data/MCS/event-bus"

export default {
   name: "Modal",

   components: {
      Icon,
      EventBus,
   },

   mounted() {
      const vm = this

      EventBus.$on("MODAL_CLOSE", () => {
         vm.showModal = false
      })

      EventBus.$on("MODAL_OPEN", () => {
         vm.showModal = true
      })
   },

   data() {
      return {
         showModal: false,
      }
   },
}
</script>

<template>
   <portal to="overlay" v-if="showModal">
      <section class="modal">
         <div class="modal--container">
            <div class="modal--header">
               <div class="grid">
                  <div class="col-10">
                     <h2><slot name="header"> Modal Title </slot></h2>
                  </div>
                  <div class="col-2">
                     <Button class="button--icon" @click="showModal = false">
                        <Icon name="close" />
                     </Button>
                  </div>
               </div>
            </div>
            <div class="modal--body">
               <slot name="body"> Modal Title </slot>
            </div>
         </div>
         <div class="modal--screen"></div>
      </section>
   </portal>
</template>

<style lang="scss">
@import "@@/abstract";
$width: 90vw;
$height: 90vh;
$header-height: 80px;

.modal--screen {
   position: absolute;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   background: rgba(0, 0, 0, 0.5);
}

.modal--header {
   padding: var(--px-16);
   height: $header-height;
}

.modal--body {
   overflow: scroll;
   padding: var(--px-16);
   height: calc(#{$height} - #{$header-height} - 16px);
}
.modal--container {
   width: $width;
   height: $height;
   background: var(--color-true-white);
   position: absolute;
   top: calc((100vh - #{$height}) / 2);
   left: calc((100vw - #{$width}) / 2);
   z-index: 99999;
}
</style>
