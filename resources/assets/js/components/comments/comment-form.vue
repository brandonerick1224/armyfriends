<template>
   <div class="comment-form" id="commentform">
      <form @submit.prevent="onSubmit">
         <div class="form-group">
            <div class="input-group">
               <input class="form-control" placeholder="{{ trans('comments.add-comment') }}" v-model="content" @keyup="checkLength">
               <span class="input-group-btn">
                  <button v-el:button class="btn btn-default ladda-button" data-style="zoom-in" type="submit" :disabled="! content"><span class="ladda-label"><i class="fa fa-send"></i></span></button>
               </span>
            </div>
         </div>
      </form>
   </div><!--comment-form-->
</template>

<script>
   export default {
      props: ['item-type', 'item-id'],

      data () {
         return {
            content: '',
            loading: false,
         };
      },

      methods: {

         checkLength: function() {
            var maxLenght = 1000;

            if (this.content.length > maxLenght) {
               this.content = this.content.substr(0, maxLenght);
            }
         },

         onSubmit: function() {
            var that = this;
            this.loading = true;
            var l = Ladda.create(this.$els.button);
            l.start();

            this.$http.post(app.url + '/comments/add/' + this.itemType + '/' + this.itemId, {
               content: this.content,
            }).then(function (response) {

               const data = response.data;
               l.remove();
               that.loading = false;
               if (data.result !== 'Ok') {
                  console.log(response);
                  return;
               }
               this.$parent.createComment(data.comment);
               that.content = '';

            }, function (response) {

               console.log(response);
               l.remove();
               that.loading = false;

            });
         }
      }
   }
</script>