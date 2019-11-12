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
                <div class="page-header">
                    <h1 class="h2">Gestão de Gabinete</h1>
                    <h2>Versão 4.0</h2>                  
                </div>
                
                <h4>Desenvolvido pelo Serviço Tecnológico em Informática</h4>
                <h4>Câmara Municipal de Bauru / São Paulo</h4>
            </div>

            <?php include 'includes/footer.html'; ?>
        
        <?php } else { ?>
            <p>
                <span class="error">Você não tem autorização para acessar esta página.</span> Please <a href="index.php">login</a>.
            </p>
        <?php } ?>
            
  </body>
</html>