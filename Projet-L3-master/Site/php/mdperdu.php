<?php

include 'bibli_generale.php';

session_start();

ob_start();

$connecte = ifconnect();

html_debut("ADMIN - Mot de passe perdu", "../style/connect.css");

if($connecte==true){
	redirection('0', '../index.php');
}


?>
<div class="container">

  <div id="login-form">

    <h3>Login</h3>

    <fieldset>

      <form action="javascript:void(0);" method="get">

        <input type="email" required value="Email" onBlur="if(this.value=='')this.value='Email'" onFocus="if(this.value=='Email')this.value='' "> <!-- JS because of IE support; better: placeholder="Email" -->

        <input type="password" required value="Password" onBlur="if(this.value=='')this.value='Password'" onFocus="if(this.value=='Password')this.value='' "> <!-- JS because of IE support; better: placeholder="Password" -->

        <input type="submit" value="Login">

        <footer class="clearfix">

          <p><span class="info">?</span><a href="#">Forgot Password</a></p>

        </footer>

      </form>

    </fieldset>

  </div> <!-- end login-form -->

</div>
<?php


html_fin();

ob_end_flush();



?>