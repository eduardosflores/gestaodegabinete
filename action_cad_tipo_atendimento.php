<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start();
    if(!empty($_POST)){
        if(isset($_POST['alt'])){  
            $cod_tipo = $_POST['cod_tipo'];
            $nom_tipo = $_POST['nom_tipo'];
            $ind_tipo = $_POST['ind_tipo'];
        }
        if (!empty($nom_tipo)){
            $insert = $mysqli->prepare("UPDATE gab_tipo_atendimento SET ind_tipo=?, nom_tipo=? WHERE cod_tipo=?");
            $insert->bind_param('ssi', $ind_tipo, $nom_tipo, $cod_tipo);

            if ($insert->execute()) {
                header('Location: form_cad_tipo_atendimento.php?msg=Tipo de atendimento alterado com sucesso!');
                die();
            }
            else{
                 header('Location: includes/error.php?err=Registration failure: INSERT');
                 die();
            }
        }
        else if(isset($_POST['nom_tipo']) ) {
            $nom_tipo = $_POST['nom_tipo'];
            $ind_tipo = 'A';
            
            $insert = $mysqli->prepare("INSERT INTO gab_tipo_atendimento (ind_tipo, nom_tipo) VALUES ( ?, ?)");
            $insert->bind_param('ss', $ind_tipo, $nom_tipo);
            if ($insert->execute()) {
                header('Location: form_cad_tipo_atendimento.php?msg=Tipo de atendimento cadastrado com sucesso!');
                die();
            }
            else{
                header('Location: form_cad_tipo_atendimento.php?err=Registration failure: INSERT');
                die();

            }
        }
    }
    else if (!empty ($_GET) && isset($_GET['del']) && isset($_GET['cod_tipo'])){
        $cod_tipo= $_GET['cod_tipo'];
        $resultado_del=$mysqli->query("SELECT cod_atendimento FROM gab_atendimento where GAB_TIPO_ATENDIMENTO_cod_tipo = '$cod_tipo'");
        if($resultado_del->num_rows>0)
        {
            header('Location: form_cad_tipo_atendimento.php?err=Tipo de atendimento vinculado a um Atendimento!');
            die();
        }
        $results  = $mysqli->prepare("DELETE FROM gab_tipo_atendimento WHERE cod_tipo=?");
        $results->bind_param('i', $cod_tipo);
        if ($results->execute()) {
           header('Location: form_cad_tipo_atendimento.php?msg=Tipo de atendimento excluído com sucesso!');
           die();
        }
        else{
            header('Location: form_cad_tipo_atendimento.php?err=Registration failure: DELETE');
            die();
        }
    }
?>