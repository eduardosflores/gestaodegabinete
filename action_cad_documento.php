<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start();
    
    $username=$_SESSION['username'];
    $ind_status = "A";
    
    //var_dump($_POST);
    //var_dump($_GET);
    //var_dump($_FILES);
    
    if(!empty($_POST)){
        
        if(isset($_POST['alt'])){
            
            $cod_documento = $_POST['cod_documento'];
            
            if (isset($_POST['cod_tipo']) && !empty($_POST['cod_tipo']))
                $cod_tipo = $_POST['cod_tipo'];
            else
                $cod_tipo=NULL;
            
            if (isset($_POST['cod_uni_doc']) && !empty($_POST['cod_uni_doc']))
                $cod_uni_doc = $_POST['cod_uni_doc'];
            else
                $cod_uni_doc = NULL;
            
            if (isset($_POST['nom_documento']) && !empty($_POST['nom_documento']))
                $nom_documento = $_POST['nom_documento'];
            else
                $nom_documento=NULL;
            
            if (isset($_POST['dat_ano']) && !empty($_POST['dat_ano']))
                $dat_ano = $_POST['dat_ano'];
            else
                $dat_ano=NULL;
            
            $dat_documento = converte_data($_POST['dat_documento']);
            
            if (isset($_POST['lnk_documento']) && !empty($_POST['lnk_documento']))
                $lnk_documento = $_POST['lnk_documento'];
            elseif (isset($_POST['lnk_documento_bkp']) && !empty($_POST['lnk_documento_bkp']))
                $lnk_documento = $_POST['lnk_documento_bkp'];
            else
                $lnk_documento=NULL;
            
            if (isset($_POST['cod_status']) && !empty($_POST['cod_status']))
                $cod_status = $_POST['cod_status'];
            else
                $cod_status=NULL;
            
            if (isset($_POST['txt_assunto']) && !empty($_POST['txt_assunto']))
                $txt_assunto = $_POST['txt_assunto'];
            else
                $txt_assunto=NULL;
            
            if(!empty($_POST['cod_atendimento']) && isset($_POST['check_atendimento']))
                $cod_atendimento = $_POST['cod_atendimento'];
            else
                $cod_atendimento = NULL;
            
            if(!empty($_POST['dat_resposta']) && isset($_POST['check_resposta']))
                $dat_resposta = converte_data($_POST['dat_resposta']);
            else
                $dat_resposta = NULL;
            
            if (isset($_POST['txt_resposta'])&& !empty($_POST['txt_resposta']) && isset($_POST['check_resposta']))
                $txt_resposta = $_POST['txt_resposta'];
            else
                $txt_resposta = NULL;
                             
            if (isset($_POST['lnk_resposta']) && !empty($_POST['lnk_resposta']) && isset($_POST['check_resposta']))
                $lnk_resposta = $_POST['lnk_resposta'];
            elseif (isset($_POST['lnk_resposta_bkp']) && !empty($_POST['lnk_resposta_bkp']) && isset($_POST['check_resposta']))
                $lnk_resposta = $_POST['lnk_resposta_bkp'];
            else
                $lnk_resposta=NULL;
            
            if (!empty($cod_documento)){
                $insert = $mysqli->prepare("UPDATE gab_documento SET nom_documento=?, dat_ano=?, dat_documento=?, lnk_documento=?, txt_assunto=?, GAB_TIPO_DOCUMENTO_cod_tip_doc=?, "
                        . "GAB_STATUS_DOCUMENTO_cod_status=?, GAB_UNIDADE_DOCUMENTO_cod_uni_doc=?, GAB_ATENDIMENTO_cod_atendimento=?, dat_resposta=?, txt_resposta=?, lnk_resposta=?, dat_log=NOW(), nom_usuario_log='$username', nom_operacao_log='UPDATE' WHERE cod_documento=?");
                $insert->bind_param('sssssiiiisssi', $nom_documento, $dat_ano, $dat_documento, $lnk_documento, $txt_assunto, $cod_tipo, $cod_status, $cod_uni_doc, $cod_atendimento, $dat_resposta, $txt_resposta, $lnk_resposta, $cod_documento);
                if ($insert->execute()) 
                {   
                    
                    if (isset($_POST['check_alt'])){
                        $dir = "documentos/";
                        if(($dh = opendir($dir)) != FALSE){
                            while (false !== ($filename = readdir($dh))) {
                                //echo $filename;
                                $pos = strripos($filename,".");
                                //echo 'pos:'.$pos;
                                $aux_doc = substr($filename,0,$pos);
                                //echo 'aux_doc:'.$aux_doc."-";

                                if ($aux_doc == $cod_documento) {
                                    $extensao=explode(".",$filename)[1];
                                    $nom_doc = $cod_documento.".".$extensao;
                                    unlink("documentos/".$nom_doc);
                                }
                            }
                        }
                    }
                    if(isset($_FILES['documento']) && ($_FILES['documento']['size'])>0 ){    

                        // Pasta onde o arquivo vai ser salvo
                        $_UP['pasta'] = 'documentos/';

                        // Tamanho máximo do arquivo (em Bytes)
                        $_UP['tamanho'] = 1024 * 1024 * 25;

                        // Array com as extensões permitidas
                        $_UP['extensoes'] = array('pdf', 'doc', 'odt', 'docx');

                        // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
                        $_UP['renomeia'] = true;

                        // Array com os tipos de erros de upload do PHP
                        $_UP['erros'][0] = 'Não houve erro';
                        $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
                        $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
                        $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
                        $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

                        // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
                        if ($_FILES['documento']['error'] != 0) {
                            header('Location: form_cad_documento.php?err= '. $_UP['erros'][$_FILES['documento']['error']]);
                            die();
                        }

                        // Faz a verificação da extensão do arquivo
                        $extensao = strtolower(end(explode('.', $_FILES['documento']['name'])));
                        if (array_search($extensao, $_UP['extensoes']) === true) {
                            header('Location: form_cad_documento.php?err=Extensão de arquivo não permitida! (Extensões permitidas: pdf, doc, odt, docx)');
                            die();
                        }

                        if ($_UP['tamanho'] < $_FILES['documento']['size']) {
                            header('Location: form_cad_documento.php?err=O arquivo enviado é muito grande, envie arquivos de até 25 MB.');
                            die();
                        }

                        $pega_extensao =  strtolower(end(explode(".", $_FILES["documento"]["name"])));
                        $nome_final = $cod_documento.".".$pega_extensao;
                        // ***********************************Depois verifica se é possível mover o arquivo para a pasta escolhida **********************
                        if (!move_uploaded_file($_FILES['documento']['tmp_name'], $_UP['pasta'].$nome_final)) 
                        {
                            header('Location: form_cad_documento.php?err=Erro no upload do arquivo!');
                            die();
                        }
                    }
                    
                    if (isset($_POST['check_alt_resposta'])){
                        $dir = "respostas/";
                        if(($dh = opendir($dir)) != FALSE){
                            while (false !== ($filename = readdir($dh))) {
                                //echo $filename;
                                $pos = strripos($filename,".");
                                //echo 'pos:'.$pos;
                                $aux_doc = substr($filename,0,$pos);
                                //echo 'aux_doc:'.$aux_doc."-";

                                if ($aux_doc == $cod_documento) {
                                    $extensao=explode(".",$filename)[1];
                                    $nom_doc = $cod_documento.".".$extensao;
                                    unlink("respostas/".$nom_doc);
                                }
                            }
                        }
                    }
                    
                    if(isset($_FILES['documento_resposta']) && ($_FILES['documento_resposta']['size'])>0 && isset($_POST['check_resposta']))
                    {
                        // Pasta onde o arquivo vai ser salvo
                        $_UP['pasta'] = 'respostas/';

                        // Tamanho máximo do arquivo (em Bytes)
                        $_UP['tamanho'] = 1024 * 1024 * 25;

                        // Array com as extensões permitidas
                        $_UP['extensoes'] = array('pdf', 'doc', 'odt', 'docx');

                        // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
                        $_UP['renomeia'] = true;

                        // Array com os tipos de erros de upload do PHP
                        $_UP['erros'][0] = 'Não houve erro';
                        $_UP['erros'][1] = 'O arquivo de resposta no upload é maior do que o limite do PHP';
                        $_UP['erros'][2] = 'O arquivo de resposta ultrapassa o limite de tamanho especifiado no HTML';
                        $_UP['erros'][3] = 'O upload do arquivo de resposta foi feito parcialmente';
                        $_UP['erros'][4] = 'Não foi feito o upload do arquivo de resposta';

                        // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
                        if ($_FILES['documento_resposta']['error'] != 0) {
                            header('Location: form_cad_documento.php?err= '. $_UP['erros'][$_FILES['documento_resposta']['error']]);
                            die();
                        }

                        // Faz a verificação da extensão do documento_resposta
                        $extensao = strtolower(end(explode('.', $_FILES['documento_resposta']['name'])));
                        if (array_search($extensao, $_UP['extensoes']) === true) {
                            header('Location: form_cad_documento.php?err=Extensão do arquivo de resposta não permitida! (Extensões permitidas: pdf, doc, odt, docx)');
                            die();
                        }

                        if ($_UP['tamanho'] < $_FILES['documento_resposta']['size']) {
                            header('Location: form_cad_documento.php?err=O arquivo de resposta é muito grande, envie arquivos de até 25 MB.');
                            die();
                        }
                        
                        $pega_extensao =  strtolower(end(explode(".", $_FILES["documento_resposta"]["name"])));
                        $nome_final = $cod_documento.".".$pega_extensao;
                        if (!move_uploaded_file($_FILES['documento_resposta']['tmp_name'], $_UP['pasta'].$nome_final)) 
                        {
                            header('Location: form_cad_documento.php?err=Erro no upload do arquivo de resposta!');
                            die();
                        }
                    }
                        
                    header('Location: form_cad_documento.php?msg=Documento alterado com sucesso!');
                    die();
                }
                else{
                    header('Location: form_cad_documento.php?err=Registration failure: UPDATE');
                    die();
                }
            }
        }
        
               
        else if(isset($_POST['nom_documento']) && isset($_POST['cod_status']) && isset($_POST['cod_tipo']) && !isset($_POST['alt'])){

            if (isset($_POST['cod_tipo']) && !empty($_POST['cod_tipo']))
                $cod_tipo = $_POST['cod_tipo'];
            else
                $cod_tipo=NULL;
            
            if (isset($_POST['cod_uni_doc']) && !empty($_POST['cod_uni_doc']))
                $cod_uni_doc = $_POST['cod_uni_doc'];
            else
                $cod_uni_doc = NULL;
            
            if (isset($_POST['nom_documento']) && !empty($_POST['nom_documento']))
                $nom_documento = $_POST['nom_documento'];
            else
                $nom_documento=NULL;
            
            if (isset($_POST['dat_ano']) && !empty($_POST['dat_ano']))
                $dat_ano = $_POST['dat_ano'];
            else
                $dat_ano=NULL;
            
            $dat_documento = converte_data($_POST['dat_documento']);
            
            if (isset($_POST['lnk_documento']) && !empty($_POST['lnk_documento']))
                $lnk_documento = $_POST['lnk_documento'];
            else
                $lnk_documento=NULL;
            
            if (isset($_POST['cod_status']) && !empty($_POST['cod_status']))
                $cod_status = $_POST['cod_status'];
            else
                $cod_status=NULL;
            
            if (isset($_POST['txt_assunto']) && !empty($_POST['txt_assunto']))
                $txt_assunto = $_POST['txt_assunto'];
            else
                $txt_assunto=NULL;
            
            if(!empty($_POST['cod_atendimento']) && isset($_POST['check_atendimento']))
                $cod_atendimento = $_POST['cod_atendimento'];
            else
                $cod_atendimento = NULL;
            
            if(!empty($_POST['dat_resposta']) && isset($_POST['check_resposta']))
                $dat_resposta = converte_data($_POST['dat_resposta']);
            else
                $dat_resposta = NULL;
            
            if (isset($_POST['txt_resposta'])&& !empty($_POST['txt_resposta']) && isset($_POST['check_resposta']))
                $txt_resposta = $_POST['txt_resposta'];
            else
                $txt_resposta = NULL;
             
            if (isset($_POST['lnk_resposta']) && !empty($_POST['lnk_resposta']) && isset($_POST['check_resposta']))  
                $lnk_resposta = $_POST['lnk_resposta'];
            else
                $lnk_resposta=NULL;
            
            $insert = $mysqli->prepare("INSERT INTO gab_documento (nom_documento, dat_ano, dat_documento, lnk_documento, txt_assunto, GAB_TIPO_DOCUMENTO_cod_tip_doc, GAB_UNIDADE_DOCUMENTO_cod_uni_doc, "
                    . "GAB_STATUS_DOCUMENTO_cod_status, GAB_ATENDIMENTO_cod_atendimento, dat_resposta, txt_resposta, lnk_resposta, ind_status, dat_log, nom_usuario_log, nom_operacao_log) "
                    . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), '$username', 'INSERT')");
            $insert->bind_param('sssssiiiissss', $nom_documento, $dat_ano, $dat_documento, $lnk_documento, $txt_assunto, $cod_tipo , $cod_uni_doc, $cod_status, $cod_atendimento, $dat_resposta, $txt_resposta, $lnk_resposta, $ind_status);
            
            if ($insert->execute()) 
            {   
                if(isset($_FILES['documento']) && ($_FILES['documento']['size'])>0){
                    // Pasta onde o arquivo vai ser salvo
                    $_UP['pasta'] = 'documentos/';

                    // Tamanho máximo do arquivo (em Bytes)
                    $_UP['tamanho'] = 1024 * 1024 * 25;

                    // Array com as extensões permitidas
                    $_UP['extensoes'] = array('pdf', 'doc', 'odt', 'docx');

                    // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
                    $_UP['renomeia'] = true;

                    // Array com os tipos de erros de upload do PHP
                    $_UP['erros'][0] = 'Não houve erro';
                    $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
                    $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
                    $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
                    $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

                    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
                    if ($_FILES['documento']['error'] != 0) {
                        header('Location: form_cad_documento.php?err= '. $_UP['erros'][$_FILES['documento']['error']]);
                        die();
                    }

                    // Faz a verificação da extensão do arquivo
                    $extensao = strtolower(end(explode('.', $_FILES['documento']['name'])));
                    if (array_search($extensao, $_UP['extensoes']) === true) {
                        header('Location: form_cad_documento.php?err=Extensão de arquivo não permitida! (Extensões permitidas: pdf, doc, odt, docx)');
                        die();
                    }

                    if ($_UP['tamanho'] < $_FILES['documento']['size']) {
                        header('Location: form_cad_documento.php?err=O arquivo enviado é muito grande, envie arquivos de até 25 MB.');
                        die();
                    }

                    $pega_extensao =  strtolower(end(explode(".", $_FILES["documento"]["name"])));
                    $nome_final = $mysqli->insert_id.".".$pega_extensao;

                    // ***********************************Depois verifica se é possível mover o arquivo para a pasta escolhida **********************
                    if (!move_uploaded_file($_FILES['documento']['tmp_name'], $_UP['pasta'].$nome_final)) 
                    {
                        header('Location: form_cad_documento.php?err=Erro no upload do arquivo!');
                        die();
                    }
                }
                
                if(isset($_FILES['documento_resposta']) && ($_FILES['documento_resposta']['size'])>0 && isset($_POST['check_resposta']))
                {
                        // Pasta onde o arquivo vai ser salvo
                        $_UP['pasta'] = 'respostas/';

                        // Tamanho máximo do arquivo (em Bytes)
                        $_UP['tamanho'] = 1024 * 1024 * 25;

                        // Array com as extensões permitidas
                        $_UP['extensoes'] = array('pdf', 'doc', 'odt', 'docx');

                        // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
                        $_UP['renomeia'] = true;

                        // Array com os tipos de erros de upload do PHP
                        $_UP['erros'][0] = 'Não houve erro';
                        $_UP['erros'][1] = 'O arquivo de resposta no upload é maior do que o limite do PHP';
                        $_UP['erros'][2] = 'O arquivo de resposta ultrapassa o limite de tamanho especifiado no HTML';
                        $_UP['erros'][3] = 'O upload do arquivo de resposta foi feito parcialmente';
                        $_UP['erros'][4] = 'Não foi feito o upload do arquivo de resposta';

                        // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
                        if ($_FILES['documento_resposta']['error'] != 0) {
                            header('Location: form_cad_documento.php?err= '. $_UP['erros'][$_FILES['documento_resposta']['error']]);
                            die();
                        }

                        // Faz a verificação da extensão do documento_resposta
                        $extensao = strtolower(end(explode('.', $_FILES['documento_resposta']['name'])));
                        if (array_search($extensao, $_UP['extensoes']) === true) {
                            header('Location: form_cad_documento.php?err=Extensão do arquivo de resposta não permitida! (Extensões permitidas: pdf, doc, odt, docx)');
                            die();
                        }

                        if ($_UP['tamanho'] < $_FILES['documento_resposta']['size']) {
                            header('Location: form_cad_documento.php?err=O arquivo de resposta é muito grande, envie arquivos de até 25 MB.');
                            die();
                        }

                        $pega_extensao =  strtolower(end(explode(".", $_FILES["documento_resposta"]["name"])));
                        $nome_final = $mysqli->insert_id.".".$pega_extensao;
                        
                        if (!move_uploaded_file($_FILES['documento_resposta']['tmp_name'], $_UP['pasta'].$nome_final)) 
                        {
                            header('Location: form_cad_documento.php?err=Erro no upload do arquivo de resposta!');
                            die();
                        }
                }
                
                header('Location: form_cad_documento.php?msg=Documento cadastrado com sucesso!');
                die();
                
            }
            else{
                header('Location: form_cad_documento.php?err=Registration failure: INSERT');
                die();
            }
        }
    }
    else if (!empty ($_GET) && isset($_GET['del']) && isset($_GET['cod_documento'])){
        
        $cod_documento= $_GET['cod_documento'];
        $results  = $mysqli->prepare("UPDATE gab_documento SET ind_status='I', dat_log=NOW(), nom_usuario_log='$username', nom_operacao_log='UPDATE (EXCLUSÃO)' WHERE cod_documento=?");
        $results->bind_param('i', $cod_documento);
        
        if ($results->execute()) {
            $dir = "documentos/";
            if(($dh = opendir($dir)) != FALSE){
                while (false !== ($filename = readdir($dh))) {
                    //echo $filename;
                    $pos = strripos($filename,".");
                    //echo 'pos:'.$pos;
                    $aux_doc = substr($filename,0,$pos);
                    //echo 'aux_doc:'.$aux_doc."-";

                    if ($aux_doc == $cod_documento) {
                        $extensao=explode(".",$filename)[1];
                        $nom_doc = $cod_documento.".".$extensao;
                        unlink("documentos/".$nom_doc);
                    }
                }
            }
            $dir = "respostas/";
            if(($dh = opendir($dir)) != FALSE){
                while (false !== ($filename = readdir($dh))) {
                    //echo $filename;
                    $pos = strripos($filename,".");
                    //echo 'pos:'.$pos;
                    $aux_doc = substr($filename,0,$pos);
                    //echo 'aux_doc:'.$aux_doc."-";

                    if ($aux_doc == $cod_documento) {
                        $extensao=explode(".",$filename)[1];
                        $nom_doc = $cod_documento.".".$extensao;
                        unlink("respostas/".$nom_doc);
                    }
                }
            }
            
            
            
            header('Location: form_cad_documento.php?msg=Documento excluído com sucesso!');
            die();
        }
        else{
            header('Location: form_cad_documento.php?err=Registration failure: DELETE');
            die();
        }
    }
?>