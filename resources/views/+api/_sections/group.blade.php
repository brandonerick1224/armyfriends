<a name="group"></a>

<div class="api-group">

   <h1><i class="icon-book"></i>Groups</h1>


   <a name="group_my"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>My groups</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group/my</span></p>

      <form method="POST" action="/api/group/my" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_search"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Search groups</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group/search</span></p>

      <form method="POST" action="/api/group/search" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Query</label>

            <div class="controls">
               <input type="text" name="query" value=""/><span class="param-name">query</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_show"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Show group</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group/show</span></p>

      <form method="POST" action="/api/group/show" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group ID</label>

            <div class="controls">
               <input type="text" name="group_id" value=""/><span class="param-name">group_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_create"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Create group</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group/create</span></p>

      <form method="POST" action="/api/group/create" class="form-horizontal" enctype="multipart/form-data">
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
         <div class="control-group">
            <label class="control-label">Description</label>

            <div class="controls">
               <input type="text" name="description" value=""/><span class="param-name">description</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Type</label>

            <div class="controls">
               {!! Form::select('type', ['public' => 'Public', 'private' => 'Private']) !!}
               <span class="param-name">country</span>
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


   <a name="group_update"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Update group</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group/update</span></p>

      <form method="POST" action="/api/group/update" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group ID</label>

            <div class="controls">
               <input type="text" name="group_id" value=""/><span class="param-name">group_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Title</label>

            <div class="controls">
               <input type="text" name="title" value=""/><span class="param-name">title</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Description</label>

            <div class="controls">
               <input type="text" name="description" value=""/><span class="param-name">description</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Type</label>

            <div class="controls">
               {!! Form::select('type', ['public' => 'Public', 'private' => 'Private']) !!}
               <span class="param-name">country</span>
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


   <a name="group_remove"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Remove group</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group/remove</span></p>

      <form method="POST" action="/api/group/remove" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group ID</label>

            <div class="controls">
               <input type="text" name="group_id" value=""/><span class="param-name">group_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_join"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Join group</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group/join</span></p>

      <form method="POST" action="/api/group/join" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group ID</label>

            <div class="controls">
               <input type="text" name="group_id" value=""/><span class="param-name">group_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_leave"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Leave group</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group/leave</span></p>

      <form method="POST" action="/api/group/leave" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group ID</label>

            <div class="controls">
               <input type="text" name="group_id" value=""/><span class="param-name">group_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_invite"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Invite group</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group/invite</span></p>

      <form method="POST" action="/api/group/invite" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group ID</label>

            <div class="controls">
               <input type="text" name="group_id" value=""/><span class="param-name">group_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Users Ids</label>

            <div class="controls">
               <input type="text" name="users_ids" value=""/><span class="param-name">users_ids</span> (separated with comma)
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


</div>