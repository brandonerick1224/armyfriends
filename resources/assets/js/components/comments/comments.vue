<template>
   <div class="comments full-block">
      <div class="comments-meta" v-if="comments.total">
         <div class="pull-left">
            <a href="#" v-el:load-more v-if="comments.items.length < comments.total" @click.prevent="loadMore" class="ladda-button"><span class="ladda-label">{{ trans('comments.load-more-comments') }}</span></a>
         </div>
         <div class="pull-right comments-count">{{ comments.items.length }} of {{ comments.total }}</div>
      </div>
      <div class="comments-list">
         <comment v-for="comment in comments.items" :comment="comment"></comment>
      </div>
      <comment-form :action="action" :item-type="itemType" :item-id="itemId"></comment-form>
   </div>
</template>

<script>
   import Comment from './comment.vue';
   import CommentForm from './comment-form.vue';

   export default {

      props: {
         itemType: {type: String, required: true},
         itemId: {type: Number, required: true},
         userId: {type: Number, required: true},
         comments: {type: Object, required: true},
      },

      components: {
         'comment': Comment,
         'comment-form': CommentForm,
      },

      data() {
         return {
            loading: false,
         }
      },

      created() {
         this.initListeners();
      },

      methods: {

         /**
          * Listen to events dispatched from socket.io fot current instance
          * and dispatch actions
          */
         initListeners() {
            var key = 'socketio-' + this.itemType + '-' + this.itemId;
            this.$on(key, function(data) {
               // Fix edit and remove links visibility
               data.data.can_update = false; //
               if (app.userId !== this.userId) data.data.can_remove = false;

               this[data.action + 'Comment'](data.data);
            });
         },

         createComment(comment) {
            this.comments.items.push(comment);
            this.comments.total ++;
            this.comments.count ++;
         },

         updateComment(comment) {
            this.comments.items = this.comments.items.map(function(item) {
               if (item.id === comment.id) return comment;
               return item;
            });
         },

         removeComment(comment) {
            this.comments.items = this.comments.items.filter(function(item) {
               return item.id !== comment.id;
            });
            this.comments.total --;
            this.comments.count --;
         },

         addComments(comments) {
            this.comments.items = comments.concat(this.comments.items);
         },

         loadMore() {
            var that = this;
            this.loading = true;
            var l = Ladda.create(this.$els.loadMore);
            l.start();

            this.$http.get(app.url + '/comments/load/' + this.itemType + '/' + this.itemId + '/' + this.comments.items[0].id)
               .then(function (response) {

                  const data = response.data;
                  l.remove();
                  that.loading = false;
                  if (data.result !== 'Ok') {
                     console.log(response);
                     return;
                  }
                  that.addComments(data.comments.items);

               }, function (response) {

                  console.log(response);
                  l.remove();
                  that.loading = false;

               });
         },
      },

   }
</script>