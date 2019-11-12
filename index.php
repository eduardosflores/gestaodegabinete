<?php
/**
Descrição: Login do sistema
*/

include_once 'includes/conexao.php';
include_once 'includes/functions.php';
 
session_start();
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="logo.png"> -->

    <title>Gestão de Gabinete</title>
    
     <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	  <link href="css/gabinete.css" rel="stylesheet">
	 
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
      
    <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href="css/signin.css" rel="stylesheet">

    <script src="js/jquery.js"></script>
    
    <script type="text/javascript" src="js/bootstrap.js"></script>

    <script type="text/JavaScript" src="js/sha512.js"></script> 
    
    <script type="text/JavaScript" src="js/forms.js"></script> 
        
  </head>

  <body> 
      
    <div class="container" style="margin: auto">
        <!--<img src="logo.png" class="center-block img-responsive">-->

        <form class="form-signin" action="login/process_login.php" method="post">
        <h2 class="form-signin-heading text-center" >Gestão de Gabinete</h2>
        <label for="inputNome" class="sr-only">Nome</label>
        <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite seu nome" required autofocus>
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" id="password" name="senha" class="form-control" placeholder="Senha" required>
        <div>
          <label></label>
          <!---<label>
            <input type="checkbox" value="remember-me">Continuar conectado
          </label>--->
            <?php
                if (isset($_GET['error'])) {
                    echo '<label class="label-error">Falha no login!</label>';
                }
            ?>
        </div>
        <button class="btn btn-lg btn-primary btn-block" onclick="formhash(this.form, this.form.senha);">Entrar</button>
                
      </form>

    </div> <!-- /container -->
 
    <?php include 'includes/footer.html';?>
		
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>