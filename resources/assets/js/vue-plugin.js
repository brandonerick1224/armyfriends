export default {
   install: function(Vue, options) {
      Vue.prototype.trans = function(key) {
         return trans[key];
      };
   }
}