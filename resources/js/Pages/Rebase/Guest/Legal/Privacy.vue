<script>
import Layout from "@/Templates/Rebase/Layout"

export default {
   layout: Layout,
   metaInfo: { title: "ViewPrivacy" },

   components: {},

   data: () => ({
      form: {
         id: 1,
         name: "",
         email: "",
      },
   }),

   props: {},

   methods: {
      test() {
         this.$inertia.post("/", this.form).then(() => (this.sending = false))
      },
   },
}
</script>

<template>
   <div>
      <button @click="test">Test</button>
   </div>
</template>
