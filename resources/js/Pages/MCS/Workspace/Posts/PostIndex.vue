<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"
import ActionLink from "@/Components/Rebase/Actions/ActionLink"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import DataTable from "@/Components/Rebase/DataTable"
import { DTFormatter } from "@/Data/MCS/Globals"

export default {
   layout: Layout,
   metaInfo: { title: "All Posts" },

   components: {
      Workspace,
      ActionButton,
      ActionLink,
      ActionMenu,
      DataTable,
   },

   props: {
      posts: Array | Object,
   },

   data: () => ({
      sending: false,
      form: {
         post: null,
      },
   }),

   methods: {
      cleanDate(dt) {
         return DTFormatter(dt)
      },
      togglePublish(post) {
         this.form.post = post

         if (this.form.post.published) {
            this.form.post.published_at = null
            this.form.post.published = false
         } else {
            this.form.post.published_at = new Date()
            this.form.post.published = true
         }

         this.$inertia.put(route("post.update", { postID: this.form.post.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
      confirmDelete(id) {
         if (confirm("Are you sure you want to delete this page?")) {
            this.$inertia.delete(
               route("post.delete", { postID: id }),
               {},
               {
                  onStart: () => (this.sending = true),
                  onFinish: () => (this.sending = false),
               }
            )
         }
      },
   },
}
</script>

<template>
   <Workspace nav="posts">
      <template #header>All Posts</template>
      <template #ribbon>
         <li><inertia-link :href="route('post.create')" class="button:small">Make a New Post</inertia-link></li>
      </template>
      <template #body v-if="posts.data.length > 0">
         <div class="grid">
            <div class="col-12">
               <DataTable :links="posts.links">
                  <template #header>
                     <th>&nbsp;</th>
                     <th>Title</th>
                     <th>Status</th>
                     <th>Publish Date</th>
                     <th>&nbsp;</th>
                  </template>
                  <template #contents>
                     <tr v-for="post in posts.data" :key="post.id">
                        <td><input type="checkbox" /></td>
                        <td title="Name">{{ post.title }}</td>
                        <td title="Status">{{ post.published ? "Published" : "Draft" }}</td>
                        <td title="Publish Date">{{ post.published_at ? cleanDate(new Date(post.published_at)) : "Not Scheduled" }}</td>
                        <td>
                           <ActionMenu>
                              <ActionLink :inertia="true" :link="route('post.edit', { postID: post.id })">Edit</ActionLink>
                              <ActionButton @click="togglePublish(post)">
                                 <span v-if="post.published">Unpublish Now</span>
                                 <span v-else>Publish Now</span>
                              </ActionButton>
                              <ActionButton @click="confirmDelete(post.id)">Delete</ActionButton>
                           </ActionMenu>
                        </td>
                     </tr>
                  </template>
               </DataTable>
            </div>
         </div>
      </template>
      <template #body v-else>
         <div class="grid--center">
            <div class="col-8--centered sm::col-6--centered md::col-4--centered">
               <inertia-link :href="route('post.create')" class="button:xlarge">Make Your First Post</inertia-link>
            </div>
         </div>
      </template>
   </Workspace>
</template>
