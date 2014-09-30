<?php
 require_once("acesso.php");
	
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo NameSystem;?></title>
    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  </head>
  <body>
    <h1><?php echo NameSystem;?></h1>
    <script src="ui/js//jquery-latest.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<form class="well" action="start.php">
	    <label>Email</label>
	      <input class="span3" type="text" id="inputEmail" placeholder="Email">
	    <label>Senha</label>
	      <input class="span3" type="password" id="inputPassword" placeholder="Senha"></br>
	      <button type="submit" class="btn btn-primary">Entrar</button>
	      <button type="submit" class="btn">Limpar</button>	      
	</form>  
  </body>
</html>