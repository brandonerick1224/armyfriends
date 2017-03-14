<template>
   <div class="comment clearfix">
      <a class="comment-img" href="{{ comment.user_link }}">
         <img :src="comment.user_image" alt="">
      </a>
      <div class="input-group comment-edit-form" v-if="editing">
         <input type="text" class="form-control" v-model="editedContent" @keyup="checkLength">
         <span class="input-group-btn">
            <button v-el:save-button @click.prevent="update" class="btn btn-default ladda-button" data-style="zoom-in"  :disabled="! editedContent"><span class="ladda-label"><i class="fa fa-save"></i></span></button>
         </span>
      </div>

      <div class="comment-content" v-if="! editing">
         <span class="comment-user"><a href="{{ comment.user_link }}">{{ comment.user_name }}</a></span>
         {{ comment.content }}
      </div>
      <div class="comment-meta">
         <a href="#" class="comment-action" v-if="comment.can_update" @click.prevent="edit">{{ editing ? trans('comments.cancel-edit') : trans('common.edit') }}</a>
         <a href="#" v-el:remove-button class="comment-action ladda-button" data-style="zoom-in" v-if="comment.can_remove" @click.prevent="remove"><span class="ladda-label">{{ trans('common.delete') }}</span></a>
         <span class="comment-date">{{ comment.date }}</span>
      </div>
   </div>
</template>

<script>
   export default {
      props: {
         comment: {
            type: Object,
            required: true,
         },
         loading: false,
         editing: false,
      },

      data() {
         return {
            editedContent: '',
         };
      },

      methods: {

         edit() {
            // Cancel editing
            if (this.editing) {
               this.editing = false;
               return;
            }

            this.editing = true;
            this.editedContent = this.comment.content;
         },

         update() {
            var that = this;
            this.loading = true;
            var l = Ladda.create(this.$els.saveButton);
            l.start();

            this.$http.post(app.url + '/comments/update/' + this.comment.id, {content: this.editedContent})
               .then(function (response) {

                  const data = response.data;
                  l.remove();
                  that.loading = false;
                  that.editing = false;
                  if (data.result !== 'Ok') {
                     console.log(response);
                     return;
                  }
                  that.comment.content = that.editedContent;

               }, function (response) {

                  console.log(response);
                  l.remove();
                  that.loading = false;

               });
         },

         remove() {
            var that = this;
            this.loading = true;
            var l = Ladda.create(this.$els.removeButton);
            l.start();

            this.$http.get(app.url + '/comments/remove/' + this.comment.id)
               .then(function (response) {

                  const data = response.data;
                  l.remove();
                  that.loading = false;
                  if (data.result !== 'Ok') {
                     console.log(response);
                     return;
                  }
                  that.$parent.removeComment(this.comment);

               }, function (response) {

                  console.log(response);
                  l.remove();
                  that.loading = false;

               });
         },

         checkLength: function() {
            var maxLenght = 1000;

            if (this.editedContent.length > maxLenght) {
               this.editedContent = this.editedContent.substr(0, maxLenght);
            }
         },

      },
   }
</script>