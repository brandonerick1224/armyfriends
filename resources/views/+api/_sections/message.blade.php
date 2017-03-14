<a name="message"></a>

<div class="api-group">

   <h1><i class="icon-book"></i>Messages</h1>


   <a name="message_chats"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Chats</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/message/chats</span></p>

      <form method="POST" action="/api/message/chats" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
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


   <a name="message_chat"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Chat</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/message/chat</span></p>

      <form method="POST" action="/api/message/chat" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Chat ID</label>

            <div class="controls">
               <input type="text" name="chat_id" value=""/><span class="param-name">chat_id</span> (or user_id)
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">User ID</label>

            <div class="controls">
               <input type="text" name="user_id" value=""/><span class="param-name">user_id</span> (or chat_id)
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


   <a name="message_send"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Send</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/message/send</span></p>

      <form method="POST" action="/api/message/send" class="form-horizontal">
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
         <div class="control-group">
            <label class="control-label">Message</label>

            <div class="controls">
               <input type="text" name="message" value=""/><span class="param-name">message</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>

</div>
