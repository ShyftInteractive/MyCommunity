export const slugify = function(strVal) {
   return strVal
   .trim()
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
   if (typeof dt === "string") {
      dt = new Date(dt);
   }
   return dt.toLocaleTimeString([], {
      year: 'numeric',
      month: '2-digit',
      day: '2-digit',
      hour: '2-digit',
      minute: '2-digit'
   });
}

export const DTF = function(dt) {
   const date = new Date(dt);

   return {
      local() {
         return date.toLocaleTimeString([], {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
         });
      },
      shortMonth() {
         switch(date.getMonth()) {
            case 0:
               return 'Jan'
            case 1:
               return 'Feb'
            case 2:
               return 'Mar'
            case 3:
               return 'Apr'
            case 4:
               return 'May'
            case 5:
               return 'Jun'
            case 6:
               return 'Jul'
            case 7:
               return 'Aug'
            case 8:
               return 'Sept'
            case 9:
               return 'Oct'
            case 10:
               return 'Nov'
            case 11:
               return 'Dec'
         }
      },
      day() {
         return date.getDate()
      },
      fullTime() {
         return date.toLocaleTimeString()
      },
      fullMonth() {
         switch(date.getMonth()) {
            case 0:
               return 'January'
            case 1:
               return 'February'
            case 2:
               return 'March'
            case 3:
               return 'April'
            case 4:
               return 'May'
            case 5:
               return 'June'
            case 6:
               return 'July'
            case 7:
               return 'August'
            case 8:
               return 'September'
            case 9:
               return 'October'
            case 10:
               return 'November'
            case 11:
               return 'December'
         }
      }
   }

}
