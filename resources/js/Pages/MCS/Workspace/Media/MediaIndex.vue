<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import DataTable from "@/Components/Rebase/DataTable"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"
import ActionLink from "@/Components/Rebase/Actions/ActionLink"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import { Inertia } from "@inertiajs/inertia"
import Multiselect from "vue-multiselect"
import mapValues from "lodash/mapValues"
import pickBy from "lodash/pickBy"
import throttle from "lodash/throttle"
import merge from "lodash/merge"
import "vue-multiselect/dist/vue-multiselect.min.css"

export default {
   layout: Layout,
   metaInfo: { title: "Documents and Media" },

   components: {
      Workspace,
      Multiselect,
      DataTable,
      ActionButton,
      ActionLink,
      ActionMenu,
   },

   props: {
      media: Array | Object,
      tags: Array,
   },

   mounted() {},

   data() {
      return {
         show: false,
         sending: false,
         img: "https://images.pexels.com/photos/4323307/pexels-photo-4323307.jpeg",
         fileRecords: [],
         uploadUrl: route("media.store"),
         fileRecordsForUpload: [],
         mediaList: this.media,
         tagList: this.tags,
      }
   },

   methods: {
      addTag(searchQuery, id) {
         const tag = {
            name: searchQuery,
         }
         this.mediaList.data[id].tags.push(tag)
         this.tagList.push(tag)

         const item = this.mediaList.data[id]

         this.$inertia.post(route("tag.store", { mediaID: item.id }), tag, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },

      handleInput(item) {
         this.$inertia.post(route("media.update", { mediaID: item.id }), item, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },

      deleteFile(id) {
         if (confirm("You want to delete this file from the server? This action is cannot be reversed.")) {
            this.$inertia.delete(route("media.delete", { mediaID: id }), {
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
            })
         }
      },

      onUpload(responses) {
         let vm = this
         Inertia.reload({ only: ["media"] })

         for (const response of responses) {
            if (response.error) {
               // handle error
               continue
            }
            // handle success
         }

         vm.fileRecords.forEach(function (record, index) {
            if (record.upload.data) {
               vm.fileRecords.splice(index)
            }
         })
      },
      onUploadError(failedResponses) {
         let vm = this

         failedResponses.forEach(function (rec, index) {
            let serverMessage = JSON.parse(JSON.parse(rec.request.response).message)

            vm.fileRecords.forEach(function (r, ii) {
               if (r.name() == serverMessage.name) {
                  vm.fileRecords[ii].upload.error = serverMessage.m
               }
            })
         })
      },
   },
}
</script>

<template>
   <Workspace nav="documents">
      <template #header>Documents &amp; Media</template>
      <template v-slot:body>
         <div class="grid grid--content-y:start">
            <VueFileAgent class="col-12" :theme="'list'" @upload="onUpload($event)" @upload:error="onUploadError($event)" :uploadUrl="uploadUrl" v-model="fileRecords" :deletable="true" :meta="true"></VueFileAgent>

            <DataTable class="col-12" :links="media.links" routeName="media.index">
               <template #header>
                  <th></th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Tags</th>
                  <th>Preview</th>
                  <th></th>
               </template>
               <template #contents>
                  <tr v-for="(item, i) in media.data" :key="i">
                     <td><input type="checkbox" /></td>
                     <td>{{ item.name }}</td>
                     <td>{{ item.type }}</td>
                     <td class="fixed-500">
                        <multiselect
                           v-model="item.tags"
                           :id="i"
                           tag-placeholder="Add Tag"
                           placeholder="Search or add a tag"
                           label="name"
                           track-by="name"
                           :options="tagList"
                           :multiple="true"
                           :taggable="true"
                           @tag="addTag"
                           @input="handleInput(item)"
                        ></multiselect>
                     </td>
                     <td>
                        <img v-if="item.type === 'image'" style="width: 80px" :src="item.url" alt="" />
                     </td>
                     <td>
                        <ActionMenu>
                           <ActionButton v-if="item.type === 'image'" @click="edit(item.id)">Edit</ActionButton>
                           <ActionButton @click="download(item.id)">Download</ActionButton>
                           <ActionButton @click="deleteFile(item.id)">Delete</ActionButton>
                        </ActionMenu>
                     </td>
                  </tr>
               </template>
            </DataTable>
         </div>
      </template>
   </Workspace>
</template>

<style lang="scss">
@import "@@/abstract";
.fixed-500 {
   width: 500px !important;
}
.multiselect__input {
   background-color: transparent;
   border: none;
   overflow: hidden;
   padding-left: 0;
   padding-top: 0;
}
.vue-input-tag-wrapper .new-tag {
   @include form-element;
}
</style>
