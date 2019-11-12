<?php
include_once 'includes/conexao.php';
include_once 'includes/functions.php';
    
session_start();
?>
<html>
    <head>
        <?php include 'includes/head.html'; ?>

        <link rel="stylesheet" href="css/jquery-ui-1.10.3.custom.min.css" />
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
    </head>

    <body>
       
    <?php if (login_check($mysqli) == true) {?>
        <?php include 'includes/cabecalho.php'; ?>
        <div class="container"  id="main">
            
            <div class="page-header">
                <?php if (isset($_GET['msg'])){
                    echo '<div class="alert acesso alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['msg'].'</strong></div>';                     
                   }
                 else if (isset($_GET['err'])){
                     echo '<div class="alert acesso alert-warning fade in "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['err'].'</strong></div>';
                 }
                 ?>
                <h1 class="h2">Manual do Usuário</h1>
                    
                
                
            </div>
            <iframe src="Manual_do_Usuario.pdf" width="800" height="650" style="border: none;"></iframe>
        </div>
        
        <?php include 'includes/footer.html'; ?>
             
        <?php } else { ?>
            <p>
                <span class="error">Você não tem autorização para acessar esta página.</span> Please <a href="index.php">login</a>.
            </p>
        <?php } ?>
    </body>
</html>
