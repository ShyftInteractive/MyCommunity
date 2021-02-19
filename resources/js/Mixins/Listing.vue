<script>
export default {
   methods: {
      listingDelete(route, message) {
         let confirmMessage = message ? message : "Are you sure you want to delete this?"

         if (confirm(confirmMessage)) {
            this.$inertia.delete(route, {
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
            })
         }
      },
   },
}
</script>
