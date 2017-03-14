<a name="like"></a>

<div class="api-group">

   <h1><i class="icon-book"></i>Likes</h1>


   <a name="like_list"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>List likes</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/like/list</span></p>

      <form method="POST" action="/api/like/list" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Likeable type</label>

            <div class="controls">
               {{ Form::select('likeable_type', ['posts' => 'posts', 'album_items' => 'album_items', 'user_profiles' => 'user_profiles']) }}<span class="param-name">likeable_type</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Likeable ID</label>

            <div class="controls">
               <input type="text" name="likeable_id" value=""/><span class="param-name">likeable_id</span>
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


   <a name="like_like"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Like</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/like/like</span></p>

      <form method="POST" action="/api/like/like" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Likeable type</label>

            <div class="controls">
               {{ Form::select('likeable_type', ['posts' => 'posts', 'album_items' => 'album_items', 'user_profiles' => 'user_profiles']) }}<span class="param-name">likeable_type</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Likeable ID</label>

            <div class="controls">
               <input type="text" name="likeable_id" value=""/><span class="param-name">likeable_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="like_unlike"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Unlike</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/like/unlike</span></p>

      <form method="POST" action="/api/like/unlike" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Likeable type</label>

            <div class="controls">
               {{ Form::select('likeable_type', ['posts' => 'posts', 'album_items' => 'album_items', 'user_profiles' => 'user_profiles']) }}<span class="param-name">likeable_type</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Likeable ID</label>

            <div class="controls">
               <input type="text" name="likeable_id" value=""/><span class="param-name">likeable_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


</div>