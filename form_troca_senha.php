<?php
/**
Descrição: Página para Troca de senha no primeiro Acesso do Usuário    
*/

include_once 'includes/conexao.php';
include_once 'includes/functions.php';
    
session_start();
?>
<html>
  <head>
    <?php include 'includes/head.html'; ?>
    
        <link rel="stylesheet" href="css/jquery-ui-1.12.0.css">

        <script src="js/jquery-1.12.4.js"></script>
        <script src="js/jquery-ui-1.12.0.js"></script>
        <script src="js/jquery.maskedinput.js"></script>
        <script src="js/functions.js"></script>
                  
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        
  </head>

  <body>
       
   <?php if ( isset($_SESSION['ind_status']) && $_SESSION['ind_status'] == 'N' ){ 
        include 'includes/cabecalho.php';
            if (!empty ($_GET) && (isset($_GET['alt']) || isset($_GET['pw'])) && isset($_GET['nom_usuario'])){
                $nom_usuario = $_GET['nom_usuario'];
                if ($resultado=$mysqli->query("SELECT nom_usuario, nom_senha, ind_status  FROM login WHERE nom_usuario='$nom_usuario'")){
                    if ($resultado->num_rows){
                        $linha=$resultado->fetch_object();
                    }
                }
            }
    ?>

      <div class="container" id="main">
          
            <div class="page-header">
                <?php if (isset($_GET['msg'])){
                    echo '<div class="alert acesso alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['msg'].'</strong></div>';                     
                   }
                 else if (isset($_GET['err'])){
                     echo '<div class="alert acesso alert-warning fade in "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['err'].'</strong></div>';
                 }
                 ?>
                <h1 class="h2">Troca de Senha</h1>
            </div>
          
            <form  name="form" class="form-horizontal" method="post" action="action_troca_senha.php">
                
                <div class="form-group">
                    <label class="col-md-2 control-label" autocomplete="on">Nome de Usuário: </label>
                    <div class="col-md-4">
                        <input class="txt-auto form-control" type='text' name='nom_usuario' id='nom_usuario' required
                        <?php if ( isset($_SESSION['username']) ) {echo "value='".$_SESSION['username']."' readonly";}?>/>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-md-2 control-label">Senha:</label> 
                    <div class="col-md-4">
                        <input type="password" class="form-control txt-auto" name="nom_senha" id="nom_senha" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" autocomplete="on">Confirmar Senha: </label>
                    <div class="col-md-4">
                        <input type="password" class="form-control txt-auto" name="confirma_nom_senha" id="confirma_nom_senha" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 text-right">
                        <input type="button" class="btn btn-default" value='Trocar Senha'
                        onclick="return regformhash(this.form, this.form.nom_usuario, this.form.nom_senha, this.form.confirma_nom_senha);" />
                    </div>
                </div>
            </form>
             
            </div> 
   
    
    <?php include 'includes/footer.html'; ?>
             
        <?php } else { ?>
            <p>
                <span class="error">Você não tem autorização para acessar esta página.</span> Please <a href="index.php">login</a>.
            </p>
        <?php } ?>
  </body>
</html>