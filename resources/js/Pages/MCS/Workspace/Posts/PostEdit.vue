<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import Editor from "@/Components/Rebase/Form/Editor"

export default {
   layout: Layout,
   metaInfo: { title: "Edit the Post" },

   components: {
      Workspace,
      Editor,
   },

   props: {
      post: Array | Object,
   },

   data() {
      return {
         sending: false,
         body: null,
         form: {
            post: this.post,
         },
      }
   },

   mounted: function () {},

   methods: {
      contentUpdate(event) {
         console.log(event)
      },
      save() {
         this.$inertia.put(route("post.update", { postID: this.form.post.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="posts">
      <template #header>Edit Post</template>
      <template #body>
         <div class="grid--top">
            <div class="col-12 sm::col-10">
               <div class="grid">
                  <div class="col-10--centered">
                     <Editor v-model="form.post.content" />
                  </div>
               </div>
            </div>
            <div class="col-12 sm::col-2">
               <p>PREVIEW</p>
               <Button @click="save">Save</Button>
               <p>Publish</p>
               <p>Visible</p>
               <p>Change SLug</p>
               <p>Change Title</p>
               <p>Move</p>
               <p>Update Template</p>
            </div>
         </div>
      </template>
   </Workspace>
</template>

<style lang="scss">
.grid > .col-12 {
   position: relative;
}

.column-menu {
   position: absolute;
   width: 100%;

   ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      li {
         display: inline-block;
         margin: 0;
         padding: 0;
      }
   }

   button {
      border: 0;
      background: #ccc;
      padding: var(--px-4);
      margin: var(--px-4);
   }
}
</style>
