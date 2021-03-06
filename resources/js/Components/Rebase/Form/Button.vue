<script>
import Icon from "../Icon"

export default {
   name: "Button",
   inheritAttrs: false,
   components: { Icon },

   props: {
      disable: {
         type: Boolean,
         default: false,
      },
      icon: {
         type: [String, Boolean],
         default: false,
      },
      type: {
         type: String,
         default: "button",
      },
   },
   computed: {
      buttonType() {
         let type = `button--${this.as}`

         if (this.size !== "") {
            type = `${type} button--${this.size}`
         }

         return type
      },
   },
}
</script>

<template>
   <button :type="type" v-on="$listeners" v-bind="$attrs" :disabled="disable">
      <slot />
      <Icon v-if="icon" :name="icon" class="icon--right" :size="18" />
   </button>
</template>

<style lang="scss">
@import "@@/abstract";

@mixin button {
   align-items: center;
   background: var(--color-coolGray-800);
   border: 1px solid var(--color-coolGray-800);
   border-radius: var(--radius-2);
   color: var(--color-coolGray-100);
   cursor: pointer;
   display: inline-flex;
   font-size: var(--px-16);
   justify-content: center;
   line-height: var(--leading-normal);
   margin: 0;
   height: var(--px-40);
   padding: 0 var(--px-16);
   position: relative;
   text-align: center;
   text-decoration: none;
   white-space: word-wrap;
}

@mixin size-lists {
   @include xsmall {
      @content;
      font-size: var(--px-14);
      min-height: 0;
      height: var(--px-30);
      padding: 0 var(--px-20);
   }
   @include small {
      @content;
      font-size: var(--px-14);
      min-height: var(--px-18);
      padding: 0 var(--px-20);
   }
   @include large {
      @content;
      font-size: var(--px-18);
      min-height: var(--px-20);
      padding: var(--px-8) var(--px-16);
   }
   @include xlarge {
      @content;
      font-size: var(--px-24);
      min-height: var(--px-40);
      padding: var(--px-4) var(--px-24);
   }
}

@mixin variant-lists {
   @include for-variant("block") {
      @content;
      margin: 0;
      display: block;
   }

   @include for-variant("inline") {
      @content;
      margin: 0;
      display: inline-flex;
   }

   @include for-variant("link") {
      @content;
      border: none;
   }
}

.button {
   @include with-queries {
      @include sizes-and-variants {
         @include button;

         &:disabled {
            opacity: 0.6;
            cursor: default;
         }
      }
   }
}

.button--secondary {
   @include with-queries {
      @include sizes-and-variants {
         @include button;
         background: transparent;
         border: 2px solid var(--color-coolGray-800);
         color: var(--color-coolGray-800);
      }
   }
}

.button--icon {
   @include with-queries {
      @include sizes-and-variants {
         @include button;
         background: transparent;
         border: none;
         color: inherit;
         text-align: right;
         margin: 0;
         padding: 0 !important;
      }
   }
}

.button--success {
   @include with-queries {
      @include sizes-and-variants {
         @include button;
         background: var(--color-emerald-500);
         border: 2px solid var(--color-emerald-500);
         color: var(--color-coolGray-100);
      }
   }
}

.button--danger {
   @include with-queries {
      @include sizes-and-variants {
         @include button;
         background: var(--color-red-500);
         border: 2px solid var(--color-red-500);
         color: var(--color-coolGray-100);
      }
   }
}

.button--link {
   @include with-queries {
      @include sizes-and-variants {
         @include button;
         background: transparent;
         border: none;
         padding: 0;
         margin: 0;
         font-weight: 300;
         text-decoration: underline;
         color: var(--color-blue-500);
         &:hover {
            text-decoration: none;
         }
      }
   }
}
</style>
