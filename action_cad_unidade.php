<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start();
       //var_dump($_POST);
       //var_dump($_GET);
        $username=$_SESSION['username'];
        if(!empty($_POST)){
            if(isset($_POST['alt'])){          
                //alteração
                $cod_uni_doc = $_POST['cod_uni_doc'];
                $ind_uni_doc = $_POST['ind_uni_doc'];
                $nom_uni = trim($_POST['nom_uni_doc']);
               

                if (!empty($nom_uni)){
                    $insert = $mysqli->prepare("UPDATE gab_unidade_documento SET nom_uni_doc=?, ind_uni_doc=? WHERE cod_uni_doc=?");
                    $insert->bind_param('ssi', $nom_uni, $ind_uni_doc, $cod_uni_doc);

                    if ($insert->execute()) {
                        header('Location: form_cad_unidade.php?msg=Unidade administrativa alterada com sucesso!');
                        die();
                    }
                    else{
                         header('Location: includes/error.php?err=Registration failure: INSERT');
                         die();
                    }
                }
            }
            else if(isset($_POST['nom_uni_doc']) ) {   
                
            //*****************************Inserção********************************************//

               
                $nom_uni = trim($_POST['nom_uni_doc']);
              
                $ind_uni_doc = "A";
                
            if (!empty($nom_uni)){

                    $insert = $mysqli->prepare("INSERT INTO gab_unidade_documento (nom_uni_doc,ind_uni_doc) VALUES ( ?, ?)");
                    $insert->bind_param('ss', $nom_uni, $ind_uni_doc);


                if ($insert->execute()) {
                    //echo "1";
                    header('Location: form_cad_unidade.php?msg=Unidade administrativa cadastrada com sucesso!');
                    die();
                }
                else{
                   // echo "2";
                    header('Location: form_cad_pessoa.php?err=Registration failure: INSERT');
                    die();

                }
            }
        }
    }
    else if (!empty ($_GET) && isset($_GET['del']) && isset($_GET['cod_uni_doc'])){
        //Exclusão
        $cod_uni_doc=$_GET['cod_uni_doc'];
        $resultado_del=$mysqli->query("SELECT cod_documento FROM gab_documento where GAB_UNIDADE_DOCUMENTO_cod_uni_doc =$cod_uni_doc");
        if($resultado_del->num_rows>0)
        {
            header('Location: form_cad_unidade.php?err=Unidade Administrativa vinculada a um Documento!');
            die();
        }
        
        $results  = $mysqli->prepare("DELETE FROM gab_unidade_documento WHERE cod_uni_doc=?");
        $results->bind_param('i', $cod_uni_doc);
        if ($results->execute()) {
           header('Location: form_cad_unidade.php?msg=Unidade administrativa excluída com sucesso!');
           die();
        }
        else{
            header('Location: form_cad_unidade.php?err=Registration failure: DELETE');
            die();
        }
    }
?>

