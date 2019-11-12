<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start();
    //var_dump($_POST);
    //var_dump($_GET);
    //var_dump($_FILES);

    $username=$_SESSION['username'];

    if(!empty($_POST)){
        if(isset($_POST['alt'])){
            //Alteração

            if (isset($_POST['api_key']) && !empty($_POST['api_key'])){
                $api_key = trim($_POST['api_key']);
            }else{
                $api_key = NULL;
            }
            if (isset($_POST['calendar_id']) && !empty($_POST['calendar_id'])){
                    $calendar_id = trim($_POST['calendar_id']);
            }else{
                $calendar_id = NULL;
            }

            $update = $mysqli->prepare("UPDATE gab_calendar_key SET api_key=?, calendar_id=?");
            $update->bind_param('ss', $api_key, $calendar_id);

            if ($update->execute()){
                header('Location: form_cad_agenda.php?msg=Alteração realizada com sucesso!');
                die();
            }else{
                header('Location: includes/error.php?err=Registration failure: UPDATE');
                die();
            }

        }else{
            //Inserção

            if (isset($_POST['api_key']) && !empty($_POST['api_key'])){
                $api_key = trim($_POST['api_key']);
            }else{
                $api_key = NULL;
            }
            if (isset($_POST['calendar_id']) && !empty($_POST['calendar_id'])){
                    $calendar_id = trim($_POST['calendar_id']);
            }else{
                $calendar_id = NULL;
            }

            $insert = $mysqli->prepare("INSERT INTO gab_calendar_key (api_key, calendar_id) VALUES ( ?, ?)");
            $insert->bind_param('ss', $api_key, $calendar_id);

            if ($insert->execute()) {
                header('Location: form_cad_agenda.php?msg=Cadastro realizado com sucesso!');
                die();
            }else{
                header('Location: includes/error.php?err=Registration failure: INSERT');
                die();
            }
        }
    }
?>

