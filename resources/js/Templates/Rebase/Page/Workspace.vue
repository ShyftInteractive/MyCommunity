<script>
import Logo from "./Components/Logo"
import Icon from "@/Components/Rebase/Icon"
import EventBus from "@/Data/MCS/event-bus"
import WorkspaceSidebar from "./Components/WorkspaceSidebar"
import IdentityNavigation from "./Components/IdentityNavigation"

export default {
   components: {
      Icon,
      Logo,
      EventBus,
      WorkspaceSidebar,
      IdentityNavigation,
   },

   mounted() {
      let vm = this
      EventBus.$on("OPEN_DRAWER", (state) => {
         vm.drawerState = state
      })

      document.addEventListener("keydown", (e) => {
         if (e.ctrlKey && e.which === 49) {
            if (vm.drawerState === true) {
               EventBus.$emit("OPEN_DRAWER", false)
            } else {
               EventBus.$emit("OPEN_DRAWER", true)
            }
         }
         if (e.keyCode === 27) {
            EventBus.$emit("OPEN_DRAWER", false)
         }
      })
   },

   props: {
      drawer: {
         default: false,
         type: Boolean,
      },
      nav: {
         default: "",
         type: String,
      },
      secondary: {
         default: "",
         type: String,
      },
      tertiary: {
         default: "",
         type: String,
      },
   },
   data() {
      return {
         useDrawer: this.drawer,
         drawerState: false,
      }
   },

   watch: {},
}
</script>

<template>
   <section>
      <div class="layout--main">
         <header>
            <Logo />
            <div class="section-title">
               <slot name="header"></slot>
            </div>
            <div class="section-identity">
               <IdentityNavigation></IdentityNavigation>
            </div>
         </header>
         <main>
            <div class="content-ribbon">
               <ul class="ribbon--menu">
                  <slot name="ribbon"></slot>
               </ul>
            </div>
            <div class="content-container">
               <slot name="body"></slot>
               <div class="drawer" :class="{ closed: !drawerState }" v-if="useDrawer">
                  <div class="grid">
                     <div class="col-1">
                        <button class="button--link" @click="drawerState = !drawerState">
                           <Icon v-if="drawerState" name="chevrons-right" size="20" />
                           <Icon v-else name="chevrons-left" size="20" />
                        </button>
                     </div>
                     <div class="col-11 drawer--content">
                        <slot name="drawer"></slot>
                     </div>
                  </div>
               </div>
            </div>
         </main>
         <aside class="js-sidebar">
            <WorkspaceSidebar :nav="nav" :secondary="secondary" :tertiary="tertiary" />
         </aside>
      </div>
   </section>
</template>

<style lang="scss" scoped>
@import "@@/abstract";

$sidebar-width: 240px;
$headerbar-height: 40px;

.layout--main {
   column-gap: var(--px-16);
   display: grid;
   grid-template-areas:
      "sidebar"
      "header"
      "main";
   grid-template-columns: 1fr;
   grid-template-rows: min($headerbar-height) min($headerbar-height) 1fr;
   height: 100vh;

   @media ($md-and-up) {
      grid-template-areas:
         "header header"
         "sidebar main";
      grid-template-columns: $sidebar-width 1fr;
      grid-template-rows: min($headerbar-height) 1fr;
   }

   header {
      align-items: center;
      align-content: center;
      background: var(--color-true-white);
      border-bottom: 3px solid var(--color-blueGray-300);
      column-gap: var(--px-16);
      padding: 0 var(--px-16);
      display: grid;
      grid-area: header;
      grid-template-columns: 1fr 1fr;
      z-index: 10;

      @media ($md-and-up) {
         grid-template-columns: $sidebar-width 2fr $sidebar-width;
      }
      .section-title {
         color: var(--color-coolGray-600);
         display: none;
         font-size: var(--px-18);

         @media ($md-and-up) {
            display: block;
            text-align: center;
         }
      }

      .section-identity {
         text-align: right;
      }
   }

   main {
      padding: 0;
      -ms-overflow-style: none;
      grid-area: main;
      overflow: scroll;
      scrollbar-width: none;

      &::-webkit-scrollbar {
         display: none;
      }

      @media ($md-and-up) {
         padding-right: var(--px-16);
      }

      .content-ribbon {
         align-content: center;
         align-items: center;
         display: flex;
         height: 5vh;
         justify-content: flex-start;
         padding: 0 var(--px-16);

         @media ($md-and-up) {
            justify-content: flex-end;
            padding: var(--px-16) 0;
         }
      }

      .content-container {
         height: calc(95vh - #{$headerbar-height * 2});
         padding: 0 var(--px-16);

         @media ($md-and-up) {
            padding: 0;
         }
      }

      .drawer {
         background: var(--color-coolGray-200);
         bottom: 0;
         box-shadow: 2px 1px 5px 0px var(--color-coolGray-800);
         color: var(--color-coolGray-800);
         padding: var(--px-16);
         position: absolute;
         right: 0;
         top: $headerbar-height * 2;
         transition: width 350ms ease-in-out;
         width: 100vw;
         z-index: 2;
         overflow: scroll;

         &.closed {
            width: 50px;
         }

         @media ($md-and-up) {
            top: $headerbar-height;
            width: 50vw;
         }
      }
   }

   aside {
      background: var(--color-blueGray-800);
      grid-area: sidebar;
      padding: 0 var(--px-16);

      @media ($md-and-up) {
         padding-top: var(--px-60);
      }
   }
}

.drawer.closed .drawer--content {
   display: none;
}

.ribbon--menu {
   list-style-type: none;

   li {
      display: inline-block;
      margin: 0 var(--px-16px);
      padding: 0;

      &:first-of-type {
         margin-left: 0;
      }

      &:last-of-type {
         margin-right: 0;
      }
   }
}
</style>
