<script>
export default {
   name: "Paginator",

   props: {
      links: Array,
   },
}
</script>

<template>
   <div class="grid--center">
      <div class="col-10 sm::col-9">
         <ul class="paginator">
            <li class="paginator--item" v-for="(link, key) in links">
               <span class="paginator--link" v-if="link.url === null" :key="key" v-html="link.label"></span>
               <inertia-link v-else :key="key" class="paginator--link" :class="[link.active ? 'paginator:active' : '']" :href="link.url" v-html="link.label"></inertia-link>
            </li>
         </ul>
      </div>
      <div class="col-10 sm::col-3 items:end">
         <ul class="paginator">
            <li class="paginator--item">Show:</li>
            <li class="paginator--item"><inertia-link class="paginator--link" href="?count=10">10</inertia-link></li>
            <li class="paginator--item"><inertia-link class="paginator--link" href="?count=25">25</inertia-link></li>
            <li class="paginator--item"><inertia-link class="paginator--link" href="?count=50">50</inertia-link></li>
         </ul>
      </div>
   </div>
</template>

<style lang="scss" scoped>
.paginator {
   display: flex;
   list-style-type: none;
   margin: var(--px-16) 0;
   padding: 0;
}

.paginator--link {
   padding: var(--px-8);
   text-decoration: none;
}

.paginator\:active {
   background: #fff;
   font-weight: bold;
}
</style>
