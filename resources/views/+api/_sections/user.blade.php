<a name="user"></a>

<div class="api-group">

   <h1><i class="icon-book"></i>User</h1>


   <a name="connect_socket"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Connect to socket</h2>

      <p><span class="label label-info"></span>This is not an API method, just for test sockets connection</p>

      <form method="POST" class="form-horizontal connect-to-socket not-api">

         <div class="control-group">
            <label class="control-label">Socket token</label>

            <div class="controls">
               <input type="text" name="socket_token" value=""/><span class="param-name"></span>
            </div>
         </div>

         <div class="form-actions">
            <button type="submit">Connect</button>
         </div>
      </form>
   </div>


   <a name="user_register"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>User Register</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/user/register</span></p>

      <form method="POST" action="/api/user/register" class="form-horizontal" enctype="multipart/form-data">

         <div class="control-group">
            <label class="control-label">User name</label>

            <div class="controls">
               <input type="text" name="name" value=""/><span class="param-name">name</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Email</label>

            <div class="controls">
               <input type="text" name="email" value=""/><span class="param-name">email</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Password</label>

            <div class="controls">
               <input type="text" name="password" value=""/><span class="param-name">password</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">First name</label>

            <div class="controls">
               <input type="text" name="first_name" value=""/><span class="param-name">first_name</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Last name</label>

            <div class="controls">
               <input type="text" name="last_name" value=""/><span class="param-name">last_name</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Country</label>

            <div class="controls">
               {!! Form::select('country', $countries->prepend('', ''),  null) !!}
               <span class="param-name">country</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">City</label>

            <div class="controls">
               <input type="text" name="city" value=""/><span class="param-name">city</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Birth date</label>

            <div class="controls">
               <input type="text" name="birth_date" value=""/><span class="param-name">birth_date</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Service start date</label>

            <div class="controls">
               <input type="text" name="service_start_date" value=""/><span class="param-name">service_start_date</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Service end date</label>

            <div class="controls">
               <input type="text" name="service_end_date" value=""/><span class="param-name">service_end_date</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Service country</label>

            <div class="controls">
               {!! Form::select('service_country', $countries->prepend('', ''),  null) !!}
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Service city</label>

            <div class="controls">
               <input type="text" name="service_city" value=""/><span class="param-name">service_city</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Profile image</label>

            <div class="controls">
               <input type="file" name="image" /><span class="param-name">image</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="user_login"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>User Login</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/user/login</span></p>

      <form method="POST" action="/api/user/login" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Email</label>

            <div class="controls">
               <input type="text" name="email" value=""/><span class="param-name">email</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Password</label>

            <div class="controls">
               <input type="text" name="password" value=""/><span class="param-name">password</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="user_forgot"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Forgot password</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/user/forgot</span></p>

      <form method="POST" action="/api/user/forgot" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Email</label>

            <div class="controls">
               <input type="text" name="email" value=""/><span class="param-name">email</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="user_logout"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>User Logout</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/user/logout</span></p>

      <form method="POST" action="/api/user/logout" class="form-horizontal">
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


   <a name="user_my_info"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>My info</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/user/my-info</span></p>

      <form method="POST" action="/api/user/my-info" class="form-horizontal">
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


   <a name="user_my_guests"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>My guests</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/user/my-guests</span></p>

      <form method="POST" action="/api/user/my-guests" class="form-horizontal">
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


   <a name="user_user_info"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>User info</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/user/user-info</span></p>

      <form method="POST" action="/api/user/user-info" class="form-horizontal">
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


   <a name="user_update_profile"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Update Profile</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/user/update-profile</span></p>

      <form method="POST" action="/api/user/update-profile" class="form-horizontal" enctype="multipart/form-data">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Password</label>

            <div class="controls">
               <input type="text" name="password" value=""/><span class="param-name">password</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">First name</label>

            <div class="controls">
               <input type="text" name="first_name" value=""/><span class="param-name">first_name</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Last name</label>

            <div class="controls">
               <input type="text" name="last_name" value=""/><span class="param-name">last_name</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Country</label>

            <div class="controls">
               {!! Form::select('country', $countries->prepend('', ''),  null) !!}
               <span class="param-name">country</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">City</label>

            <div class="controls">
               <input type="text" name="city" value=""/><span class="param-name">city</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Birth date</label>

            <div class="controls">
               <input type="text" name="birth_date" value=""/><span class="param-name">birth_date</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Service start date</label>

            <div class="controls">
               <input type="text" name="service_start_date" value=""/><span class="param-name">service_start_date</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Service end date</label>

            <div class="controls">
               <input type="text" name="service_end_date" value=""/><span class="param-name">service_end_date</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Service country</label>

            <div class="controls">
               {!! Form::select('service_country', $countries->prepend('', ''),  null) !!}
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Service city</label>

            <div class="controls">
               <input type="text" name="service_city" value=""/><span class="param-name">service_city</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">About me</label>

            <div class="controls">
               <textarea name="about_me"></textarea><span class="param-name">about_me</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Profile image</label>

            <div class="controls">
               <input type="file" name="image" /><span class="param-name">image</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Hide email</label>

            <div class="controls">
               {!! Form::select('options[hide_email]', ['0' => '0', '1' => '1']) !!}<span class="param-name">options[hide_email]</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


   <a name="user_search"></a>

   <div class="api">
      <h2><i class="icon-bookmark"></i>Search user</h2>

      <p><span class="label label-info">POST</span><span class="url">/api/user/search</span></p>

      <form method="POST" action="/api/user/search" class="form-horizontal">
         <div class="control-group">
            <label class="control-label">Api token</label>

            <div class="controls">
               <input type="text" name="api_token" value=""/><span class="param-name">api_token</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Name</label>

            <div class="controls">
               <input type="text" name="name" value=""/><span class="param-name">name</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">First name</label>

            <div class="controls">
               <input type="text" name="first_name" value=""/><span class="param-name">first_name</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Last name</label>

            <div class="controls">
               <input type="text" name="last_name" value=""/><span class="param-name">last_name</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Start date</label>

            <div class="controls">
               <input type="text" name="start_date" value=""/><span class="param-name">start_date</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">End date</label>

            <div class="controls">
               <input type="text" name="end_date" value=""/><span class="param-name">end_date</span>
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">Country</label>

            <div class="controls">
               {!! Form::select('country', $countries->prepend('', ''),  null) !!}
            </div>
         </div>
         <div class="control-group">
            <label class="control-label">City</label>

            <div class="controls">
               <input type="text" name="city" value=""/><span class="param-name">city</span>
            </div>
         </div>
         <div class="form-actions">
            <button type="submit">Done</button>
         </div>
      </form>
   </div>


</div>
