<?php
/*servidor: nome do servidor (ex:localhost)
db: nome do banco de dados
user: usuário do banco
senha: senha de usuário do banco*/

define("HOST", "localhost");     // Para o host com o qual você quer se conectar.
define("USER", "gabuser");    // O nome de usuário para o banco de dados. 
define("PASSWORD", "12345");    // A senha do banco de dados. 
define("DATABASE", "gabinete");    // O nome do banco de dados. 

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

/* change character set to utf8 */
if (!$mysqli->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
}

?>