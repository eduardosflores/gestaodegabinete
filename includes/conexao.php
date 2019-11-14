<?php

/*
--Substituir os parâmetros:
<server>: nome do servidor (ex:localhost)
<db>: nome do banco de dados
<user>: usuário do banco
<pass>: senha de usuário do banco
*/

if (file_exists('includes/conexao.local.php')){
    include_once 'includes/conexao.local.php';
}
else if (file_exists('../includes/conexao.local.php')){
    include_once '../includes/conexao.local.php';
}
else{
    define("HOST", "<server>");
    define("USER", "<user>");
    define("PASSWORD", "<pass>");
    define("DATABASE", "<db>");
}

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

/* change character set to utf8 */
if (!$mysqli->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
}

?>