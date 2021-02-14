<script>
export default {
   props: {
      step: Number,
   },

   components: {},
}
</script>

<template>
   <div class="layout--main">
      <main>
         <slot></slot>
      </main>
      <aside>
         <slot name="sidebar">
            <ol class="step-counter">
               <li class="step-counter--item" :class="{ selected: this.step === 1 }">
                  Basic Information
                  <div class="helper-text">Your website needs a URL, what do you want to call your website? We also need some information on you.</div>
               </li>
               <li class="step-counter--item" :class="{ selected: this.step === 2 }">
                  Pick Your Plan and Payment Method
                  <div class="helper-text">Pick your plan! You can pay via check or credit card, but please note the ACH payment will take longer to set up your account</div>
               </li>
               <li class="step-counter--item" :class="{ selected: this.step === 3 }">
                  Pay
                  <div class="helper-text">Once you pay we build your workspace, so this is an importatnt final step</div>
               </li>
               <li class="step-counter--item" :class="{ selected: this.step === 4 }">
                  Check Your Email
                  <div class="helper-text">All done, now just wait for our email</div>
               </li>
            </ol>
         </slot>
      </aside>
   </div>
</template>

<style lang="scss" scoped>
@import "@@/abstract";
.layout--main {
   display: grid;
   grid-gap: var(--px-16);
   grid-template-areas: "secondary" "main";
   grid-template-columns: 1fr;
   grid-template-rows: 0.5fr 3fr;

   @media ($md-and-up) {
      align-items: stretch;
      grid-template-areas: "main secondary";
      grid-template-columns: 2fr 1fr;
      grid-template-rows: 1fr;
   }

   main {
      grid-area: main;
      padding-bottom: var(--px-20);
   }

   aside {
      background: var(--color-gray-800);
      color: var(--color-gray-400);
      grid-area: secondary;
      padding: var(--px-16);

      @media (map-get($mq, "md")) {
         align-items: center;
         display: flex;
         min-height: 100vh;
      }
   }
}

.step-counter {
   color: var(--color-gray-400);
   font-size: var(--px-20);
}
.step-counter--item {
   padding: var(--px-8) 0;

   &.selected {
      color: var(--color-gray-50);
      font-size: var(--px-30);
      padding: var(--px-8) 0;
   }
}
.helper-text {
   display: none;
}
.selected {
   > .helper-text {
      font-size: var(--px-18);
      display: block;
      padding: var(--px-16) 0 var(--px-20) 0;
      border-top: 1px solid var(--color-gray-50);
      line-height: var(--leading-loose);
   }
}
</style>
