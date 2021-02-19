<script>
import Layout from "@/Templates/Rebase/Layout"
import Simple from "@/Templates/Rebase/Page/Simple"

export default {
   layout: Layout,
   metaInfo: { title: "Your account is not activated" },

   components: {
      Simple,
   },
}
</script>

<template>
   <Simple>
      <template #header>Hold</template>
      <template v-slot:body>
         <div class="grid">
            <div class="col-10--centered">
               <h1 class="display-1">Your Account is not Activated</h1>
               <p class="lead">The administrator for this account has not yet activated your account. Please consult with them to get your account activated.</p>
            </div>
         </div>
      </template>
   </Simple>
</template>
