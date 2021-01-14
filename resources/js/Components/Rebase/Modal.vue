<script>
import Popper from "popper.js"

export default {
   name: "Modal",

   components: {},

   props: {
      placement: {
         type: String,
         default: "bottom-end",
      },
      boundary: {
         type: String,
         default: "scrollParent",
      },
      autoClose: {
         type: Boolean,
         default: true,
      },
      title: {
         type: String,
      },
      message: {
         type: String,
      },
      type: {
         type: String,
         default: "general",
      },
      listing: {
         type: Object | Array,
         default: () => [],
      },
   },

   data() {
      return { modalShow: true }
   },

   mounted() {
      document.addEventListener("keydown", (e) => {
         if (e.keyCode === 27) {
            this.modalShow = false
         }
      })
   },

   methods: {},

   watch: {
      modalShow(modalShow) {
         if (modalShow) {
            this.$nextTick(() => {
               this.popper = new Popper(this.$el, this.$refs.overlay, {
                  placement: this.placement,
                  modifiers: {
                     preventOverflow: { boundariesElement: this.boundary },
                  },
               })
            })
         }
      },
   },
}
</script>

<template>
   <portal v-if="modalShow" to="overlay">
      <section class="modal">
         <div class="modal--container">
            <div class="modal--header">
               <slot name="header"></slot>
            </div>
            <div class="modal--body">
               <slot name="body"></slot>
            </div>
            <div class="modal--footer">
               <slot name="footer"></slot>
            </div>
         </div>
         <div class="modal--shade"></div>
      </section>
   </portal>
</template>
