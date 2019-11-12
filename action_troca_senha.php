<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start();

    if(!empty($_POST)){
        if(isset($_POST['nom_usuario'], $_POST['p']))
        {
            //Alteração de senha
            $nom_usuario = filter_input(INPUT_POST, 'nom_usuario', FILTER_SANITIZE_STRING);
            
            $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);

            $bkp_pwd = $password;

            if (strlen($password) != 128) {
                // A senha com hash deve ter 128 caracteres.
                // Caso contrário, algo muito estranho está acontecendo
                header('Location: form_troca_senha.php?err=Configuração de senha inválida!');
                die();
            }
            
            // Crie um salt aleatório
            $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

            // Crie uma senha com salt 
            $password = hash('sha512', $password . $random_salt);
            
            $insert = $mysqli->prepare("UPDATE login SET ind_status = 'A', nom_senha=?, salt=? WHERE nom_usuario='$nom_usuario'");
            $insert->bind_param('ss', $password, $random_salt);
            
            if($insert->execute()){
                

                if (login($nom_usuario, $bkp_pwd, $mysqli) == true) {
                    //usuário Ativo
                    echo "
                    <script type='text/javascript'>             
                        alert('A Senha foi alterada com sucesso!');
                        window.location= 'form_inicio.php';
                    </script>";
                }
                else {
                    // Falha de login 
                    echo "
                    <script type='text/javascript'>             
                        alert('A Senha foi alterada com sucesso!');
                        window.location= 'index.php?error=1';
                    </script>";
                }
                
            }else{
                // Falha de login 
                echo "
                <script type='text/javascript'>             
                    alert('Erro na alteração de Senha!');
                    window.location= 'index.php?error=1';
                </script>";
            }
            
        }
    }
    
    
?>