<a name="comment"></a>

<div class="api-group">

   <h1><i class="icon-book"></i>Comments</h1>


   <a name="comment_list"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>List comments</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/comment/list</span></p>

      <form method="POST" action="/api/comment/list" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Commentable type</label>

            <div class="controls">
               {{ Form::select('commentable_type', ['posts' => 'posts', 'album_items' => 'album_items']) }}<span class="param-name">commentable_type</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Commentable ID</label>

            <div class="controls">
               <input type="text" name="commentable_id" value=""/><span class="param-name">commentable_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Offset</label>

            <div class="controls">
               <input type="text" name="offset" value=""/><span class="param-name">offset</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="comment_create"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Create comment</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/comment/create</span></p>

      <form method="POST" action="/api/comment/create" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Commentable type</label>

            <div class="controls">
               {{ Form::select('commentable_type', ['posts' => 'posts', 'album_items' => 'album_items']) }}<span class="param-name">commentable_type</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Commentable ID</label>

            <div class="controls">
               <input type="text" name="commentable_id" value=""/><span class="param-name">commentable_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Content</label>

            <div class="controls">
               <input type="text" name="content" value=""/><span class="param-name">content</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="comment_update"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Update comment</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/comment/update</span></p>

      <form method="POST" action="/api/comment/update" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Comment ID</label>

            <div class="controls">
               <input type="text" name="comment_id" value=""/><span class="param-name">comment_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Content</label>

            <div class="controls">
               <input type="text" name="content" value=""/><span class="param-name">content</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="comment_remove"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Remove comment</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/comment/remove</span></p>

      <form method="POST" action="/api/comment/remove" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Comment ID</label>

            <div class="controls">
               <input type="text" name="comment_id" value=""/><span class="param-name">comment_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


</div>