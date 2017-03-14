<a name="post"></a>

<div class="api-group">

   <h1><i class="icon-book"></i>Posts</h1>


   <a name="post_list"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>List posts</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/post/list</span></p>

      <form method="POST" action="/api/post/list" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">User ID</label>

            <div class="controls">
               <input type="text" name="user_id" value=""/><span class="param-name">user_id</span> (or group_id)
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group ID</label>

            <div class="controls">
               <input type="text" name="group_id" value=""/><span class="param-name">group_id</span> (or user_id)
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Offset</label>

            <div class="controls">
               <input type="text" name="offset" value=""/><span class="param-name">offset</span> (or user_id)
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="post_show"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Show post</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/post/show</span></p>

      <form method="POST" action="/api/post/show" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Post ID</label>

            <div class="controls">
               <input type="text" name="post_id" value=""/><span class="param-name">post_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="post_create"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Create post</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/post/create</span></p>

      <form method="POST" action="/api/post/create" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Content</label>

            <div class="controls">
               <input type="text" name="content" value=""/><span class="param-name">content</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group ID</label>

            <div class="controls">
               <input type="text" name="group_id" value=""/><span class="param-name">group_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Image</label>

            <div class="controls">
               <input type="file" name="image" /><span class="param-name">image</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="post_update"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Update post</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/post/update</span></p>

      <form method="POST" action="/api/post/update" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Post ID</label>

            <div class="controls">
               <input type="text" name="post_id" value=""/><span class="param-name">post_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Content</label>

            <div class="controls">
               <input type="text" name="content" value=""/><span class="param-name">content</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Remove image</label>

            <div class="controls"><input type="checkbox" name="remove_image" value="true"><span class="param-name">remove_image</span>="true"</div>
         </div>
         <div class="control-group">
            <label class="control-label">Image</label>

            <div class="controls">
               <input type="file" name="image" /><span class="param-name">image</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="post_remove"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Remove post</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/post/remove</span></p>

      <form method="POST" action="/api/post/remove" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Post ID</label>

            <div class="controls">
               <input type="text" name="post_id" value=""/><span class="param-name">post_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>

</div>