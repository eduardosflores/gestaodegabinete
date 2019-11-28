<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start();
    
    $username=$_SESSION['username'];
    $ind_status = "A";
    
    if(!empty($_POST)){
        if(isset($_POST['alt'])){
            
            $cod_atendimento = $_POST['cod_atendimento'];
            
            $cod_pessoa = $_POST['cod_pessoa'];
            
            $dat_atendimento = converte_data($_POST['dat_atendimento']);
            
            if (isset($_POST['cod_tipo']) && !empty($_POST['cod_tipo']))
                $cod_tipo = $_POST['cod_tipo'];
            else
                $cod_tipo = NULL;
            
            if (isset($_POST['cod_status']) && !empty($_POST['cod_status']))
                $cod_status = $_POST['cod_status'];
            else
                $cod_status=NULL;
            
            if (isset($_POST['txt_detalhes']) && !empty($_POST['txt_detalhes']))
                $txt_detalhes = $_POST['txt_detalhes'];
            else
                $txt_detalhes=NULL;
            
            
            if (!empty($cod_atendimento)){
                $insert = $mysqli->prepare("UPDATE gab_atendimento SET dat_atendimento=?, txt_detalhes=?, GAB_PESSOA_cod_pessoa=?, GAB_TIPO_ATENDIMENTO_cod_tipo=?, GAB_STATUS_ATENDIMENTO_cod_status=?, dat_log=NOW(), nom_usuario_log='$username', nom_operacao_log='UPDATE' WHERE cod_atendimento=?");
                $insert->bind_param('ssiiii', $dat_atendimento, $txt_detalhes, $cod_pessoa, $cod_tipo,$cod_status ,$cod_atendimento);
                if ($insert->execute()) {
                    header('Location: form_cad_atendimento.php?msg=Atendimento alterado com sucesso!');
                    die();
                }
                else{
                     header('Location: includes/error.php?err=Registration failure: INSERT');
                     die();
                }
            }
        }
        else if(isset($_POST['cod_tipo']) && isset($_POST['cod_pessoa']) && !isset($_POST['alt'])){
            
            $cod_pessoa = $_POST['cod_pessoa'];
            
            $dat_atendimento = converte_data($_POST['dat_atendimento']);
            
            if (isset($_POST['cod_tipo']) && !empty($_POST['cod_tipo']))
                $cod_tipo = $_POST['cod_tipo'];
            else
                $cod_tipo = NULL;
            
            if (isset($_POST['cod_status']) && !empty($_POST['cod_status']))
                $cod_status = $_POST['cod_status'];
            else
                $cod_status=NULL;
            
            if (isset($_POST['txt_detalhes']) && !empty($_POST['txt_detalhes']))
                $txt_detalhes = $_POST['txt_detalhes'];
            else
                $txt_detalhes=NULL;
            
            $insert = $mysqli->prepare("INSERT INTO gab_atendimento (dat_atendimento, txt_detalhes, GAB_PESSOA_cod_pessoa, GAB_TIPO_ATENDIMENTO_cod_tipo, GAB_STATUS_ATENDIMENTO_cod_status, ind_status, dat_log, nom_usuario_log, nom_operacao_log) VALUES (?, ?, ?, ?, ?, ?, NOW(), '$username', 'INSERT')");
            $insert->bind_param('ssiiis', $dat_atendimento, $txt_detalhes, $cod_pessoa, $cod_tipo, $cod_status, $ind_status);
            if ($insert->execute()) {
                header('Location: form_cad_atendimento.php?msg=Atendimento cadastrado com sucesso!');
                die();
            }
            else{
                header('Location: form_cad_atendimento.php?err=Registration failure: INSERT');
                die();

            }
        }
    }
    else if (!empty ($_GET) && isset($_GET['del']) && isset($_GET['cod_atendimento'])){
        
        $cod_atendimento= $_GET['cod_atendimento'];
        
        $resultado_del=$mysqli->query("SELECT cod_documento FROM gab_documento where ind_status='A' and GAB_ATENDIMENTO_cod_atendimento =$cod_atendimento");
        if($resultado_del->num_rows>0)
        {
            header('Location: form_cad_atendimento.php?err=Atendimento vinculado a um Documento!');
            die();
        }        
        
        $results  = $mysqli->prepare("UPDATE gab_atendimento SET ind_status='I', dat_log=NOW(), nom_usuario_log='$username', nom_operacao_log='UPDATE (EXCLUSÃO)' WHERE cod_atendimento=?");
        $results->bind_param('i', $cod_atendimento);
        
        if ($results->execute()) {
           header('Location: form_cad_atendimento.php?msg=Atendimento excluído com sucesso!');
           die();
        }
        else{
            header('Location: form_cad_atendimento.php?err=Registration failure: DELETE');
            die();
        }
    }
    else if (!empty ($_GET) && isset($_GET['mod']) && isset($_GET['cod_atendimento'])){
        
       $cod_atendimento=$_GET['cod_atendimento'];
        
       if ($resultado=$mysqli->query("SELECT gab_atendimento.cod_atendimento, gab_atendimento.dat_atendimento, gab_atendimento.txt_detalhes detalhes,"
                            . "gab_pessoa.nom_nome, gab_pessoa.ind_pessoa, gab_pessoa.cod_cpf_cnpj, gab_pessoa.cod_ie, gab_pessoa.cod_rg,"
                            . "gab_tipo_atendimento.nom_tipo, "
                            . "gab_status_atendimento.nom_status nom_status "
                            . "FROM gab_atendimento "
                            . "LEFT JOIN gab_tipo_atendimento ON gab_tipo_atendimento.cod_tipo = gab_atendimento.GAB_TIPO_ATENDIMENTO_cod_tipo "
                            . "LEFT JOIN gab_pessoa ON gab_pessoa.cod_pessoa = gab_atendimento.GAB_PESSOA_cod_pessoa "
                            . "LEFT JOIN gab_status_atendimento ON gab_status_atendimento.cod_status = gab_atendimento.GAB_STATUS_ATENDIMENTO_cod_status "
                            . "WHERE cod_atendimento=$cod_atendimento")){
                            if ($resultado->num_rows){
                                $linha=$resultado->fetch_object();
                                
                                $doc="";
                                if ($linha->ind_pessoa == "PF" && !empty($linha->cod_cpf_cnpj)){ $doc.=" CPF:".$linha->cod_cpf_cnpj; }
                                if($linha->ind_pessoa == "PF" && !empty($linha->cod_rg)){ $doc.=" RG:".$linha->cod_rg; }
                                if ($linha->ind_pessoa == "PJ" && !empty($linha->cod_cpf_cnpj)){ $doc.=" CNPJ:".$linha->cod_cpf_cnpj; }
                                if ($linha->ind_pessoa == "PJ" && !empty($linha->cod_ie)){ $doc.=" IE:".$linha->cod_ie; }
                                
                                $dat_atendimento=converteDataBR($linha->dat_atendimento);
                                
                                $nom_nome=$linha->nom_nome;
                                $nom_tipo=$linha->nom_tipo;
                                $nom_status=$linha->nom_status;
                                
                                ?>

                                <script type="text/javascript">

                                    window.opener.document.getElementById('cod_atendimento').value="<?php echo $cod_atendimento;?>";
                                    
                                    window.opener.document.getElementById("dadosAtendimento").innerHTML = "<b>Data:</b>"+ '<?php echo $dat_atendimento;?>' +"<br>"+
                                                                                                          "<b>Pessoa:</b>"+'<?php echo $nom_nome;?>'+"<br>"+
                                                                                                          "<b>Doc. Identificação:</b>"+'<?php echo $doc;?>'+"<br>"+
                                                                                                          "<b>Tipo:</b>"+'<?php echo $nom_tipo;?>'+"<br>"+
                                                                                                          "<b>Situação:</b>"+'<?php echo $nom_status;?>';
                                    window.close();
                                </script>       

                                <?php
                            }
                            else
                            {?>
                                <script type="text/javascript">
                                    window.opener.document.getElementById('cod_atendimento').value="";
                                    window.opener.document.getElementById("dadosAtendimento").innerHTML = ""; 
                                    alert('O Atendimento selecionado não retornou com sucesso.');
                                    window.close();
                                </script>       
                            <?php
                            }
        }
        else{?>
            <script type="text/javascript">
                window.opener.document.getElementById('cod_atendimento').value="";
                window.opener.document.getElementById("dadosAtendimento").innerHTML = ""; 
                alert('O Atendimento selecionado não retornou com sucesso.');
                window.close();
            </script>       
        <?php
        }
    } 
?>