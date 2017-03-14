<a name="group_user"></a>

<div class="api-group">

   <h1><i class="icon-book"></i>Group users</h1>


   <a name="group_user_approve"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Approve request</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group_user/approve</span></p>

      <form method="POST" action="/api/group_user/approve" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group user ID</label>

            <div class="controls">
               <input type="text" name="group_user_id" value=""/><span class="param-name">group_user_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_user_decline"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Decline request</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group_user/decline</span></p>

      <form method="POST" action="/api/group_user/decline" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group user ID</label>

            <div class="controls">
               <input type="text" name="group_user_id" value=""/><span class="param-name">group_user_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_user_cancel"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Cancel invitation</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group_user/cancel</span></p>

      <form method="POST" action="/api/group_user/cancel" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group user ID</label>

            <div class="controls">
               <input type="text" name="group_user_id" value=""/><span class="param-name">group_user_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_user_accept"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Accept invitation</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group_user/accept</span></p>

      <form method="POST" action="/api/group_user/accept" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group user ID</label>

            <div class="controls">
               <input type="text" name="group_user_id" value=""/><span class="param-name">group_user_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_user_refuse"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Refuse invitation</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group_user/refuse</span></p>

      <form method="POST" action="/api/group_user/refuse" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group user ID</label>

            <div class="controls">
               <input type="text" name="group_user_id" value=""/><span class="param-name">group_user_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_user_update"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Update group user</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group_user/update</span></p>

      <form method="POST" action="/api/group_user/update" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group user ID</label>

            <div class="controls">
               <input type="text" name="group_user_id" value=""/><span class="param-name">group_user_id</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Type</label>

            <div class="controls">
               {{ Form::select('type', ['participant' => 'participant', 'admin' => 'admin']) }}<span class="param-name">type</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="group_user_remove"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Remove group user</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/group_user/remove</span></p>

      <form method="POST" action="/api/group_user/remove" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Group user ID</label>

            <div class="controls">
               <input type="text" name="group_user_id" value=""/><span class="param-name">group_user_id</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


</div>