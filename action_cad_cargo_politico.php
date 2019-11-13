<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start();
    if(!empty($_POST)){
        if(isset($_POST['alt'])){  
            $cod_car_pol = $_POST['cod_car_pol'];
            $nom_car_pol = $_POST['nom_car_pol'];
            $ind_car_pol = $_POST['ind_car_pol'];
        }
        if (!empty($nom_car_pol)){
            $insert = $mysqli->prepare("UPDATE gab_cargo_politico SET ind_car_pol=?, nom_car_pol=? WHERE cod_car_pol=?");
            $insert->bind_param('ssi', $ind_car_pol, $nom_car_pol, $cod_car_pol);

            if ($insert->execute()) {
                header('Location: form_cad_cargo_politico.php?msg=Tipo de documento alterado com sucesso!');
                die();
            }
            else{
                 header('Location: includes/error.php?err=Registration failure: INSERT');
                 die();
            }
        }
        else if(isset($_POST['nom_car_pol']) ) {
            $nom_car_pol = $_POST['nom_car_pol'];
            $ind_car_pol = 'A';
            
            $insert = $mysqli->prepare("INSERT INTO gab_cargo_politico (ind_car_pol, nom_car_pol) VALUES ( ?, ?)");
            $insert->bind_param('ss', $ind_car_pol, $nom_car_pol);
            if ($insert->execute()) {
                header('Location: form_cad_cargo_politico.php?msg=Tipo de documento cadastrado com sucesso!');
                die();
            }
            else{
                header('Location: form_cad_cargo_politico.php?err=Registration failure: INSERT');
                die();

            }
        }
    }
    else if (!empty ($_GET) && isset($_GET['del']) && isset($_GET['cod_car_pol'])){
        $cod_car_pol= $_GET['cod_car_pol'];
        $resultado_del=$mysqli->query("SELECT cod_documento FROM gab_documento where gab_cargo_politico_cod_car_pol = '$cod_car_pol'");
        if($resultado_del->num_rows>0)
        {
            header('Location: form_cad_cargo_politico.php?err=Tipo de Documento vinculado a um Documento!');
            die();
        }
        $results  = $mysqli->prepare("DELETE FROM gab_cargo_politico WHERE cod_car_pol=?");
        $results->bind_param('i', $cod_car_pol);
        if ($results->execute()) {
           header('Location: form_cad_cargo_politico.php?msg=Tipo de documento excluído com sucesso!');
           die();
        }
        else{
            header('Location: form_cad_cargo_politico.php?err=Registration failure: DELETE');
            die();
        }
    }
?>