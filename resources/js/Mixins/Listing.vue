<script>
export default {
   methods: {
      selectedAction(type, message, route) {
         let fullMessage = message ?? `Are you sure you want to ${type} ${this.form.selected.length} item(s)?`
         if (confirm(fullMessage)) {
            this.$inertia.post(route(route, { action: type }), this.form, {
               onStart: () => (this.sending = true),
               onFinish: () => (this.sending = false),
            })
         }
      },

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
