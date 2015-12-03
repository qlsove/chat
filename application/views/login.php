<div id="container_demo" >
  <a class="hiddenanchor" id="toregister"></a>
  <a class="hiddenanchor" id="tologin"></a>
  <div id="wrapper">
    <div id="login" class="animate form">
      <form autocomplete="on" method="post"> 
        <h1>Log in</h1> 
        <p> 
          <span class="valid"></span>
          <label for="username" class="uname" data-icon="u" > Your email or username </label>
          <input id="username" name="username" required="required" type="text" />
        </p>
        <p> 
          <span class="valid"></span>
          <label for="password" class="youpasswd" data-icon="p"> Your password </label>
          <input id="password" name="password" required="required" type="password"  /> 
        </p>
        <p class="keeplogin"> 
          <input type="checkbox" name="loginkeeping" id="loginkeeping" /> 
          <label for="loginkeeping">Keep me logged in</label>
        </p>
        <p class="login button"> 
          <input class="loginbtn" type="button" name="loginbtn" value="Login" />
        </p>
        <p class="change_link">
          Not a member yet ?
          <a href="#toregister" class="to_register">Join us</a>
        </p>
      </form>
    </div>

    <div id="register" class="animate form">
      <form autocomplete="on" method="post"> 
        <h1>Sign up</h1> 
        <p> 
          <span class="valid"></span>
          <label for="usernamesignup" class="uname" data-icon="u">Your username</label>
          <input id="usernamesignup" name="usernamesignup" required="required" type="text"  />
        </p>
        <p> 
          <span class="valid"></span>
          <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
          <input id="emailsignup" name="emailsignup" required="required" type="email" /> 
        </p>
        <p> 
          <span class="valid"></span>
          <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
          <input id="passwordsignup" name="passwordsignup" required="required" type="password" />
        </p>
        <p> 
          <span class="valid"></span>
          <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
          <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" />
        </p>
        <p class="signin button"> 
          <input  class="signin-button" type="button" name="registerbtn" value="Sign up"/> 
        </p>
        <p class="change_link">  
          Already a member ?
          <a href="#tologin" class="to_register"> Go and log in </a>
        </p>
      </form>
    </div>
  </div>
</div>  
