<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"

export default {
   layout: Layout,
   metaInfo: { title: `Edit Member` },

   components: {
      Workspace,
   },

   props: {
      member: Object,
   },

   data() {
      return {
         sending: false,
         form: this.member,
      }
   },

   methods: {
      save() {
         this.$inertia.put(route("member.update", { memberID: this.form.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="events">
      <template #header>Edit: {{ member.name }}</template>
      <template #body>
         <form class="layout__main" action="post" @submit.prevent="save">
            <section class="grid"></section>
         </form>
      </template>
   </Workspace>
</template>
