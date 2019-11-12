<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start();
    if(!empty($_POST)){
        if(isset($_POST['alt'])){  
            $cod_tip_doc = $_POST['cod_tip_doc'];
            $nom_tip_doc = $_POST['nom_tip_doc'];
            $ind_tip_doc = $_POST['ind_tip_doc'];
        }
        if (!empty($nom_tip_doc)){
            $insert = $mysqli->prepare("UPDATE gab_tipo_documento SET ind_tip_doc=?, nom_tip_doc=? WHERE cod_tip_doc=?");
            $insert->bind_param('ssi', $ind_tip_doc, $nom_tip_doc, $cod_tip_doc);

            if ($insert->execute()) {
                header('Location: form_cad_tipo_documento.php?msg=Tipo de documento alterado com sucesso!');
                die();
            }
            else{
                 header('Location: includes/error.php?err=Registration failure: INSERT');
                 die();
            }
        }
        else if(isset($_POST['nom_tip_doc']) ) {
            $nom_tip_doc = $_POST['nom_tip_doc'];
            $ind_tip_doc = 'A';
            
            $insert = $mysqli->prepare("INSERT INTO gab_tipo_documento (ind_tip_doc, nom_tip_doc) VALUES ( ?, ?)");
            $insert->bind_param('ss', $ind_tip_doc, $nom_tip_doc);
            if ($insert->execute()) {
                header('Location: form_cad_tipo_documento.php?msg=Tipo de documento cadastrado com sucesso!');
                die();
            }
            else{
                header('Location: form_cad_tipo_documento.php?err=Registration failure: INSERT');
                die();

            }
        }
    }
    else if (!empty ($_GET) && isset($_GET['del']) && isset($_GET['cod_tip_doc'])){
        $cod_tip_doc= $_GET['cod_tip_doc'];
        $resultado_del=$mysqli->query("SELECT cod_documento FROM gab_documento where GAB_TIPO_DOCUMENTO_cod_tip_doc = '$cod_tip_doc'");
        if($resultado_del->num_rows>0)
        {
            header('Location: form_cad_tipo_documento.php?err=Tipo de Documento vinculado a um Documento!');
            die();
        }
        $results  = $mysqli->prepare("DELETE FROM gab_tipo_documento WHERE cod_tip_doc=?");
        $results->bind_param('i', $cod_tip_doc);
        if ($results->execute()) {
           header('Location: form_cad_tipo_documento.php?msg=Tipo de documento excluído com sucesso!');
           die();
        }
        else{
            header('Location: form_cad_tipo_documento.php?err=Registration failure: DELETE');
            die();
        }
    }
?>