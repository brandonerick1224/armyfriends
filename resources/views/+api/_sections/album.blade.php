<a name="album"></a>

<div class="api-group">

   <h1><i class="icon-book"></i>Albums</h1>


   <a name="album_list"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>List albums</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album/list</span></p>

      <form method="POST" action="/api/album/list" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">User ID</label>

            <div class="controls">
               <input type="text" name="user_id" value=""/><span class="param-name">user_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="album_create"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Create album</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album/create</span></p>

      <form method="POST" action="/api/album/create" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
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


   <a name="album_update"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Update album</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album/update</span></p>

      <form method="POST" action="/api/album/update" class="form-horizontal">
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
               <input type="text" name="title" value=""/><span class="param-name">title</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="album_remove"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Remove album</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/album/remove</span></p>

      <form method="POST" action="/api/album/remove" class="form-horizontal">
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


</div>