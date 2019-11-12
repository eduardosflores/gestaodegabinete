<?php
/**
Descrição: Form principal
*/

include_once 'includes/conexao.php';
include_once 'includes/functions.php';

session_start();
//var_dump($_SESSION);
?>
<html>
                
  <head>
    <?php include 'includes/head.html'; ?>
  </head>

  <body>
      
       <?php if (login_check($mysqli) == true) {?>
      
            <?php include 'includes/cabecalho.php'; ?>   

            <!-- Begin page content -->
            <div class="container" id="main">
                <h1 class="h2">Gestão de Gabinete</h1>
                <p class="h3">Versão 4.0</p>
                
                <p class="h4">Desenvolvido pelo Serviço Tecnológico em Informática</p>
                <p class="h4">Câmara Municipal de Bauru / São Paulo</p>
            </div>

            <?php include 'includes/footer.html'; ?>
        
        <?php } else { ?>
            <p>
                <span class="error">Você não tem autorização para acessar esta página.</span> Please <a href="index.php">login</a>.
            </p>
        <?php } ?>
            
  </body>
</html>