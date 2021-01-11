export const slugify = function(strVal) {
   return strVal.trim()
   .toLowerCase()
   .replace(/ /g, "-")
   .replace(/[-]+/g, "-")
   .replace(/![a-z0-9]+/g, "")
   .replace(/[\-]$/g, "")
   .replace(/[\-]+$/g, "")
   .replace(/^[\-]/g, "")
   .replace(/^[\-]+/g, "")
   .replace(/[^\w-]+/g, "")
}

export const DTFormatter = function (dt) {
      return dt.toLocaleTimeString([], {
         year: 'numeric',
         month: '2-digit',
         day: '2-digit',
         hour: '2-digit',
         minute: '2-digit'
      });
}
