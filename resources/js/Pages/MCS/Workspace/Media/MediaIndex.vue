<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import DataTable from "@/Components/Rebase/DataTable"
import ActionButton from "@/Components/Rebase/Actions/ActionButton"
import ActionLink from "@/Components/Rebase/Actions/ActionLink"
import ActionMenu from "@/Components/Rebase/Actions/ActionMenu"
import { Inertia } from "@inertiajs/inertia"
import { Cropper } from "vue-advanced-cropper"
import "vue-advanced-cropper/dist/style.css"

export default {
   layout: Layout,
   metaInfo: { title: "Documents and Media" },

   components: {
      Workspace,
      Cropper,
      DataTable,
      ActionButton,
      ActionLink,
      ActionMenu,
   },

   props: {
      media: Array | Object,
   },
   data() {
      return {
         show: false,
         sending: false,
         img: "https://images.pexels.com/photos/4323307/pexels-photo-4323307.jpeg",
         fileRecords: [],
         uploadUrl: route("media.upload"),
         fileRecordsForUpload: [],
      }
   },

   methods: {
      deleteFile(id) {
         if (confirm("You want to delete this file from the server? This action is cannot be reversed.")) {
            this.$inertia.delete(route("media.delete", { mediaID: id }), {
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
            })
         }
      },
      change({ coordinates, canvas }) {
         console.log(coordinates, canvas)
      },
      crop(image) {
         this.show = true
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
         <div class="grid">
            <VueFileAgent class="col-12" :theme="'list'" @upload="onUpload($event)" @upload:error="onUploadError($event)" :uploadUrl="uploadUrl" v-model="fileRecords" :deletable="true" :meta="true"></VueFileAgent>

            <DataTable class="col-12" :links="media.links" routeName="media.index">
               <template #header>
                  <th></th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Preview</th>
                  <th></th>
               </template>
               <template #contents>
                  <tr v-for="item in media.data">
                     <td><input type="checkbox" /></td>
                     <td>{{ item.name }}</td>
                     <td>{{ item.type }}</td>
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
