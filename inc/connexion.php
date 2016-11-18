<!DOCTYPE html>
<html style="background-color: #0D2D4F;">

  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <title>
      Minichat - Connexion
    </title>
  </head>
<?php

if(isset($_SESSION['flash'])) {
  echo $_SESSION['flash'].'<br />'.PHP_EOL;
  unset($_SESSION['flash']); 
}
	?><body style="height:100%;background-color: #0D2D4F;">
    <div class="container" style="height:inherit;background-color: #0D2D4F;">
      <div class="row" style="height:inherit;background-color: #0D2D4F;">
        <div class="col-md-3 col-lg-3"></div>
        <div class="col-md-6 col-lg-6;background-color: #0D2D4F;">
          <div style="border: solid 1px;border-color: rgb(221, 221, 221); border-radius:4px;background-color: white;margin-top: 50px;height:300px"><h2>Se connecter<small> en anonyme ou en utilisant un pseudo créé ou à créer</small></h2>
          <br>
            <form action="./session/login.php" method="post">Entrez le captcha: 
              <br><input name="captcha" type="text"><img src="./inc/captcha.php">
              <br>Connexion
              <br><br>
              <input name="pseudo" type="text" placeholder="Pseudonyme">
              <br><input name="pass" type="password" placeholder="Mot de Passe">
              <input name="submit" type="submit">
              <input name="anonymous" value="Se connecter en anonyme" type="submit">
            </form>
          
          
          </div>
        </div>
        <div class="col-md-3 col-lg-3"></div>
        
      </div>
    </div>
  </body>

</html>