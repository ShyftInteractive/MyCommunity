<script>
import MainNavigation from "./MainNavigation"

export default {
   components: {
      MainNavigation,
   },

   methods: {},

   props: {
      nav: String,
      secondary: String,
      tertiary: String,
   },
}
</script>

<template>
   <MainNavigation>
      <li><inertia-link :href="route('dashboard')" :class="{ selected: this.nav === 'dashboard' }">Dashboard</inertia-link></li>
      <li><inertia-link :href="route('media.index')" :class="{ selected: this.nav === 'documents' }">Documents &amp; Media</inertia-link></li>
      <li>
         <li><inertia-link :href="route('group.index')" :class="{ selected: this.nav === 'groups' }">Groups &amp; Tags</inertia-link></li>
      </li>
      <li><inertia-link :href="route('event.index')" :class="{ selected: this.nav === 'events' }">Events</inertia-link></li>
      <li><inertia-link :href="route('notification.index')" :class="{ selected: this.nav === 'notification' }">Notification Center</inertia-link></li>
      <li><inertia-link :href="route('page.index')" :class="{ selected: this.nav === 'pages' }">Pages</inertia-link></li>
      <li><inertia-link :href="route('post.index')" :class="{ selected: this.nav === 'posts' }">Posts</inertia-link></li>
      <li>
         <inertia-link :href="route('setting.index')" :class="{ selected: this.nav === 'site-settings' }">Site Settings</inertia-link>
         <ul class="navigation--secondary">
            <li>
               <inertia-link :href="route('design.index')" :class="{ selected: this.secondary === 'design' }">Design</inertia-link>
               <ul class="navigation--tertiary">
                  <li><inertia-link :href="route('site-template.index')" :class="{ selected: this.tertiary === 'templates' }">Site Templates</inertia-link></li>
                  <li><inertia-link :href="route('site-theme.index')" :class="{ selected: this.tertiary === 'themes' }">Site Themes</inertia-link></li>
               </ul>
            </li>
            <li><inertia-link href="#" :class="{ selected: this.secondary === 'members' }">Members</inertia-link></li>
            <li><inertia-link :href="route('dashboard')" :class="{ selected: this.secondary === 'workspace-settings' }">Website Settings</inertia-link></li>
         </ul>
      </li>
   </MainNavigation>
</template>
