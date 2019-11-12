<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start();
    if(!empty($_POST)){
        if(isset($_POST['alt'])){  
            $cod_status = $_POST['cod_status'];
            $nom_status = $_POST['nom_status'];
            $ind_status = $_POST['ind_status'];
        }
        if (!empty($nom_status)){
            $insert = $mysqli->prepare("UPDATE gab_status_atendimento SET ind_status=?, nom_status=? WHERE cod_status=?");
            $insert->bind_param('ssi', $ind_status, $nom_status, $cod_status);

            if ($insert->execute()) {
                header('Location: form_cad_status_atendimento.php?msg=Staus do atendimento alterado com sucesso!');
                die();
            }
            else{
                 header('Location: includes/error.php?err=Registration failure: INSERT');
                 die();
            }
        }
        else if(isset($_POST['nom_status']) ) {
            $nom_status = $_POST['nom_status'];
            $ind_status = 'A';
            
            $insert = $mysqli->prepare("INSERT INTO gab_status_atendimento (ind_status, nom_status) VALUES ( ?, ?)");
            $insert->bind_param('ss', $ind_status, $nom_status);
            if ($insert->execute()) {
                header('Location: form_cad_status_atendimento.php?msg=Tipo de atendimento cadastrado com sucesso!');
                die();
            }
            else{
                header('Location: form_cad_status_atendimento.php?err=Registration failure: INSERT');
                die();

            }
        }
    }
    else if (!empty ($_GET) && isset($_GET['del']) && isset($_GET['cod_status'])){
        $cod_status= $_GET['cod_status'];
        $resultado_del=$mysqli->query("SELECT cod_atendimento FROM gab_atendimento where GAB_STATUS_ATENDIMENTO_cod_status = '$cod_status'");
        if($resultado_del->num_rows>0)
        {
            header('Location: form_cad_status_atendimento.php?err=Status vinculado a um Atendimento!');
            die();
        }
        $results  = $mysqli->prepare("DELETE FROM gab_status_atendimento WHERE cod_status=?");
        $results->bind_param('i', $cod_status);
        if ($results->execute()) {
           header('Location: form_cad_status_atendimento.php?msg=Status de atendimento excluído com sucesso!');
           die();
        }
        else{
            header('Location: form_cad_status_atendimento.php?err=Registration failure: DELETE');
            die();
        }
    }
?>