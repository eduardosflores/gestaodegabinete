<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    
    if(!empty($_POST)){
        if( isset($_POST['alt']))
        {
            //Alteração
            $nom_usuario = $_POST['nom_usuario'];
            
            if(isset($_POST['ind_status']) && $_POST['ind_status'] == 'A')
                $ind_status='A';
            else
                $ind_status='I';
            
            if (!empty($nom_usuario)){
                $insert = $mysqli->prepare("UPDATE login SET ind_status=? WHERE nom_usuario='$nom_usuario'");
                $insert->bind_param('s', $ind_status);

                if ($insert->execute()) {
                    header('Location: form_cad_usuario.php?msg=Usuário alterado com sucesso!');
                    die();
                }
                else{
                     header('Location: form_cad_usuario.php?err=Erro na alteração!');
                     die();
                }
            }
           
        }
        else if(isset($_POST['pw'],$_POST['nom_usuario'], $_POST['p']))
        {
            //Alteração de senha
            
            $nom_usuario = filter_input(INPUT_POST, 'nom_usuario', FILTER_SANITIZE_STRING);
            
            $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
            if (strlen($password) != 128) {
                // A senha com hash deve ter 128 caracteres.
                // Caso contrário, algo muito estranho está acontecendo
                header('Location: form_cad_usuario.php?err=Configuração de senha inválida!');
                die();
            }
            
            // Crie um salt aleatório
            $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

            // Crie uma senha com salt 
            $password = hash('sha512', $password . $random_salt);
            
            $insert = $mysqli->prepare("UPDATE login SET nom_senha=?, salt=? WHERE nom_usuario='$nom_usuario'");
            $insert->bind_param('ss', $password, $random_salt);
            
            if($insert->execute()){
                header('Location: form_cad_usuario.php?msg=Senha alterada com sucesso!');
            }else{
                header('Location: form_cad_usuario.php?err=Erro na alteração');
            }
            
        }

        else if( isset($_POST['nom_usuario'], $_POST['p']) ) {             
            //Inserção
            
            // Limpa e valida os dados passados em 
            $nom_usuario = filter_input(INPUT_POST, 'nom_usuario', FILTER_SANITIZE_STRING);
            
            $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
            if (strlen($password) != 128) {
                // A senha com hash deve ter 128 caracteres.
                // Caso contrário, algo muito estranho está acontecendo
                header('Location: form_cad_usuario.php?err=Configuração de senha inválida!');
                die();
            }
            
            $ind_status = 'N'; //status para novo usuário / só muda para 'A' quando o usuário alterar a senha após acesso
           
            // Crie um salt aleatório
            $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

            // Crie uma senha com salt 
            $password = hash('sha512', $password . $random_salt);
            
                
            $select = $mysqli->query("SELECT nom_usuario FROM login WHERE nom_usuario = '$nom_usuario'");
            $num = $select->num_rows;

            if($num>0)
            {
                header('Location: form_cad_usuario.php?err=Nome de usuário já existente!');
            }
            else
            {
                $insert = $mysqli->prepare("INSERT INTO login (nom_usuario, nom_senha, salt, ind_status) VALUES (?, ?, ?, ?)");
                $insert->bind_param('ssss', $nom_usuario, $password, $random_salt, $ind_status);

                if ($insert->execute()) {
                    header('Location: form_cad_usuario.php?msg=Usuario incluído com sucesso!');
                    die();
                }
                else{

                     header('Location: form_cad_usuario.php?err=Erro na inclusão');
                     die();

                }
            }
        }
    }
    
    
    else if (!empty ($_GET) && isset($_GET['del']) && isset($_GET['nom_usuario'])){
        
        $nom_usuario = $_GET['nom_usuario'];
        
        $results = $mysqli->query("DELETE FROM login WHERE nom_usuario='$nom_usuario'");
            if($results){
                header('Location: form_cad_usuario.php?msg=usuário excluído com sucesso!');
            }else{
                header('Location: form_cad_usuario.php?err=Erro na exclusão');
            }
    }
?>