<script>
import Layout from "@/Templates/Rebase/Layout"
import Workspace from "@/Templates/Rebase/Page/Workspace"
import ContentGroup from "@/Components/Rebase/ContentGroup"
import { Inertia } from "@inertiajs/inertia"

export default {
   layout: Layout,
   metaInfo: { title: `Edit Member` },

   components: {
      Workspace,
      ContentGroup,
   },

   props: {
      member: Object,
      memberRole: Object,
   },

   data() {
      return {
         sending: false,
         img: "https://images.pexels.com/photos/4323307/pexels-photo-4323307.jpeg",
         fileRecords: this.member.avatar
            ? [
                 {
                    name: "Avatar",
                    type: "image",
                    url: this.member.avatar,
                    videoThumbnail: this.member.avatar,
                    imageColor: [66, 62, 45],
                 },
              ]
            : [],
         uploadUrl: route("member.upload", { memberID: this.member.id }),
         deleteUrl: route("member.upload.delete", { memberID: this.member.id }),
         form: {
            member: this.member,
            newRole: null,
            memberRole: this.memberRole,
         },
      }
   },

   methods: {
      onUpload(responses) {
         let vm = this
         for (const response of responses) {
            if (response.error) {
               continue
            }
            // this.form.member.avatarUrl = response.
         }
      },
      onDelete(fileRecord) {
         let vm = this
         this.$inertia.delete(route("member.upload.delete", { memberID: this.form.member.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
      onUploadError(event) {},

      save() {
         this.$inertia.put(route("member.update", { memberID: this.form.member.id }), this.form, {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
         })
      },
   },
}
</script>

<template>
   <Workspace nav="site-settings" secondary="member">
      <template #header>Edit: {{ member.name }}</template>
      <template #body>
         <form class="layout__main" action="post" @submit.prevent="save">
            <section class="grid">
               <div class="col-8--centered">
                  <ContentGroup :userCanEdit="true">
                     <template v-slot:contentTitle>{{ member.name }} Information</template>
                     <div class="grid">
                        <div class="col-3 avatar-large" :style="`background-image:url(${member.avatar});`"></div>
                        <div class="col-7">
                           <h3>{{ member.email }}</h3>
                           <h5>{{ form.memberRole.type }}</h5>
                           <template v-if="member.email_verified_at !== null">{{ DTFormatter(member.email_verified_at) }}</template>
                           <template v-else>Member has never logged in</template>
                        </div>
                     </div>

                     <template v-slot:contentEdit>
                        <div class="grid">
                           <VueFileAgent
                              ref="fileAgent"
                              class="col-10--centered lg::col-3"
                              @upload="onUpload($event)"
                              @delete="onDelete($event)"
                              @upload:error="onUploadError($event)"
                              :uploadUrl="uploadUrl"
                              v-model="fileRecords"
                              thumbnailSize="250"
                              :multiple="false"
                              :accept="'image/*'"
                              :helpText="'Drag an image file here'"
                              :compact="true"
                              :deletable="true"
                              :meta="false"
                           >
                           </VueFileAgent>
                           <div class="col-10--centered lg::col-9">
                              <FormField validate="name" class="">
                                 <FieldLabel>Name:</FieldLabel>
                                 <FormInput v-model="member.name" />
                              </FormField>

                              <FormField validate="email" class="">
                                 <FieldLabel>Email:</FieldLabel>
                                 <FormInput v-model="member.email" />
                              </FormField>

                              <FormField class="" validation="role">
                                 <FieldLabel>Role:</FieldLabel>
                                 <FormSelect v-model="form.memberRole.type" defaultText="Select an Option" :options="$page.props.app.roles" />
                              </FormField>
                           </div>
                           <br />
                           <Button type="submit" class="col-10--centered lg::col-4--centered button" :disable="sending">Update</Button>
                        </div>
                     </template>
                  </ContentGroup>
               </div>
            </section>
         </form>
      </template>
   </Workspace>
</template>

<style lang="scss">
.avatar-large {
   border: 2px solid #ddd;
   background-size: cover;
   background-position: 50% 50%;
}
</style>
