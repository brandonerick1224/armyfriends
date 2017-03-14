<a name="album_item"></a>

<div class="api-group">

   <h1><i class="icon-book"></i>Album items</h1>


   <a name="album_item_list"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>List album items</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album_item/list</span></p>

      <form method="POST" action="/api/album_item/list" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Album ID</label>

            <div class="controls">
               <input type="text" name="album_id" value=""/><span class="param-name">album_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="album_item_show"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Show album item</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album_item/show</span></p>

      <form method="POST" action="/api/album_item/show" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Album item ID</label>

            <div class="controls">
               <input type="text" name="album_item_id" value=""/><span class="param-name">album_item_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="album_item_upload"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Upload album item</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album_item/upload</span></p>

      <form method="POST" action="/api/album_item/upload" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Album ID</label>

            <div class="controls">
               <input type="text" name="album_id" value=""/><span class="param-name">album_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Title</label>

            <div class="controls">
               <input type="text" name="title" value=""/><span class="param-name">title</span> (optional)
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">File</label>

            <div class="controls">
               <input type="file" name="file" /><span class="param-name">file</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="album_item_update"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Update album item</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album_item/update</span></p>

      <form method="POST" action="/api/album_item/update" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Album item ID</label>

            <div class="controls">
               <input type="text" name="album_item_id" value=""/><span class="param-name">album_item_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Title</label>

            <div class="controls">
               <input type="text" name="title" value=""/><span class="param-name">title</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="album_item_remove"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Remove album item</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album_item/remove</span></p>

      <form method="POST" action="/api/album_item/remove" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Album item ID</label>

            <div class="controls">
               <input type="text" name="album_item_id" value=""/><span class="param-name">album_item_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="album_item_as_profile"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Set as profile picture</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album_item/as_profile</span></p>

      <form method="POST" action="/api/album_item/as_profile" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Album item ID</label>

            <div class="controls">
               <input type="text" name="album_item_id" value=""/><span class="param-name">album_item_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="album_item_tag"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Tag user</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album_item/tag</span></p>

      <form method="POST" action="/api/album_item/tag" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Album item ID</label>

            <div class="controls">
               <input type="text" name="album_item_id" value=""/><span class="param-name">album_item_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">User ID</label>

            <div class="controls">
               <input type="text" name="user_id" value=""/><span class="param-name">user_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">X</label>

            <div class="controls">
               <input type="text" name="x" value=""/><span class="param-name">x</span> (0-1)
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Y</label>

            <div class="controls">
               <input type="text" name="y" value=""/><span class="param-name">y</span> (0-1)
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="album_item_untag"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Untag user</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album_item/untag</span></p>

      <form method="POST" action="/api/album_item/untag" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">User tag ID</label>

            <div class="controls">
               <input type="text" name="user_tag_id" value=""/><span class="param-name">user_tag_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>

</div>