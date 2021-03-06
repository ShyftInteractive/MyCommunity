<script>
import Paginator from "@/Components/Rebase/Paginator"
import mapValues from "lodash/mapValues"
import pickBy from "lodash/pickBy"
import throttle from "lodash/throttle"
import merge from "lodash/merge"

export default {
   data: function () {
      return {
         form: {
            s: null,
            selected: [],
         },
      }
   },

   watch: {
      form: {
         handler: throttle(function (f) {
            let query = pickBy(f)
            this.$inertia.get(this.route(this.routeName), merge(query, this.routeParams), {
               replace: true,
               preserveState: true,
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
            })
         }, 150),
         deep: true,
      },
   },

   methods: {
      reset() {
         this.form = mapValues(this.form, () => null)
      },
   },
   components: {
      Paginator,
   },
   props: {
      deleteRoute: String,
      routeName: String,
      routeParams: Object,
      links: Array,
   },
}
</script>

<template>
   <section>
      <form class="grid search-bar">
         <FormFieldInline class="col-4">
            <FieldLabel>Search:</FieldLabel>
            <FormInput v-model="form.s" />
         </FormFieldInline>
         <div class="col-8 table--actions">
            <Button class="button--link" @click="reset">Reset</Button>
            <slot name="tableActions" />
         </div>
      </form>

      <table class="table--data">
         <thead>
            <tr>
               <slot name="header" />
            </tr>
         </thead>
         <tbody>
            <slot name="contents" />
         </tbody>
      </table>
      <Paginator :links="links" v-if="links.length > 0" />
   </section>
</template>

<style lang="scss">
@import "@@/abstract";
.table--actions {
   flex-direction: row;
   align-content: center;
   align-items: center;
   justify-content: space-between;
   gap: var(--px-8);
}
.table--data {
   border: 1px solid var(--color-gray-200);
   width: 100%;

   thead,
   tbody {
      border-bottom: 2px solid var(--color-gray-200);
      font-size: var(--px-14);
   }

   thead {
      display: none;

      @media ($sm-and-up) {
         background: var(--color-true-white);
         display: table-header-group;
      }
   }

   td,
   th {
      font-size: var(--px-18);
      padding: var(--px-12);
   }

   tbody {
      tr {
         background: var(--color-true-white);
         display: flex;
         flex-wrap: wrap;
         justify-content: space-between;

         &:nth-of-type(2n + 1) {
            background: var(--color-blueGray-50);
         }

         &.drawer {
            border-bottom: 1px solid var(--color-gray-300);
            box-shadow: inset 0px 5px 8px -7px var(--color-gray-600);
            display: none;

            &:hover {
               background: var(--color-true-white);
            }

            td {
               padding: var(--px-40) var(--px-12);
            }
         }

         &:hover {
            background: var(--color-yellow-50);
         }

         @media ($sm-and-up) {
            display: table-row;
         }
      }

      td {
         width: 100%;

         @media ($sm-and-up) {
            width: auto;
         }
      }
   }
}

.search-bar {
   padding-bottom: var(--px-20);
}
</style>
