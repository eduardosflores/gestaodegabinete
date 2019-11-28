<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    
    session_start();
?>
<html>
    <head>
        <?php include 'includes/head.html'; ?>
        <link rel="stylesheet" href="css/jquery-ui-1.12.0.css">
        <script src="js/jquery-1.12.4.js"></script>
        <script src="js/jquery-ui-1.12.0.js"></script>
        <script src="js/jquery.maskedinput.js"></script>
        <script src="js/functions.js"></script>
        <!--bibliotecas para select pesquisavel -->
        <link href="css/select2.min.css" rel="stylesheet" />
        <script src="js/select2.min.js"></script>
        
        <script type="text/javascript">
        
            function MostraAtendimento(){
                if(document.form.check_atendimento.checked == true){
                    document.getElementById( 'div_atendimento' ).style.display = '';
                    document.getElementById('cod_atendimento').value='';
                    document.getElementById('dadosAtendimento').innerHTML='';
                    document.getElementById('dadosAtendimento').style.display='';
                }
                else{
                    document.getElementById( 'div_atendimento' ).style.display = 'none';
                    document.getElementById('cod_atendimento').value='';
                    document.getElementById('dadosAtendimento').innerHTML='';
                    document.getElementById('dadosAtendimento').style.display='none';
                }
            }
            
          
            function MostraAtendimento_pesq(id){
                    var div_atend = 'div_atendimento_pesq_'+id;
                    document.getElementById(div_atend).style.display = '';
                    
                    var sub_div_atend = 'sub_detalhes_atendimento_'+id;
                    document.getElementById(sub_div_atend).style.display = '';
                    
                    var add_div_atend = 'add_detalhes_atendimento_'+id;
                    document.getElementById(add_div_atend).style.display = 'none';
            }
            
            function OcultarAtendimento_pesq(id){
                    var div_atend = 'div_atendimento_pesq_'+id;
                    document.getElementById(div_atend).style.display = 'none';
                    
                    var sub_div_atend = 'sub_detalhes_atendimento_'+id;
                    document.getElementById(sub_div_atend).style.display = 'none';
                    
                    var add_div_atend = 'add_detalhes_atendimento_'+id;
                    document.getElementById(add_div_atend).style.display = '';
            }
            
            function MostraResposta(){
                if(document.form.check_resposta.checked == true){
                    document.getElementById( 'div_data' ).style.display = '';
                }
                else{
                    document.getElementById( 'div_data' ).style.display = 'none';
                }
            }
            

            function MostraResposta_pesq(id){
                    var div_resp = 'div_resposta_pesq_'+id;
                    document.getElementById(div_resp).style.display = '';
                    
                    var sub_div_resp = 'sub_detalhes_resposta_'+id;
                    document.getElementById(sub_div_resp).style.display = '';
                    
                    var add_div_resp = 'add_detalhes_resposta_'+id;
                    document.getElementById(add_div_resp).style.display = 'none';
            }
            
            
            function OcultarResposta_pesq(id){
                    var div_resp = 'div_resposta_pesq_'+id;
                    document.getElementById(div_resp).style.display = 'none';
                    
                    var sub_div_resp = 'sub_detalhes_resposta_'+id;
                    document.getElementById(sub_div_resp).style.display = 'none';
                    
                    var add_div_resp = 'add_detalhes_resposta_'+id;
                    document.getElementById(add_div_resp).style.display = '';
            }
            
          
            function SomenteNumero(e){
                var tecla=(window.event)?event.keyCode:e.which;
                if((tecla>47 && tecla<58)) return true;
                else{
                    if (tecla==8 || tecla==0) return true;
                    else  return false;
                }
            }
            
            
            function checarCampos(){
                if(document.form.check_atendimento.checked == true && document.form.cod_atendimento.value==""){
                    alert('Selecione o Atendimento.');
                    return false;
                }
                else if ( document.form.check_resposta.checked == true && document.form.dat_resposta.value==""){
                    alert('Preencha a Data da Resposta.');
                    return false;
                }
                else{     
                    return true;
                }
            }

            function pesquisar() 
            {
                document.form.action = "form_pesquisar_documento.php?#pes";
                document.form.submit();
            }

            $(document).ready(function() {
                 $(".meuselect").select2();
            });
        </script>
        
    </head>
    <body>
        <?php if (login_check($mysqli) == true) 
            {
                include 'includes/cabecalho.php';
               
        ?>
            <div class="container" id="main">
                <?php if (isset($_GET['msg'])){
                    echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['msg'].'</strong></div>';                     
                }else if (isset($_GET['err'])){
                    echo '<div class="alert alert-warning fade in "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['err'].'</strong></div>';
                }
                ?>
                <h1 class="h2">Relatório: Documentos</h1>

                <form  name="form" class="form-horizontal" type="post"  autocomplete="off"  onsubmit="return checarCampos()">
                    
                    <?php 
                      
                    ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tipo de Documento:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT cod_tip_doc, nom_tip_doc, ind_tip_doc FROM gab_tipo_documento WHERE ind_tip_doc ='A' order by nom_tip_doc")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-8">
                                   <select class="meuselect" name="cod_tip_doc">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['cod_tip_doc'];?>"
                                       <?php if (isset($_GET['cod_tip_doc'])){
                                            if ($_GET['cod_tip_doc']==$linha_set_gab['cod_tip_doc']){echo "selected";}}?>>  
                                               <?php echo $linha_set_gab['nom_tip_doc'];?>
                                       </option> 
                                       <?php
                                       }?>
                                   </select>
                                </div><?php 
                                $cond = false;
                            }
                            else
                            {?>                          
                                <div class="col-md-4">
                                    <select class="form-control" name="cod_tip_doc" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Tipo de Documento cadastrado"
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-4">
                                   <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe Tipo de Documento cadastrado.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" autocomplete="on">Número:</label>  
                        <div class="col-md-3">
                            <input name="nom_documento" type="text" placeholder="" class="form-control input-md"
                                   value="<?php if (isset($_GET['nom_documento'])) {echo $_GET['nom_documento'];}?>">
                        </div>
                        <label class="col-md-2 control-label" autocomplete="on">Ano:</label>  
                        <div class="col-md-3">
                            <input name="dat_ano" type="text" placeholder="" class="form-control input-md" maxlength="4" minlength="4" onkeypress='return SomenteNumero(event)'
                                   value="<?php if (isset($_GET['dat_ano'])) {echo $_GET['dat_ano'];}?>">
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-2 control-label" for="dataInicio">Data inicial:</label>  
                        <div class="col-md-3">
                            <input name="dataInicio"  type="text" class="form-control input-md datepicker" onblur="validaData(this)" value="<?php if (isset($_GET['dataInicio'])){if(strpos($_GET['dataInicio'], '/') === false) echo converteDataBR($_GET['dataInicio']);else echo $_GET['dataInicio'];}  ?>">
                        </div>
                        <label class="col-md-2 control-label" for="dataFim">Data final:</label>  
                        <div class="col-md-3">
                            <input  name="dataFim" type="text" class="form-control input-md datepicker" onblur="validaData(this)" value="<?php if (isset($_GET['dataFim'])){if(strpos($_GET['dataFim'], '/') === false) echo converteDataBR($_GET['dataFim']);else echo $_GET['dataFim'];} ?>">
                        </div>
                    </div>

                        <div class="form-group">
                        <label class="col-md-2 control-label">Situação:</label>
                        <!-- <div class="col-md-8"> -->
                        <?php
                        if ($resultado=$mysqli->query("SELECT cod_status, nom_status, ind_status FROM gab_status_documento WHERE ind_status ='A' order by nom_status")){
                            if ($resultado->num_rows){?>

                              <div class="col-md-8">
                                   <select class="meuselect" name="cod_status">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['cod_status'];?>"
                                       <?php if (isset($_GET['cod_status'])){
                                            if ($_GET['cod_status']==$linha_set_gab['cod_status']){echo "selected";}}?>> 
                                               <?php echo $linha_set_gab['nom_status'];?>
                                       </option> 
                                       <?php
                                       }?>
                                   </select>
                               <!-- </div>--><?php 
                                $cond = false;
                            }
                            else
                            {?>                          
                                <div class="col-md-4">
                                    <select class="form-control" name="cod_status" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Situação de Documento cadastrada"
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-4">
                                    <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe Situação de Documento cadastrada.</span>
                                <!--</div>--><?php 
                                $cond = true;
                            }
                        }
                        ?>
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unidade Administrativa:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT cod_uni_doc, nom_uni_doc, ind_uni_doc FROM gab_unidade_documento WHERE ind_uni_doc ='A' order by nom_uni_doc")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-8">
                                   <select class="meuselect" name="cod_uni_doc">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['cod_uni_doc'];?>"
                                           <?php if (isset($_GET['cod_uni_doc'])){
                                            if ($_GET['cod_uni_doc']==$linha_set_gab['cod_uni_doc']){echo "selected";}}?>> 
                                               <?php echo $linha_set_gab['nom_uni_doc'];?>
                                       </option> 
                                       <?php
                                       }?>
                                   </select>
                                </div><?php 
                                $cond = false;
                            }
                            else
                            {?>                          
                                <div class="col-md-4">
                                    <select class="form-control" name="cod_uni_doc" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Unidade Administrativa cadastrada"
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-4">
                                    <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe Unidade Administrativa cadastrada.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }
                        ?>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox" id="atendimento">
                            <label class="col-md-2"></label>
                            <label>
                                <input name="check_atendimento" type="checkbox" onclick="MostraAtendimento()">Possui Atendimento relacionado
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group" style="display: none;" id="div_atendimento">   
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-5">
                            <?php 
                            if(isset($_GET['cod_atendimento'])){
                                $cod_atendimento=$_GET['cod_atendimento'];
                                $dados=0;
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
                                        $dados=1;
                                        $linha_atend=$resultado->fetch_object();
                                        
                                        $doc="";
                                        if ($linha_atend->ind_pessoa == "PF" && !empty($linha_atend->cod_cpf_cnpj)){ $doc.=" CPF:".$linha_atend->cod_cpf_cnpj; }
                                        if ($linha_atend->ind_pessoa == "PF" && !empty($linha_atend->cod_rg)){ $doc.=" RG:".$linha_atend->cod_rg; }
                                        if ($linha_atend->ind_pessoa == "PJ" && !empty($linha_atend->cod_cpf_cnpj)){ $doc.=" CNPJ:".$linha_atend->cod_cpf_cnpj; }
                                        if ($linha_atend->ind_pessoa == "PJ" && !empty($linha_atend->cod_ie)){ $doc.=" IE:".$linha_atend->cod_ie; }

                                        $dat_atendimento=converteDataBR($linha_atend->dat_atendimento);

                                        $nom_nome=$linha_atend->nom_nome;
                                        $nom_tipo=$linha_atend->nom_tipo;
                                        $nom_status=$linha_atend->nom_status;
                                        
                                    }
                                }
                            } else{
                                $cod_atendimento="";
                            }
                            ?>
                            
                            <div id="dadosAtendimento">
                                <?php 
                                if(isset($_GET['cod_atendimento']) && $dados==1){
                                    echo "<p><b>Data:</b>".$dat_atendimento ."</p>".
                                         "<p><b>Pessoa:</b>".$nom_nome."</p>".
                                         "<p><b>Doc. Identificação:</b>".$doc."</p>".
                                         "<p><b>Tipo:</b>".$nom_tipo."</p>".
                                         "<p><b>Situação:</b>".$nom_status."</p>";
                                } ?>

                            </div>
                            
                            <button type="button" class="btn btn-primary" onclick="modal('form_cad_atendimento.php?mod=1','modal',1000,500)">Pesquisar Atendimento</button>
                            
                            <input type="hidden" name="cod_atendimento" id="cod_atendimento">
                           
                        </div>    
                    </div>
                 
                    
                    <div class="form-group" id='resposta'>
                        <div class="checkbox" >
                            <label class="col-md-2"></label>
                            <label>
                                <input id="checkbox_resposta" type="checkbox" name="check_resposta" onclick="MostraResposta()">Possui Resposta
                            </label>
                        </div>
                    </div>
                    
                  
                        <div class="form-group" id="div_data" style="display: none;">
                            <label class="col-md-2 control-label" autocomplete="on">Data:</label>  
                            <div class="col-md-3">
                                <input name="dat_resposta" id="dat_resposta" type="text" class="form-control input-md datepicker" onblur="validaData(this)">
                            </div>
                        </div>
                      
                    
                    <input type="hidden" name="all" value="1">
                    <input type="hidden" name="pesquisa" value="1">
                    <div class="form-group">
                        <div class="col-md-4 text-right">
                            <input type="button" id="pes" class="btn btn-default" value="Pesquisar" onclick="pesquisar();">
                            
                            <input type="button" class="btn btn-default" value="Limpar" onclick="window.location='form_pesquisar_documento.php';">
                        </div>
                    </div>
                </form>
                <?php
                
                
                if(isset($_GET['pesquisa'])){
                    $limite=1000;
                    $itens_por_pag = 50;
                    if(isset($_GET['pagina'])){$pagina = intval($_GET['pagina']);}else {$pagina=1;}
                    $aux=$pagina*50-50;
                    if($aux>$limite){
                        $aux=$limite;
                    }
                    
                    $records=array();
                    
                       
                        $sql="SELECT gab_documento.cod_documento, gab_documento.nom_documento, gab_documento.dat_ano, gab_documento.dat_documento, gab_documento.lnk_documento, "
                        . "gab_documento.txt_assunto, gab_tipo_documento.nom_tip_doc, gab_status_documento.nom_status, gab_unidade_documento.nom_uni_doc, "
                        . "gab_atendimento.cod_atendimento, gab_documento.dat_resposta, gab_documento.txt_resposta  "
                        . "FROM gab_documento "
                        . "LEFT JOIN gab_atendimento ON gab_atendimento.cod_atendimento = gab_documento.GAB_ATENDIMENTO_cod_atendimento "
                        . "LEFT JOIN gab_tipo_documento ON gab_tipo_documento.cod_tip_doc = gab_documento.GAB_TIPO_DOCUMENTO_cod_tip_doc "
                        . "LEFT JOIN gab_status_documento ON gab_status_documento.cod_status = gab_documento.GAB_STATUS_DOCUMENTO_cod_status "
                        . "LEFT JOIN gab_unidade_documento ON gab_unidade_documento.cod_uni_doc = gab_documento.GAB_UNIDADE_DOCUMENTO_cod_uni_doc "
                        . "WHERE gab_documento.ind_status='A' ";
                        
                        //tipo documento
                        if (isset($_GET['cod_tip_doc']) && !empty($_GET['cod_tip_doc'])){
                            $cod_tip_doc=$_GET['cod_tip_doc'];
                            $sql.="AND gab_tipo_documento.cod_tip_doc=$cod_tip_doc ";
                        }else
                        if (isset($_POST['cod_tip_doc']) && !empty($_POST['cod_tip_doc'])){
                            $cod_tip_doc=$_POST['cod_tip_doc'];
                            $sql.="AND gab_tipo_documento.cod_tip_doc=$cod_tip_doc ";
                        }else{$cod_tip_doc="";}
                        
                        //numero
                        if (isset($_GET['nom_documento']) && !empty($_GET['nom_documento'])){
                            $nom_documento=$_GET['nom_documento'];
                            $sql.=" and gab_documento.nom_documento='$nom_documento' ";
                        }else
                        if (isset($_POST['nom_documento']) && !empty($_POST['nom_documento'])){
                            $nom_documento=$_POST['nom_documento'];
                            $sql.=" and gab_documento.nom_documento='$nom_documento' ";
                        }else{$nom_documento="";}

                        //ano
                        if (isset($_GET['dat_ano']) && !empty($_GET['dat_ano'])){
                            $dat_ano=$_GET['dat_ano'];
                            $sql.=" and gab_documento.dat_ano='$dat_ano' ";
                        }else
                        if (isset($_POST['dat_ano']) && !empty($_POST['dat_ano'])){
                            $dat_ano=$_POST['dat_ano'];
                            $sql.=" and gab_documento.dat_ano='$dat_ano' ";
                        }else{$dat_ano="";}

                         //pesquisa por data
                         if (isset($_GET['dataInicio']) && !empty($_GET['dataInicio'])){
                            $dataInicio=converte_data($_GET['dataInicio']);
                            $sql.="AND gab_documento.dat_documento >='$dataInicio' ";
                            $dataInicio=$_GET['dataInicio'];
                        }else
                        if (isset($_POST['dataInicio']) && !empty($_POST['dataInicio'])){
                            $dataInicio=converte_data($_POST['dataInicio']);
                            $sql.="AND gab_documento.dat_documento >='$dataInicio' ";
                            $dataInicio=$_POST['dataInicio'];
                        }
                        else{$dataInicio="";}

                        if (isset($_GET['dataFim']) && !empty($_GET['dataFim'])){
                            $dataFim=converte_data($_GET['dataFim']); 
                            $sql.="AND gab_documento.dat_documento <='$dataFim' ";
                            $dataFim=$_GET['dataFim'];
                        }else
                        if (isset($_POST['dataFim']) && !empty($_POST['dataFim'])){
                            $dataFim=converte_data($_POST['dataFim']);
                            $sql.="AND gab_documento.dat_documento <='$dataFim' ";
                            $dataFim=$_POST['dataFim'];
                        }
                        else{$dataFim="";}

                        //situação
                        if (isset($_GET['cod_status']) && !empty($_GET['cod_status'])){
                            $cod_status=$_GET['cod_status'];
                            $sql.="AND gab_status_documento.cod_status=$cod_status ";
                        }else
                        if (isset($_POST['cod_status']) && !empty($_POST['cod_status'])){
                            $cod_status=$_POST['cod_status'];
                            $sql.="AND gab_status_documento.cod_status=$cod_status ";
                        }else{$cod_status="";}
                        
                        //unidade administrativa
                        if (isset($_GET['cod_uni_doc']) && !empty($_GET['cod_uni_doc'])){
                            $cod_uni_doc=$_GET['cod_uni_doc'];
                            $sql.="AND gab_unidade_documento.cod_uni_doc=$cod_uni_doc ";
                        }else
                        if (isset($_POST['cod_uni_doc']) && !empty($_POST['cod_uni_doc'])){
                            $cod_uni_doc=$_POST['cod_uni_doc'];
                            $sql.="AND gab_unidade_documento.cod_uni_doc=$cod_uni_doc ";
                        }else{$cod_uni_doc="";}

                        //atendimento relacionado
                        if (isset($_GET['cod_atendimento']) && !empty($_GET['cod_atendimento'])){
                            $cod_atendimento=$_GET['cod_atendimento'];
                            $sql.="AND gab_atendimento.cod_atendimento=$cod_atendimento ";
                        }else
                        if (isset($_POST['cod_atendimento']) && !empty($_POST['cod_atendimento'])){
                            $cod_atendimento=$_POST['cod_atendimento'];
                            $sql.="AND gab_atendimento.cod_atendimento=$cod_atendimento ";
                        }else{$cod_atendimento="";}

                        //resposta
                        if (isset($_GET['dat_resposta']) && !empty($_GET['dat_resposta'])){
                            $dat_resposta=converte_data($_GET['dat_resposta']);
                            $sql.="AND gab_documento.dat_resposta='$dat_resposta' ";
                           // $dat_resposta=$_GET['dat_resposta'];
                        }else
                        if (isset($_POST['dat_resposta']) && !empty($_POST['dat_resposta'])){
                            $dat_resposta=converte_data($_POST['dat_resposta']);
                            $sql.="AND gab_documento.dat_resposta='$dat_resposta' ";
                          //  $dat_resposta=$_POST['dat_resposta'];
                        }else{$dat_resposta="";}

                        if (isset($_GET['all'])){
                            $all=1;
                        }else{
                            $all="";
                        }
                        
                        

                        $_SESSION['sql']=$sql."ORDER BY gab_documento.dat_documento DESC, gab_tipo_documento.nom_tip_doc, gab_status_documento.nom_status, gab_unidade_documento.nom_uni_doc ASC LIMIT $limite";
                        $sql.="ORDER BY gab_documento.dat_documento DESC, gab_tipo_documento.nom_tip_doc, gab_status_documento.nom_status, gab_unidade_documento.nom_uni_doc ASC LIMIT $aux, $itens_por_pag";
                        //echo "sql:".$sql;

                        if ($results = $mysqli->query($sql))
                        {
                            $num=$results->num_rows;

                            $sql="SELECT gab_documento.cod_documento, gab_documento.nom_documento, gab_documento.dat_ano, gab_documento.dat_documento, gab_documento.lnk_documento, "
                            . "gab_documento.txt_assunto, gab_tipo_documento.nom_tip_doc, gab_status_documento.nom_status, gab_unidade_documento.nom_uni_doc, "
                            . "gab_atendimento.cod_atendimento, gab_documento.dat_resposta, gab_documento.txt_resposta  "
                            . "FROM gab_documento "
                            . "LEFT JOIN gab_atendimento ON gab_atendimento.cod_atendimento = gab_documento.GAB_ATENDIMENTO_cod_atendimento "
                            . "LEFT JOIN gab_tipo_documento ON gab_tipo_documento.cod_tip_doc = gab_documento.GAB_TIPO_DOCUMENTO_cod_tip_doc "
                            . "LEFT JOIN gab_status_documento ON gab_status_documento.cod_status = gab_documento.GAB_STATUS_DOCUMENTO_cod_status "
                            . "LEFT JOIN gab_unidade_documento ON gab_unidade_documento.cod_uni_doc = gab_documento.GAB_UNIDADE_DOCUMENTO_cod_uni_doc "
                            . "WHERE gab_documento.ind_status='A' ";
                            
                            //tipo documento
                            if (isset($_GET['cod_tip_doc']) && !empty($_GET['cod_tip_doc'])){
                                $cod_tip_doc=$_GET['cod_tip_doc'];
                                $sql.="AND gab_tipo_documento.cod_tip_doc=$cod_tip_doc ";
                            }else
                            if (isset($_POST['cod_tip_doc']) && !empty($_POST['cod_tip_doc'])){
                                $cod_tip_doc=$_POST['cod_tip_doc'];
                                $sql.="AND gab_tipo_documento.cod_tip_doc=$cod_tip_doc ";
                            }else{$cod_tip_doc="";}
                            
                            //numero
                            if (isset($_GET['nom_documento']) && !empty($_GET['nom_documento'])){
                                $nom_documento=$_GET['nom_documento'];
                                $sql.=" and gab_documento.nom_documento='$nom_documento' ";
                            }else
                            if (isset($_POST['nom_documento']) && !empty($_POST['nom_documento'])){
                                $nom_documento=$_POST['nom_documento'];
                                $sql.=" and gab_documento.nom_documento='$nom_documento' ";
                            }else{$nom_documento="";}
    
                            //ano
                            if (isset($_GET['dat_ano']) && !empty($_GET['dat_ano'])){
                                $dat_ano=$_GET['dat_ano'];
                                $sql.=" and gab_documento.dat_ano='$dat_ano' ";
                            }else
                            if (isset($_POST['dat_ano']) && !empty($_POST['dat_ano'])){
                                $dat_ano=$_POST['dat_ano'];
                                $sql.=" and gab_documento.dat_ano='$dat_ano' ";
                            }else{$dat_ano="";}
    
                             //pesquisa por data
                             if (isset($_GET['dataInicio']) && !empty($_GET['dataInicio'])){
                                $dataInicio=converte_data($_GET['dataInicio']);
                                $sql.="AND gab_documento.dat_documento >='$dataInicio' ";
                                $dataInicio=$_GET['dataInicio'];
                            }else
                            if (isset($_POST['dataInicio']) && !empty($_POST['dataInicio'])){
                                $dataInicio=converte_data($_POST['dataInicio']);
                                $sql.="AND gab_documento.dat_documento >='$dataInicio' ";
                                $dataInicio=$_POST['dataInicio'];
                            }
                            else{$dataInicio="";}
    
                            if (isset($_GET['dataFim']) && !empty($_GET['dataFim'])){
                                $dataFim=converte_data($_GET['dataFim']);
                                $sql.="AND gab_documento.dat_documento <='$dataFim' ";
                                $dataFim=$_GET['dataFim'];
                            }else
                            if (isset($_POST['dataFim']) && !empty($_POST['dataFim'])){
                                $dataFim=converte_data($_POST['dataFim']);
                                $sql.="AND gab_documento.dat_documento <='$dataFim' ";
                                $dataFim=$_POST['dataFim'];
                            }
                            else{$dataFim="";}
    
                            //situação
                            if (isset($_GET['cod_status']) && !empty($_GET['cod_status'])){
                                $cod_status=$_GET['cod_status'];
                                $sql.="AND gab_status_documento.cod_status=$cod_status ";
                            }else
                            if (isset($_POST['cod_status']) && !empty($_POST['cod_status'])){
                                $cod_status=$_POST['cod_status'];
                                $sql.="AND gab_status_documento.cod_status=$cod_status ";
                            }else{$cod_status="";}
                            
                            //unidade administrativa
                            if (isset($_GET['cod_uni_doc']) && !empty($_GET['cod_uni_doc'])){
                                $cod_uni_doc=$_GET['cod_uni_doc'];
                                $sql.="AND gab_unidade_documento.cod_uni_doc=$cod_uni_doc ";
                            }else
                            if (isset($_POST['cod_uni_doc']) && !empty($_POST['cod_uni_doc'])){
                                $cod_uni_doc=$_POST['cod_uni_doc'];
                                $sql.="AND gab_unidade_documento.cod_uni_doc=$cod_uni_doc ";
                            }else{$cod_uni_doc="";}
    
                            //atendimento relacionado
                            if (isset($_GET['cod_atendimento']) && !empty($_GET['cod_atendimento'])){
                                $cod_atendimento=$_GET['cod_atendimento'];
                                $sql.="AND gab_atendimento.cod_atendimento=$cod_atendimento ";
                            }else
                            if (isset($_POST['cod_atendimento']) && !empty($_POST['cod_atendimento'])){
                                $cod_atendimento=$_POST['cod_atendimento'];
                                $sql.="AND gab_atendimento.cod_atendimento=$cod_atendimento ";
                            }else{$cod_atendimento="";}
    
                            //resposta
                            if (isset($_GET['dat_resposta']) && !empty($_GET['dat_resposta'])){
                                $dat_resposta=converte_data($_GET['dat_resposta']);
                                $sql.="AND gab_documento.dat_resposta='$dat_resposta' ";
                            }else
                            if (isset($_POST['dat_resposta']) && !empty($_POST['dat_resposta'])){
                                $dat_resposta=converte_data($_POST['dat_resposta']);
                                $sql.="AND gab_documento.dat_resposta='$dat_resposta' ";
                            }else{$dat_resposta="";}
                            
                            //tudo
                            if (isset($_GET['all'])){
                                $all=1;
                            }else{
                                $all="";
                            }

                            $num_total = $mysqli->query($sql)->num_rows;
                            if ($num_total>$limite){
                                $num_total=$limite;
                            }

                            $num_paginas=  ceil($num_total/$itens_por_pag);

                            if ($results->num_rows){
                                while($row = $results->fetch_object()){
                                    $records[]=$row;
                                }
                                $results->free_result();
                            }
                            if ( count($records) == 0)
                            {
                            echo "Nenhum registro encontrado.";
                            }
                        }
                    
                    
                    if (count($records)){?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li>
                                    <a href="form_pesquisar_documento.php?pagina=1&pesquisa=1&cod_tip_doc=<?php echo $cod_tip_doc;?>&nom_documento=<?php echo $nom_documento;?>&dat_ano=<?php echo $dat_ano;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&cod_status=<?php echo $cod_status;?>&cod_uni_doc=<?php echo $cod_uni_doc;?>&cod_atendimento=<?php echo $cod_atendimento;?>&dat_resposta=<?php echo $dat_resposta;?>&all=<?php echo $all;?>#pes" aria-label="Previous">
                                       <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php 
                                 for($i=1;$i<=$num_paginas;$i++) { 
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;   
                                    ?> 
                                    <li <?php echo $estilo; ?>><a href="form_pesquisar_documento.php?pagina=<?php echo $i; ?>&pesquisa=1&cod_tip_doc=<?php echo $cod_tip_doc;?>&nom_documento=<?php echo $nom_documento;?>&dat_ano=<?php echo $dat_ano;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&cod_status=<?php echo $cod_status;?>&cod_uni_doc=<?php echo $cod_uni_doc;?>&cod_atendimento=<?php echo $cod_atendimento;?>&dat_resposta=<?php echo $dat_resposta;?>&all=<?php echo $all;?>#pes"> <?php echo $i;?> </a></li><?php }

                                    ?>
                                    <li>
                                        <a href="form_pesquisar_documento.php?pagina=<?php echo $num_paginas; ?>&pesquisa=1&cod_tip_doc=<?php echo $cod_tip_doc;?>&nom_documento=<?php echo $nom_documento;?>&dat_ano=<?php echo $dat_ano;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&cod_status=<?php echo $cod_status;?>&cod_uni_doc=<?php echo $cod_uni_doc;?>&cod_atendimento=<?php echo $cod_atendimento;?>&dat_resposta=<?php echo $dat_resposta;?>&all=<?php echo $all;?>#pes" aria-label="Next">
                                             <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>
                        <div class="row">
                            <div><span style="float:left;"><?php echo "Total de registros: ". $num_total." ";?>(a pesquisa retorna até <?php echo $limite; ?> registros)</span></div>
                            <div style="float:right;">
                                <a align="right" href="form_pesquisar_documento_xlsx.php" title="Gerar relatório Excel"><i class="far fa-file-excel fa-3x" title="Gerar relatório Excel"></i></a>
                                <a target="_blank" href="form_pesquisar_documento_pdf.php" title="Gerar relatório PDF"><i class="far fa-file-pdf fa-3x" title="Gerar relatório PDF"></i></a>
                            </div>
                        </div>
                        <div class="table-of row">
                        <table id="example" class="mtab table table-striped table-hover table-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Número/Ano</th>
                                <th>Tipo</th>
                                <th>Situação</th>
                                <th>Unidade</th>
                                <th>Atendimento</th>
                                <th>Resposta</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($records as $r){?>
                                <tr>
                                    <?php $cod_documento=$r->cod_documento;?>
                                    <td  width='5%'><?php echo converteDataBR($r->dat_documento);?></td>
                                    <td  width='10%'><?php echo escape($r->nom_documento)."/".$r->dat_ano; ?></td>
                                    <td  width='15%'><?php echo escape($r->nom_tip_doc); ?></td>
                                    <td  width='15%'><?php echo escape($r->nom_status); ?></td>
                                    <td  width='15%'><?php echo escape($r->nom_uni_doc); ?></td>
                                    
                                    <?php $cod_atendimento=$r->cod_atendimento; 
                                          $nom_div_atend='div_atendimento_pesq_'.$cod_documento;
                                          $add_div_atend='add_detalhes_atendimento_'.$cod_documento;
                                          $sub_div_atend='sub_detalhes_atendimento_'.$cod_documento;
                                          
                                    if( $cod_atendimento != null){
                                    ?>
                                    
                                    
                                    
                                    <td  width='25%'><?php echo "Sim";?>
                                    <a href="#" onclick="MostraAtendimento_pesq(<?php echo $cod_documento;?>);" id="<?php echo $add_div_atend;?>"  style="display:'';"><i class="far fa-plus-square" style="font-size:20px; color:000000; float: right;"></i></a>
                                    <a href="#" onclick="OcultarAtendimento_pesq(<?php echo $cod_documento;?>);" id="<?php echo $sub_div_atend;?>"  style="display:none;"><i class="far fa-minus-square" style="font-size:20px; color:000000; float: right;"></i></a>
                                    
                                    <!--detalhes atendimento-->
                                            <div class="form-group" style="display:none;" id="<?php echo $nom_div_atend;?>" >     
                                                <label class="col-sm-2 control-label"></label>
                                                
                                                    <?php 
                                                    //if( $cod_atendimento != null){
                                                        
                                                        $dados=0;
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
                                                                $dados=1;
                                                                $linha_atend=$resultado->fetch_object();
                                                                
                                                                //Doc. Identificação:
                                                                $doc="";
                                                                if ($linha_atend->ind_pessoa == "PF" && !empty($linha_atend->cod_cpf_cnpj)){ $doc.="CPF:".$linha_atend->cod_cpf_cnpj."<br>";}
                                                                if($linha_atend->ind_pessoa == "PF" && !empty($linha_atend->cod_rg)){
                                                                    $cod_rg= preg_replace('/([A-Za-z0-9]{2})([A-Za-z0-9]{3})([A-Za-z0-9]{3})([A-Za-z0-9]{1})/',"$1.$2.$3-$4",$linha_atend->cod_rg);
                                                                    $doc.="RG:".$cod_rg."<br>"; }
                                                                if ($linha_atend->ind_pessoa == "PJ" && !empty($linha_atend->cod_cpf_cnpj)){ $doc.="CNPJ:".$linha_atend->cod_cpf_cnpj."<br>";}
                                                                if ($linha_atend->ind_pessoa == "PJ" && !empty($linha_atend->cod_ie)){ $doc.="IE:".$linha_atend->cod_ie."<br>";}

                                                                $dat_atendimento=converteDataBR($linha_atend->dat_atendimento);

                                                                $nom_nome=$linha_atend->nom_nome;
                                                                $nom_tipo=$linha_atend->nom_tipo;
                                                                $nom_status=$linha_atend->nom_status;
                                                                
                                                            }
                                                        }
                                    } else{?>
                                                <td  width='25%'></td>     
                                    <?php }?>
                                                    
                                                    <div id="dadosAtendimento_pesq" >
                                                        <?php 
                                                        if( $cod_atendimento != null && $dados==1){
                                                            echo"<br>".$dat_atendimento ."<br>".
                                                                $nom_nome."<br>";
                                                                if ($doc != "") {echo $doc;}
                                                                echo "Tipo:".$nom_tipo."<br>".
                                                                "Situação:".$nom_status;
                                                        } ?>
                                                    </div>   
                                            </div>                    
                                    </td>
                                    
                                    <td  width='15%'><?php if ($r->dat_resposta!=NULL) echo "Sim";?>
                                        
                                    <?php 
                                    if( $r->dat_resposta!=NULL){
                                          $nom_div_resp='div_resposta_pesq_'.$cod_documento;
                                          $add_div_resp='add_detalhes_resposta_'.$cod_documento;
                                          $sub_div_resp='sub_detalhes_resposta_'.$cod_documento;
                                    ?>
                                        
                                    <a href="#" onclick="MostraResposta_pesq(<?php echo $cod_documento;?>);" id="<?php echo $add_div_resp;?>"  style="display:'';"><i class="far fa-plus-square" style="font-size:20px; color:000000; float: right;"></i></a>
                                    <a href="#" onclick="OcultarResposta_pesq(<?php echo $cod_documento;?>);" id="<?php echo $sub_div_resp;?>"  style="display:none;"><i class="far fa-minus-square" style="font-size:20px; color:000000; float: right;"></i></a>
                                    
                                    <!--detalhes resposta-->
                                        <div class="form-group" id="<?php echo $nom_div_resp;?>" style="display:none;">
                                                    
                                                <?php
                                                    $data = str_replace("/", "-", $r->dat_resposta);
                                                    $dat_resposta = date('d/m/Y', strtotime($data));
                                                    if(!empty($r->lnk_documento)){
                                                        $lnk_documento=$r->lnk_documento;
                                                    }else{
                                                        $lnk_documento="";
                                                    }
                                                ?>
                                                <div id="dadosResposta_pesq" >
                                                        <?php 
                                                        if($r->dat_resposta!=NULL){
                                                            echo"<br>".$dat_resposta;
                                                        } ?>
                                                    </div>  
                                             
                                        </div>
                                    
                                    <?php
                                    }?>
                                    </td>
                                  </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        </div>
                        <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . "#pes";?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li>
                                    <a href="form_pesquisar_documento.php?pagina=1&pesquisa=1&cod_tip_doc=<?php echo $cod_tip_doc;?>&nom_documento=<?php echo $nom_documento;?>&dat_ano=<?php echo $dat_ano;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&cod_status=<?php echo $cod_status;?>&cod_uni_doc=<?php echo $cod_uni_doc;?>&cod_atendimento=<?php echo $cod_atendimento;?>&dat_resposta=<?php echo $dat_resposta;?>&all=<?php echo $all;?>#pes" aria-label="Previous">
                                       <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php 
                                 for($i=1;$i<=$num_paginas;$i++) { 
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;   
                                    ?> 
                                    <li <?php echo $estilo; ?>><a href="form_pesquisar_documento.php?pagina=<?php echo $i; ?>&pesquisa=1&cod_tip_doc=<?php echo $cod_tip_doc;?>&nom_documento=<?php echo $nom_documento;?>&dat_ano=<?php echo $dat_ano;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&cod_status=<?php echo $cod_status;?>&cod_uni_doc=<?php echo $cod_uni_doc;?>&cod_atendimento=<?php echo $cod_atendimento;?>&dat_resposta=<?php echo $dat_resposta;?>&all=<?php echo $all;?>#pes"> <?php echo $i;?> </a></li><?php }

                                    ?>
                                    <li>
                                        <a href="form_pesquisar_documento.php?pagina=<?php echo $num_paginas; ?>&pesquisa=1&cod_tip_doc=<?php echo $cod_tip_doc;?>&nom_documento=<?php echo $nom_documento;?>&dat_ano=<?php echo $dat_ano;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&cod_status=<?php echo $cod_status;?>&cod_uni_doc=<?php echo $cod_uni_doc;?>&cod_atendimento=<?php echo $cod_atendimento;?>&dat_resposta=<?php echo $dat_resposta;?>&all=<?php echo $all;?>#pes" aria-label="Next">
                                             <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                            <a href="<?php echo$actual_link;?>" class="btn btn-default" style="margin-top: 18px;padding: 17px 20px;float: right;"><i class="fas fa-angle-double-up" title="Ir ao topo"></i></a>
                        </nav>
                    <?php
                    }
                }else{
                    echo"";
                }
                    ?>
            </div>
        
            <script>
                
                function modal(url, title, w, h){
                    var left = (screen.width/2)-(w/2);
                    var top = (screen.height/2)-(h/1.5);
                    return window.open(url, title, 'width='+w+', height='+h+', top='+top+', left='+left);
                    //return window.open(url, '_blank');
                } 
                
            </script>
            <?php include 'includes/footer.html';
            
            }
            else 
            { 
            ?>
                <p>
                    <span class="error">Você não tem autorização para acessar esta página.</span> Please <a href="index.php">login</a>.
                </p>
            <?php 
            } 
         ?>
    </body>
</html>