/*
--Substituir os parâmetros:
<server>: nome do servidor (ex:localhost)
<db>: nome do banco de dados
<user>: usuário do banco
<pass>: senha de usuário do banco
*/


CREATE DATABASE <db> DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci; 

CREATE USER '<user>'@'<server>' IDENTIFIED BY '<pass>';

GRANT SELECT, INSERT, UPDATE, DELETE ON `<db>`.* TO '<user>'@'<server>';


