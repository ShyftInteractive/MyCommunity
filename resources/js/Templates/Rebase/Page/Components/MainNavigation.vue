<script>
import Icon from "@/Components/Rebase/Icon"

export default {
   components: {
      Icon,
   },

   data: function () {
      return {
         isOpen: false,
      }
   },

   created: function () {
      let vm = this
      window.addEventListener("resize", function () {
         vm.isOpen = false
      })
   },

   watch: {
      isOpen: function () {
         this.toggleNavigation()
      },
   },

   methods: {
      toggleNavigation() {
         let aside = document.querySelector(".js-sidebar")
         let nav = document.querySelector(".js-nav")

         aside.style.height = this.isOpen ? "100vh" : ""
         aside.style.zIndex = this.isOpen ? "12" : ""
         nav.style.display = this.isOpen ? "block" : ""
      },
   },
}
</script>

<template>
   <section>
      <Button class="button--icon nav-button js-button" @click="isOpen = !isOpen">
         <Icon name="hamburger" />
      </Button>
      <nav class="navigation--main js-nav">
         <ul>
            <slot></slot>
         </ul>
      </nav>
   </section>
</template>

<style lang="scss" scoped>
@import "@@/abstract";

.nav-button {
   color: var(--color-blueGray-400);
   @media ($md-and-up) {
      display: none;
   }
}

.navigation--main {
   display: none;
   font-size: var(--px-16);
   letter-spacing: var(--kerning-tighter);
   color: var(--color-blueGray-400);

   a {
      text-decoration: none;
      transition: 350ms all ease-in;
      display: block;
      line-height: 3;

      &:hover,
      &.selected {
         color: var(--color-blueGray-100);
      }
      &.selected {
         font-weight: 500;
      }
   }

   a.selected + ul.navigation--secondary {
      display: block;
   }
   .navigation--secondary {
      display: none;
      margin-top: calc(var(--px-12) * -1);
      margin-bottom: var(--px-4);
      a {
         padding-left: var(--px-16);
      }
   }

   a.selected + ul.navigation--tertiary {
      display: block;
   }

   .navigation--tertiary {
      display: none;
      margin-top: calc(var(--px-12) * -1);
      margin-bottom: var(--px-4);
      a {
         padding-left: var(--px-32);
      }
   }

   @media ($md-and-up) {
      display: block;
   }
}
</style>
