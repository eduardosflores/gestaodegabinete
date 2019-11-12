<?php
/*
Descrição: Validação de Login no sistema
*/

include_once '../includes/conexao.php';
include_once '../includes/functions.php';
 
session_start(); // Nossa segurança personalizada para iniciar uma sessão php.
 
if (isset($_POST['nome'], $_POST['p'])) {
    $nome = $_POST['nome'];
    $password = $_POST['p']; // The hashed password.
    
    if (login($nome, $password, $mysqli) == true) {
        // Login com sucesso

        if ( isset($_SESSION['ind_status']) && $_SESSION['ind_status'] == 'N' ){
            //usuário Novo (primeiro acesso)
            //direcionar para página que altera senha
            header('Location: ../form_troca_senha.php');
        }
        else{
            //usuário Ativo
            header('Location: ../form_inicio.php');
        }
        
    } else {
        // Falha de login 
        header('Location: ../index.php?error=1');
    }
} else {
    // As variáveis POST corretas não foram enviadas para esta página. 
    echo 'Requisição Inválida';
}