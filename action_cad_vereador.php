<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start();
       //var_dump($_POST);
       //var_dump($_GET);
       //var_dump($_FILES);
    
        $username=$_SESSION['username'];
        
        // Constante
        define('TAMANHO_MAXIMO', (2 * 1024 * 1024));

        if(!empty($_POST)){
            if(isset($_POST['alt'])){          
                //Alteração
                
                $nom_vereador = trim($_POST['nom_vereador']);

                if (isset($_POST['cod_car_pol']) && !empty($_POST['cod_car_pol']))
                    $cod_car_pol = $_POST['cod_car_pol'];
                else
                    $cod_car_pol=NULL;

                if (isset($_POST['nom_orgao']) && !empty($_POST['nom_orgao'])){
                    $nom_orgao = trim($_POST['nom_orgao']);
                }
                else {
                    $nom_orgao = NULL;
                }

                if (isset($_POST['nom_estado']) && !empty($_POST['nom_estado'])){
                     $nom_estado = trim($_POST['nom_estado']);
                }
                else {
                    $nom_estado = NULL;
                }
                if (isset($_POST['num_cep']) && !empty($_POST['num_cep'])){
                     $num_cep = trim($_POST['num_cep']);
                }
                else {
                    $num_cep = NULL;
                }
                if (isset($_POST['nom_cidade']) && !empty($_POST['nom_cidade'])){
                     $nom_cidade = trim($_POST['nom_cidade']);
                }
                else {
                    $nom_cidade = NULL;
                }
                if (isset($_POST['nom_endereco']) && !empty($_POST['nom_endereco'])){
                     $nom_endereco = trim($_POST['nom_endereco']);
                }
                else {
                    $nom_endereco = NULL;
                }
                if (isset($_POST['nom_numero']) && !empty($_POST['nom_numero'])){
                     $nom_numero = trim($_POST['nom_numero']);
                }
                else {
                    $nom_numero = NULL;
                }
                if (isset($_POST['nom_complemento']) && !empty($_POST['nom_complemento'])){
                     $nom_complemento = trim($_POST['nom_complemento']);
                }
                else {
                    $nom_complemento = NULL;
                }      
                
                if (!empty($nom_vereador)){
                    
                    //////////////////////////////////////////////////////////////////////////
                
                    if (isset($_FILES['foto']) && !empty($_FILES['foto']['name']) ){ //foi selecionada uma imagem
                        // Recupera os dados dos campos
                        $foto = $_FILES['foto'];
                        $tipo = $foto['type'];
                        $tamanho = $foto['size'];

                        // Validações básicas
                        //erro
                        if ($foto['error']!='0'){
                            header('Location: form_cad_vereador.php?err=A foto não atende aos padrões solicitados para upload. Favor verificar!');
                            die();
                        }
                        // Formato
                        if(!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp)$/', $tipo))
                        { 
                            header('Location: form_cad_vereador.php?err=A foto não possui extensão/formato de arquivo permitido!');
                            die();
                        }

                        // Tamanho
                        if ($tamanho > TAMANHO_MAXIMO)
                        {
                            header('Location: form_cad_vereador.php?err=A foto deve possuir no máximo 2 MB!');
                            echo retorno('');
                            exit;
                        }
                        // Transformando foto em dados (binário)
                        $conteudo = file_get_contents($foto['tmp_name']);
                        
                        $update = $mysqli->prepare("UPDATE gab_vereador SET nom_vereador=?, GAB_CARGO_POLITICO_cod_car_pol=?, nom_orgao=?, num_cep=?, nom_endereco=?, nom_numero=?, nom_complemento=?, nom_cidade=?, nom_estado=?, img_foto=?, tip_foto=?, tam_foto=?");
                        $update->bind_param('sssssssssssi', $nom_vereador, $cod_car_pol, $nom_orgao, $num_cep, $nom_endereco, $nom_numero, $nom_complemento, $nom_cidade, $nom_estado, $conteudo, $tipo, $tamanho);

                        if ($update->execute()) {
                            header('Location: form_cad_vereador.php?msg=Alteração realizada com sucesso!');
                            die();
                        }
                        else{
                             header('Location: includes/error.php?err=Registration failure: UPDATE');
                             die();
                        }
                    }
                    else { //NÃO foi selecionada uma imagem
                        
                        $update = $mysqli->prepare("UPDATE gab_vereador SET nom_vereador=?, GAB_CARGO_POLITICO_cod_car_pol=?, nom_orgao=?, num_cep=?, nom_endereco=?, nom_numero=?, nom_complemento=?, nom_cidade=?, nom_estado=?");
                        $update->bind_param('sssssssss', $nom_vereador, $cod_car_pol, $nom_orgao, $num_cep, $nom_endereco, $nom_numero, $nom_complemento, $nom_cidade, $nom_estado);

                        if ($update->execute()) {
                            header('Location: form_cad_vereador.php?msg=Alteração realizada com sucesso!');
                            die();
                        }
                        else{
                             header('Location: includes/error.php?err=Registration failure: UPDATE');
                             die();
                        }
                    }
                }
            }
            else if(isset($_POST['nom_vereador']) ) {                   
                //Inserção

                $nom_vereador = trim($_POST['nom_vereador']);

                if (isset($_POST['cod_car_pol']) && !empty($_POST['cod_car_pol']))
                    $cod_car_pol = $_POST['cod_car_pol'];
                else
                    $cod_car_pol=NULL;

                if (isset($_POST['nom_orgao']) && !empty($_POST['nom_orgao'])){
                    $nom_orgao = trim($_POST['nom_orgao']);
                }
                else {
                    $nom_orgao = NULL;
                }

                if (isset($_POST['nom_estado']) && !empty($_POST['nom_estado'])){
                     $nom_estado = trim($_POST['nom_estado']);
                }
                else {
                    $nom_estado = NULL;
                }
                if (isset($_POST['num_cep']) && !empty($_POST['num_cep'])){
                     $num_cep = trim($_POST['num_cep']);
                }
                else {
                    $num_cep = NULL;
                }
                if (isset($_POST['nom_cidade']) && !empty($_POST['nom_cidade'])){
                     $nom_cidade = trim($_POST['nom_cidade']);
                }
                else {
                    $nom_cidade = NULL;
                }
                if (isset($_POST['nom_endereco']) && !empty($_POST['nom_endereco'])){
                     $nom_endereco = trim($_POST['nom_endereco']);
                }
                else {
                    $nom_endereco = NULL;
                }
                if (isset($_POST['nom_numero']) && !empty($_POST['nom_numero'])){
                     $nom_numero = trim($_POST['nom_numero']);
                }
                else {
                    $nom_numero = NULL;
                }
                if (isset($_POST['nom_complemento']) && !empty($_POST['nom_complemento'])){
                     $nom_complemento = trim($_POST['nom_complemento']);
                }
                else {
                    $nom_complemento = NULL;
                }      
                
                if (!empty($nom_vereador)){
                

                    if (isset($_FILES['foto']) && !empty($_FILES['foto']['name']) ){ //foi selecionada uma imagem
                        // Recupera os dados dos campos
                        $foto = $_FILES['foto'];
                        $tipo = $foto['type'];
                        $tamanho = $foto['size'];

                        // Validações básicas
                        //erro
                        if ($foto['error']!='0'){
                            header('Location: form_cad_vereador.php?err=A foto não atende aos padrões solicitados para upload. Favor verificar!');
                            die();
                        }
                        // Formato
                        if(!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp)$/', $tipo))
                        { 
                            header('Location: form_cad_vereador.php?err=A foto não possui extensão/formato de arquivo permitido!');
                            die();
                        }

                        // Tamanho
                        if ($tamanho > TAMANHO_MAXIMO)
                        {
                            header('Location: form_cad_vereador.php?err=A foto deve possuir no máximo 2 MB!');
                            echo retorno('');
                            exit;
                        }
                        // Transformando foto em dados (binário)
                        $conteudo = file_get_contents($foto['tmp_name']);
                        
                        $insert = $mysqli->prepare("INSERT INTO gab_vereador (nom_vereador, GAB_CARGO_POLITICO_cod_car_pol, nom_orgao, num_cep, nom_endereco, nom_numero, nom_complemento, nom_cidade, nom_estado, img_foto, tip_foto, tam_foto) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $insert->bind_param('sssssssssssi', $nom_vereador, $cod_car_pol, $nom_orgao, $num_cep, $nom_endereco, $nom_numero, $nom_complemento, $nom_cidade, $nom_estado, $conteudo, $tipo, $tamanho);

                        if ($insert->execute()) {
                            header('Location: form_cad_vereador.php?msg=Cadastro realizado com sucesso!');
                            die();
                        }
                        else{
                            header('Location: includes/error.php?err=Registration failure: INSERT');
                            die();
                        }
                        
                    }
                    else { //NÃO foi selecionada uma imagem
                        
                         $insert = $mysqli->prepare("INSERT INTO gab_vereador (nom_vereador, GAB_CARGO_POLITICO_cod_car_pol, nom_orgao, num_cep, nom_endereco, nom_numero, nom_complemento, nom_cidade, nom_estado) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)");
                         $insert->bind_param('sssssssss', $nom_vereador, $cod_car_pol, $nom_orgao, $num_cep, $nom_endereco, $nom_numero, $nom_complemento, $nom_cidade, $nom_estado);

                        if ($insert->execute()) {
                            header('Location: form_cad_vereador.php?msg=Cadastro realizado com sucesso!');
                            die();
                        }
                        else{
                            header('Location: includes/error.php?err=Registration failure: INSERT');
                            die();
                        }
                        
                    }
                }
            }
        }
   
    
?>

