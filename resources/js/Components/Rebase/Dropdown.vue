<script>
import Popper from "popper.js"

export default {
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
   },
   data() {
      return {
         show: false,
      }
   },
   watch: {
      show(show) {
         if (show) {
            this.$nextTick(() => {
               this.popper = new Popper(this.$el, this.$refs.dropdown, {
                  placement: this.placement,
                  modifiers: {
                     preventOverflow: { boundariesElement: this.boundary },
                  },
               })
            })
         } else if (this.popper) {
            setTimeout(() => this.popper.destroy(), 100)
         }
      },
   },
   mounted() {
      document.addEventListener("keydown", (e) => {
         if (e.keyCode === 27) {
            this.show = false
         }
      })
   },
}
</script>

<template>
   <button type="button" class="button--avatar" @click="show = true">
      <slot />
      <portal v-if="show" to="dropdown">
         <div>
            <div class="modal--screen" @click="show = false"></div>
            <div ref="dropdown" style="position: absolute; z-index: 99999" @click.stop="show = autoClose ? false : true">
               <div class="grid">
                  <div class="col-12">
                     <div class="menu">
                        <slot name="dropdown" />
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </portal>
   </button>
</template>

<style lang="scss">
@import "@@/abstract";

.button--avatar {
   align-content: center;
   background: transparent;
   border: none;
   cursor: pointer;
   display: inline-flex;
   font-size: var(--px-16);
   justify-content: center;
   line-height: var(--leading-normal);
   min-height: var(--px-40);
   padding: var(--px-8) 0;
   position: relative;
   text-align: center;
   text-decoration: none;
   white-space: nowrap;
}
.menu {
   background: var(--color-true-white);
   border-radius: var(--radius-2);
   border: 1px solid var(--color-blueGray-400);
}
</style>
