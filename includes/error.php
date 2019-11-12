<?php
/**
Descrição: Página de erros
 */

 $error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
 
if (! $error) {
    $error = 'Desculpe, ocorreu um erro no sistema, por favor entre em contato com o Serviço Tecnológico em Informática!';
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Erro</title>
        <!--<link rel="stylesheet" href="styles/main.css" />-->
    </head>
    <body>
        <h1>Houve um problema</h1>
        <p class="error"><?php echo $error; ?></p>  
    </body>
</html>