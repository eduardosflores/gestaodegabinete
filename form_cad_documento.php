<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    
    session_start();

    if (isset($_POST['cod_tipo']))
    {
      $_SESSION['cod_tipo'] = $_POST['cod_tipo'];
    }
    else if (!isset($_SESSION['cod_tipo']))
    {
        $_SESSION['cod_tipo'] = "";
    }
    if (isset($_POST['nom_documento']))
    {
      $_SESSION['nom_documento'] = $_POST['nom_documento'];
    }
    else if (!isset($_SESSION['nom_documento']))
    {
        $_SESSION['nom_documento'] = "";
    }
    if (isset($_POST['dat_ano']))
    {
      $_SESSION['dat_ano'] = $_POST['dat_ano'];
    }
    else if (!isset($_SESSION['dat_ano']))
    {
        $_SESSION['dat_ano'] = "";
    }
    if (isset($_POST['dat_documento']))
    {
      $_SESSION['dat_documento'] = $_POST['dat_documento'];
    }
    else if (!isset($_SESSION['dat_documento']))
    {
        $_SESSION['dat_documento'] = "";
    }
    if (isset($_POST['cod_status']))
    {
      $_SESSION['cod_status'] = $_POST['cod_status'];
    }
    else if (!isset($_SESSION['cod_status']))
    {
        $_SESSION['cod_status'] = "";
    }
    if (isset($_POST['cod_uni_doc']))
    {
      $_SESSION['cod_uni_doc'] = $_POST['cod_uni_doc'];
    }
    else if (!isset($_SESSION['cod_uni_doc']))
    {
        $_SESSION['cod_uni_doc'] = "";
    }
    if (isset($_GET['pagina']))
    {
        $_SESSION['pagina'] = $_GET['pagina'];
    }
    else if (!isset($_SESSION['pagina']))
    {
        $_SESSION['pagina'] = "1";
    }

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
            
            function MostraAtendimento_alt(){
                if(document.form.check_atendimento.checked == true){
                    document.getElementById( 'div_atendimento' ).style.display = '';
                    //document.getElementById('cod_atendimento').value='';
                    //document.getElementById('dadosAtendimento').innerHTML='';
                    document.getElementById('dadosAtendimento').style.display='';
                }
                else{
                    document.getElementById( 'div_atendimento' ).style.display = 'none';
                    //document.getElementById('cod_atendimento').value='';
                    //document.getElementById('dadosAtendimento').innerHTML='';
                    document.getElementById('dadosAtendimento').style.display='none';
                }
            }
            
            function MostraResposta(){
                if(document.form.check_resposta.checked == true){
                    document.getElementById( 'div_data' ).style.display = '';
                    document.getElementById( 'div_documento' ).style.display = '';
                    document.getElementById( 'div_detalhes' ).style.display = '';
                    document.getElementById( 'div_link_resposta' ).style.display = '';
                }
                else{
                    document.getElementById( 'div_data' ).style.display = 'none';
                    document.getElementById( 'div_documento' ).style.display = 'none';
                    document.getElementById( 'div_detalhes' ).style.display = 'none';
                    document.getElementById( 'div_link_resposta' ).style.display = 'none';
                }
            }
            
            function MostraResposta_alt(){
                if(document.form.check_resposta.checked == true){
                    document.getElementById( 'bloco_resposta_alt' ).style.display = '';
                    document.getElementById( 'div_data' ).style.display = '';
                    document.getElementById( 'div_documento' ).style.display = '';
                    document.getElementById( 'div_detalhes' ).style.display = '';
                    document.getElementById( 'div_link_resposta' ).style.display = '';
                }
                else{
                    document.getElementById( 'bloco_resposta_alt' ).style.display = 'none';
                    document.getElementById( 'div_data' ).style.display = 'none';
                    document.getElementById( 'div_documento' ).style.display = 'none';
                    document.getElementById( 'div_detalhes' ).style.display = 'none';
                    document.getElementById( 'div_link_resposta' ).style.display = 'none';
                }
            }
            
            function MostraAltDocumento()
            {
                if(document.form.check_alt.checked == true){
                    document.getElementById( 'alt_documento' ).style.display = '';
                }
                else{
                    document.getElementById( 'alt_documento' ).style.display = 'none';
                }
            }
            
            function MostraAltLinkDocumento()
            {
                if(document.form.check_link_alt.checked == true){
                    document.getElementById( 'lnk_documento' ).style.display = '';
                }
                else{
                    document.getElementById( 'lnk_documento' ).style.display = 'none';
                }
            }
            
            function MostraAltResposta()
            {
                if(document.form.check_alt_resposta.checked == true){
                    document.getElementById( 'alt_resposta' ).style.display = '';
                }
                else{
                    document.getElementById( 'alt_resposta' ).style.display = 'none';
                }
            }
            
            function MostraAltLinkResposta()
            {
                if(document.form.check_link_alt_resposta.checked == true){
                    document.getElementById( 'lnk_resposta' ).style.display = '';
                }
                else{
                    document.getElementById( 'lnk_resposta' ).style.display = 'none';
                }
            }
            
            function SomenteNumero(e){
                var tecla=(window.event)?event.keyCode:e.which;   
                if((tecla>47 && tecla<58)) return true;
                else{
                    if (tecla==8 || tecla==0) return true;
                    else  return false;
                }
            }
            
            function pesquisar()
            {         
                document.form.action = "form_cad_documento.php?pagina=1&pesquisa=1#pes";
                document.form.submit();
            }

            function voltarPagina()
            {
                window.location.href = "form_cad_documento.php?pagina=<?=$_SESSION['pagina'];?>&pesquisa=1&cod_tipo=<?=$_SESSION['cod_tipo'];?>&nom_documento=<?=$_SESSION['nom_documento'];?>&dat_ano=<?=$_SESSION['dat_ano'];?>&dat_documento=<?=$_SESSION['dat_documento'];?>&cod_status=<?=$_SESSION['cod_status'];?>&cod_uni_doc=<?=$_SESSION['cod_uni_doc'];?>#pes";
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
            
            $(document).ready(function() {
                 $(".meuselect").select2();
            });
        </script>
        
    </head>
    <body>
        <?php if (login_check($mysqli) == true) 
            {
                include 'includes/cabecalho.php';
                
                if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])){
                    $cod_documento = $_GET['cod_documento'];
                    
                    if ($resultado=$mysqli->query("SELECT gab_documento.dat_ano, gab_documento.nom_documento, gab_documento.dat_documento, gab_documento.lnk_documento, "
                            . "gab_documento.txt_assunto, gab_documento.GAB_TIPO_DOCUMENTO_cod_tip_doc cod_tip_doc, gab_documento.GAB_STATUS_DOCUMENTO_cod_status cod_status, "
                            . "gab_documento.GAB_UNIDADE_DOCUMENTO_cod_uni_doc cod_uni_doc, "
                            . "gab_documento.GAB_ATENDIMENTO_cod_atendimento cod_atendimento, "
                            . "gab_documento.dat_resposta, gab_documento.txt_resposta, gab_documento.lnk_resposta "
                            . "FROM gab_documento "
                            . "WHERE gab_documento.cod_documento = '$cod_documento'")){
                        if ($resultado->num_rows){
                            $linha=$resultado->fetch_object();
                            $cod_atendimento = $linha->cod_atendimento;
                            $dat_resposta = $linha->dat_resposta;
                        }
                    }
                }
        ?>
            <div class="container" id="main">
                <div class="page-header">
                    <?php if (isset($_GET['msg']))
                    {
                        echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['msg'].'</strong></div>';                     
                    }
                    else if (isset($_GET['err']))
                    {
                        echo '<div class="alert alert-warning fade in "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['err'].'</strong></div>';
                    }
                 ?>
                    <h1 class="h2">Cadastro de Documento Parlamentar</h1>
                </div>
                <form  name="form" class="form-horizontal" action="action_cad_documento.php" method="post" autocomplete="off" enctype="multipart/form-data" onsubmit="return checarCampos()">
                    
                    <?php 
                        if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento']))
                        {
                            echo "<input type='hidden' name='alt' id='alt'>";
                            echo "<input type='hidden' name='cod_documento' value=".$_GET['cod_documento'].">";
                        }
                    ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tipo de Documento:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT cod_tip_doc, nom_tip_doc, ind_tip_doc FROM gab_tipo_documento WHERE ind_tip_doc ='A' order by nom_tip_doc")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-3">
                                   <select class="meuselect" name="cod_tipo">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['cod_tip_doc'];?>"
                                           <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])){
                                            if (($linha->cod_tip_doc==$linha_set_gab['cod_tip_doc'])){echo "selected";}}
                                            elseif (!empty($_SESSION['cod_tipo']) && isset($_GET['pesquisa'])){
                                                if (($_SESSION['cod_tipo']==$linha_set_gab['cod_tip_doc'])){echo "selected";}}
                                            ?>> 
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
                                <div class="col-md-3">
                                    <select class="form-control" name="cod_tipo" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Tipo de Documento cadastrado">
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-5">
                                   <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe Tipo de Documento cadastrado.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" autocomplete="on">Número:</label>  
                        <div class="col-md-2">
                            <input name="nom_documento" type="text" placeholder="" class="form-control input-md"
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) {echo $linha->nom_documento;} elseif (!empty($_SESSION['nom_documento']) && isset($_GET['pesquisa'])) {echo $_SESSION['nom_documento'];}?>">
                        </div>
                        <label class="col-md-1 control-label" autocomplete="on">Ano:</label>  
                        <div class="col-md-1">
                            <input name="dat_ano" type="text" placeholder="" class="form-control input-md" maxlength="4" minlength="4" onkeypress='return SomenteNumero(event)'
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) {echo $linha->dat_ano;} elseif (!empty($_SESSION['dat_ano']) && isset($_GET['pesquisa'])) {echo $_SESSION['dat_ano']; }?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" autocomplete="on">Data:</label>  
                        <div class="col-md-2">
                            <input name="dat_documento" id="data" type="text" placeholder="" class="form-control input-md datepicker" onblur="validaData(this)" required
                                value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) {echo escape(converteDataBR($linha->dat_documento));} elseif (!empty($_SESSION['dat_documento']) && isset($_GET['pesquisa'])) {echo $_SESSION['dat_documento'];}?>">
                        </div>
                        <label class="col-md-1 control-label">Situação:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT cod_status, nom_status, ind_status FROM gab_status_documento WHERE ind_status ='A' order by nom_status")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-2">
                                   <select class="meuselect" name="cod_status">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['cod_status'];?>"
                                           <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])){
                                            if (($linha->cod_status==$linha_set_gab['cod_status'])){echo "selected";}}
                                            elseif (!empty($_SESSION['cod_status']) && isset($_GET['pesquisa'])){
                                                if (($_SESSION['cod_status']==$linha_set_gab['cod_status'])){echo "selected";}}
                                            ?>> 
                                               <?php echo $linha_set_gab['nom_status'];?>
                                       </option> 
                                       <?php
                                       }?>
                                   </select>
                                </div><?php 
                                $cond = false;
                            }
                            else
                            {?>                          
                                <div class="col-md-2">
                                    <select class="form-control" name="cod_status" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Situação de Documento cadastrada">
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-5">
                                    <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe Situação de Documento cadastrada.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Unidade Administrativa:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT cod_uni_doc, nom_uni_doc, ind_uni_doc FROM gab_unidade_documento WHERE ind_uni_doc ='A' order by nom_uni_doc")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-3">
                                   <select class="meuselect" name="cod_uni_doc">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['cod_uni_doc'];?>"
                                           <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])){
                                                if (($linha->cod_uni_doc==$linha_set_gab['cod_uni_doc'])){echo "selected";}}
                                            elseif (!empty($_SESSION['cod_uni_doc']) && isset($_GET['pesquisa'])){
                                                if (($_SESSION['cod_uni_doc']==$linha_set_gab['cod_uni_doc'])){echo "selected";}}
                                        ?>> 
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
                                <div class="col-md-3">
                                    <select class="form-control" name="cod_uni_doc" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Unidade Administrativa cadastrada">
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-5">
                                    <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe Unidade Administrativa cadastrada.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Assunto:</label>
                        <div class="col-sm-7">
                            <textarea name="txt_assunto" class="form-control" rows="5"><?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) {echo trim($linha->txt_assunto);}?></textarea>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="checkbox" id="atendimento">
                            <label class="col-md-2"></label>
                            <label>
                                <input name="check_atendimento" type="checkbox" 
                                    <?php if(isset($_GET['alt']) && $cod_atendimento != null) echo 'checked'; ?> 
                                    <?php if(isset($_GET['alt']) && $cod_atendimento != null){ echo 'onclick="MostraAtendimento_alt()"';} else {echo 'onclick="MostraAtendimento()"';}?>>Possui Atendimento relacionado
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group" style="<?php if(isset($_GET['alt']) && $cod_atendimento != null){echo "";} else {echo "display: none;";} ?>" id="div_atendimento">     
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-5">
                            <?php 
                            if(isset($_GET['alt']) && $cod_atendimento != null){
                                
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
                                        if($linha_atend->ind_pessoa == "PF" && !empty($linha_atend->cod_rg)){ $doc.=" RG:".$linha_atend->cod_rg; }
                                        if ($linha_atend->ind_pessoa == "PF" && !empty($linha_atend->cod_cpf_cnpj)){ $doc.=" CPF:".$linha_atend->cod_cpf_cnpj; }
                                        if ($linha_atend->ind_pessoa == "PJ" && !empty($linha_atend->cod_cpf_cnpj)){ $doc.=" CNPJ:".$linha_atend->cod_cpf_cnpj; }
                                        if ($linha_atend->ind_pessoa == "PJ" && !empty($linha_atend->cod_ie)){ $doc.=" IE:".$linha_atend->cod_ie; }

                                        $dat_atendimento=converteDataBR($linha_atend->dat_atendimento);

                                        $nom_nome=$linha_atend->nom_nome;
                                        $nom_tipo=$linha_atend->nom_tipo;
                                        $nom_status=$linha_atend->nom_status;
                                        
                                    }
                                }
                            } 
                            ?>
                            
                            <div id="dadosAtendimento">
                                <?php 
                                if(isset($_GET['alt']) && $cod_atendimento != null && $dados==1){
                                    echo "<b>Data:</b>".$dat_atendimento ."<br>".
                                         "<b>Pessoa:</b>".$nom_nome."<br>".
                                         "<b>Doc. Identificação:</b>".$doc."<br>".
                                         "<b>Tipo:</b>".$nom_tipo."<br>".
                                         "<b>Situação:</b>".$nom_status;
                                } ?>
                            </div>
                            
                            <button type="button" class="btn btn-success" onclick="modal('form_cad_atendimento.php?mod=1','modal',1000,500)"><?php if(isset($_GET['alt']) && $cod_atendimento != null && $dados==1){echo"Trocar Atendimento";} else{echo"Pesquisar Atendimento";}?></button>
                            
                            <input type="hidden" name="cod_atendimento" id="cod_atendimento"
                                   value="<?php if(isset($_GET['alt']) && $cod_atendimento != null){echo $cod_atendimento;} ?>">
                        </div>    
                    </div>
                    
                    
                    <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) {
                        $dir = "documentos/";
                        
                        $documento=0;
                        if(($dh = opendir($dir)) != FALSE){
                            while (false !== ($filename = readdir($dh))) {
                                //echo $filename;
                                $pos = strripos($filename,".");
                                //echo 'pos:'.$pos;
                                $aux_doc = substr($filename,0,$pos);
                                //echo 'aux_doc:'.$aux_doc."-";

                                if ($aux_doc == $cod_documento) {
                                    $documento=1;
                                    $extensao=explode(".",$filename)[1];
                                    $filename = "doc".$linha->nom_documento.$linha->dat_ano.".".$extensao;
                                    $filename_cod = $cod_documento.".".$extensao;
                                    
                                    break;
                                }
                            }
                        }
                        
                        if ($documento==1){
                        ?>
                        <div class="form-group">
                            <div class = "panel panel-success col-md-7">
                                <div class = "panel-heading">
                                   <h3 class = "panel-title">Documento</h3>
                                </div>

                                <div class = "panel-body">
                                   <div class="form-group">
                                        <label class="col-md-2 text-right"></label>
                                        <div class="col-sm-7">
                                            <?php echo "<a download='$filename' href='documentos/".$filename_cod."'>$filename</a><br>";?>     
                                            <input onclick="MostraAltDocumento()" name="check_alt" type="checkbox">Substituir Documento
                                        </div>
                                    </div>
                                    <div class="form-group" id="alt_documento" style="display: none;">
                                        <label class="col-md-2 control-label"></label>
                                        <div class="col-md-7 text-left">
                                            <input name="documento" type="file" class="form-control">
                                            <span>Tamanho máximo:25 MB</span>
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Link:</label>
                                        <div class="col-sm-7">
                                            <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento']) && !empty($linha->lnk_documento)) {
                                                echo "<a target='_blank' href=".trim($linha->lnk_documento).">".trim($linha->lnk_documento)."</a><br>";?>
                                                <input type="hidden" name="lnk_documento_bkp" value="<?php echo trim($linha->lnk_documento);?>">
                                                <input onclick="MostraAltLinkDocumento()" name="check_link_alt" type="checkbox">Substituir Link
                                                <input name="lnk_documento" id="lnk_documento" type="text" placeholder="" class="form-control input-md" style="display: none;">
                                            <?php
                                            }else{?>
                                            <input name="lnk_documento" type="text" placeholder="" class="form-control input-md">
                                            <?php 
                                            }?>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        
                        <?php
                        }
                        else
                        {
                        ?>
                            
                            <div class="form-group">
                                <div class = "panel panel-success col-md-7">
                                    <div class = "panel-heading">
                                       <h3 class = "panel-title">Documento</h3>
                                    </div>
                                    
                                    <div class = "panel-body">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"></label>
                                            <div class="col-sm-7 text-left">
                                                <input type="file" name="documento" class="form-control" 
                                                    value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) {echo "documentos/".$cod_documento."docx";}?>">
                                                <span>Tamanho máximo:25 MB</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Link:</label>
                                             <div class="col-sm-7">
                                                <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento']) && !empty($linha->lnk_documento)) {
                                                    echo "<a target='_blank' href=".trim($linha->lnk_documento).">".trim($linha->lnk_documento)."</a><br>";?>
                                                    <input type="hidden" name="lnk_documento_bkp" value="<?php echo trim($linha->lnk_documento);?>">
                                                    <input onclick="MostraAltLinkDocumento()" name="check_link_alt" type="checkbox">Substituir Link
                                                    <input name="lnk_documento" id="lnk_documento" type="text" placeholder="" class="form-control input-md" style="display: none;">
                                                <?php
                                                }else{?>
                                                <input name="lnk_documento" type="text" placeholder="" class="form-control input-md">
                                                <?php 
                                                }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        
                        <?php
                        }
                    }
                    else 
                    {?>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Documento:</label>
                            <div class="col-md-5">
                                <input type="file" name="documento" class="form-control" 
                                    value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) {echo "documentos/".$cod_documento."docx";}?>">
                                <span>Tamanho máximo:25 MB</span>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label class="col-md-2 control-label">Link Documento:</label>
                            <div class="col-md-5">
                                <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento']) && !empty($linha->lnk_documento)) {
                                    echo "<a target='_blank' href=".trim($linha->lnk_documento).">".trim($linha->lnk_documento)."</a><br>";?>
                                    <input type="hidden" name="lnk_documento_bkp" value="<?php echo trim($linha->lnk_documento);?>">
                                    <input onclick="MostraAltLinkDocumento()" name="check_link_alt" type="checkbox">Substituir Link
                                    <input name="lnk_documento" id="lnk_documento" type="text" placeholder="" class="form-control input-md" style="display: none;">
                                <?php
                                }else{?>
                                <input name="lnk_documento" type="text" placeholder="" class="form-control input-md">
                                <?php 
                                }?>
                            </div>
                        </div>
                    <?php  
                    }
                    ?>
                    
                    <div class="form-group" id='resposta'>
                        <div class="checkbox" >
                            <label class="col-md-2"></label>
                            <label>
                                <input id="checkbox_resposta" type="checkbox" name="check_resposta" 
                                    <?php if(isset($_GET['alt']) && $dat_resposta != null) echo "checked"; ?>  
                                    <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) {echo 'onclick="MostraResposta_alt()"';} else{echo 'onclick="MostraResposta()"';} ?>>Possui Resposta
                            </label>
                        </div>
                    </div>
                    
                    <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) {
                        $dir = "respostas/";
                    
                        $doc_resposta=0;
                        if(($dh = opendir($dir)) != FALSE){
                            while (false !== ($filename = readdir($dh))) {
                                //echo $filename;
                                $pos = strripos($filename,".");
                                //echo 'pos:'.$pos;
                                $aux_doc = substr($filename,0,$pos);
                                //echo 'aux_doc:'.$aux_doc."-";

                                if ($aux_doc == $cod_documento) {
                                    $doc_resposta=1;
                                    $extensao=explode(".",$filename)[1];
                                    $filename = "resposta_doc".$linha->nom_documento.$linha->dat_ano.".".$extensao;
                                    $filename_cod = $cod_documento.".".$extensao;
                                    
                                    break;
                                }
                            }
                        }                                
                        
                        if ($doc_resposta==1){
                        ?>
                            <div class="form-group" id="bloco_resposta_alt">
                                <div class = "panel panel-success col-sm-7">
                                    <div class = "panel-heading">
                                       <h3 class = "panel-title">Resposta</h3>
                                    </div>

                                    <div class = "panel-body">

                                       <div class="form-group">
                                            <label class="col-md-2 text-right"></label>
                                            <div class="col-sm-7">
                                                <?php echo "<a download='$filename' href='respostas/".$filename_cod."'>$filename</a><br>";?>     
                                                <input onclick="MostraAltResposta()" name="check_alt_resposta" type="checkbox">Substituir Documento de Resposta
                                            </div>
                                       </div>
                                        
                                        <div class="form-group" id="alt_resposta" style="display: none;">
                                            <label class="col-sm-2 control-label"></label>
                                            <div class="col-sm-7 text-left">
                                                <input name="documento_resposta" type="file" class="form-control">
                                                <span>Tamanho máximo:25 MB</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" id="div_link_resposta">
                                            <label class="col-md-2 control-label">Link:</label>
                                            <div class="col-sm-7">
                                                <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento']) && !empty($linha->lnk_resposta)) {
                                                     echo "<a target='_blank' href=".trim($linha->lnk_resposta).">".trim($linha->lnk_resposta)."</a><br>";?>
                                                     <input type="hidden" name="lnk_resposta_bkp" value="<?php echo trim($linha->lnk_resposta);?>">
                                                     <input onclick="MostraAltLinkResposta()" name="check_link_alt_resposta" type="checkbox">Substituir Link
                                                     <input name="lnk_resposta" id="lnk_resposta" type="text" class="form-control" style="display: none;">
                                                <?php
                                                }else{?>
                                                <input name="lnk_resposta" type="text" placeholder="" class="form-control input-md">
                                                <?php 
                                                }?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" id="div_data">
                                            <label class="col-md-2 control-label" autocomplete="on">Data:</label>  
                                            <div class="col-md-3">
                                                <input name="dat_resposta" id="dat_resposta" type="text" class="form-control input-md datepicker" onblur="validaData(this)"
                                                       value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) {echo escape(converteDataBR($linha->dat_resposta));}?>">
                                            </div>
                                        </div>
                               
                                        <div class="form-group" id="div_detalhes">
                                            <label class="col-sm-2 control-label">Detalhes:</label>
                                            <div class="col-sm-10">
                                                <textarea name="txt_resposta" class="form-control" rows="5"><?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) {echo trim($linha->txt_resposta);}?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div> 
                            </div>
                        <?php
                        }
                        else
                        {
                        ?>
                            <div class="form-group" id="bloco_resposta_alt" style="<?php if ($dat_resposta != null){echo "";} else {echo "display: none;";} ?>">
                                <div class = "panel panel-success col-sm-7">
                                    <div class = "panel-heading">
                                       <h3 class = "panel-title">Resposta</h3>
                                    </div>

                                    <div class = "panel-body">

                                        <div class="form-group" id="div_data" style="<?php if ($dat_resposta != null){echo "";} else {echo "display: none;";} ?>">
                                            <label class="col-sm-2 control-label" autocomplete="on">Data:</label>  
                                            <div class="col-sm-3">
                                                <input name="dat_resposta" id="dat_resposta" type="text" class="form-control input-md datepicker" onblur="validaData(this)"
                                                       value="<?php echo escape(converteDataBR($dat_resposta)); ?>">
                                            </div>
                                        </div>

                                        <div class="form-group" id="div_documento" style="<?php if ($dat_resposta != null){echo "";} else {echo "display: none;";} ?>">
                                           <label class="col-sm-2 control-label"></label>
                                            <div class="col-sm-7 text-left">
                                                <input name="documento_resposta" type="file" class="form-control">
                                                <span>Tamanho máximo:25 MB</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" id="div_link_resposta" style="<?php if($dat_resposta != null){echo "";} else {echo "display: none;";} ?>">
                                            <label class="col-md-2 control-label">Link:</label>
                                            <div class="col-sm-7">
                                                <?php if (!empty($linha->lnk_resposta)) {
                                                     echo "<a target='_blank' href=".trim($linha->lnk_resposta).">".trim($linha->lnk_resposta)."</a><br>";?>
                                                     <input type="hidden" name="lnk_resposta_bkp" value="<?php echo trim($linha->lnk_resposta);?>">
                                                     <input onclick="MostraAltLinkResposta()" name="check_link_alt_resposta" type="checkbox">Substituir Link
                                                     <input name="lnk_resposta" id="lnk_resposta" type="text" class="form-control" style="display: none;">
                                                <?php
                                                }else{?>
                                                <input name="lnk_resposta" type="text" placeholder="" class="form-control input-md">
                                                <?php 
                                                }?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" id="div_detalhes" style="<?php if($dat_resposta != null){echo "";} else {echo "display: none;";} ?>">
                                            <label class="col-sm-2 control-label">Detalhes:</label>
                                            <div class="col-sm-10">
                                                <textarea name="txt_resposta" class="form-control" rows="5"><?php echo trim($linha->txt_resposta); ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    }
                    else 
                    {?>
                        <div class="form-group" id="div_data" style="<?php if(isset($_GET['alt']) && $dat_resposta != null){echo "";} else {echo "display: none;";} ?>">
                            <label class="col-md-2 control-label" autocomplete="on">Data:</label>  
                            <div class="col-md-2">
                                <input name="dat_resposta" id="dat_resposta" type="text" class="form-control input-md datepicker" onblur="validaData(this)"
                                       value="<?php if (!empty ($_GET) && isset($_GET['alt']) && $dat_resposta != null) {echo escape(converteDataBR($linha->dat_resposta));}?>">
                            </div>
                        </div>

                        <div class="form-group" id="div_documento" style="<?php if(isset($_GET['alt']) && $dat_resposta != null){echo "";} else {echo "display: none;";} ?>">
                            <label class="col-sm-2 control-label">Resposta:</label>
                            <div class="col-sm-5">
                                <input name="documento_resposta" type="file" class="form-control">
                                <span>Tamanho máximo:25 MB</span>
                            </div>
                        </div>
                    
                        <div class="form-group" id="div_link_resposta" style="<?php if(isset($_GET['alt']) && $dat_resposta != null){echo "";} else {echo "display: none;";} ?>">
                            <label class="col-md-2 control-label">Link Resposta:</label>
                            <div class="col-md-5">
                                <input name="lnk_resposta" type="text" placeholder="" class="form-control input-md"
                                       value="<?php if (!empty ($_GET) && isset($_GET['alt']) && $dat_resposta != null) {echo $linha->lnk_resposta;}?>">
                            </div>
                        </div>
                    
                        <div class="form-group" id="div_detalhes" style="<?php if(isset($_GET['alt']) && $dat_resposta != null){echo "";} else {echo "display: none;";} ?>">
                            <label class="col-sm-2 control-label">Detalhes:</label>
                            <div class="col-sm-7">
                                <textarea name="txt_resposta" class="form-control" rows="5"><?php if (!empty ($_GET) && isset($_GET['alt']) && $dat_resposta != null) {echo trim($linha->txt_resposta);}?></textarea>
                            </div>
                        </div>
                    <?php  
                    }
                    ?>
                    
                    
                    <div class="form-group">
                        <div class="col-md-5 text-right">
                            <input type="submit" <?php if($cond) { echo "disabled";}?>  class="btn btn-default" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_documento'])) { echo "value='Alterar'";}else{ echo "value='Cadastrar'";}?>>
                            <input type="button" class="btn btn-default" value="Limpar" onclick="window.location='form_cad_documento.php';">
                            <input type="button" id="pes" class="btn btn-default" value="Pesquisar" onclick="pesquisar();">
                            <input type="button" id="voltar" class="btn btn-default" value="Voltar" onclick="voltarPagina();" <?php if (!isset($_GET['pesquisa']) && !isset($_GET['alt'])){ echo "style='visibility:hidden;'";} ?>>
                        </div>
                    </div>
                </form>
                <?php
                
                
                
                    $total_registros=1000;
                    $itens_por_pag = 50;
                    if(isset($_GET['pagina'])){$pagina = intval($_GET['pagina']);}else {$pagina=1;}
                    $aux=$pagina*50-50;
                    
                    $records=array();
                    
                    if (isset($_GET['pesquisa']) || isset($_GET['pagina']))
                    {    
                        $sql="SELECT gab_documento.cod_documento, gab_documento.nom_documento, gab_documento.dat_ano, gab_documento.dat_documento, "
                        . "gab_documento.txt_assunto, gab_tipo_documento.nom_tip_doc, gab_status_documento.nom_status, gab_unidade_documento.nom_uni_doc, "
                        . "gab_documento.GAB_ATENDIMENTO_cod_atendimento cod_atendimento, gab_documento.dat_resposta, gab_documento.txt_resposta  "
                        . "FROM gab_documento "
                        . "LEFT JOIN gab_tipo_documento ON gab_tipo_documento.cod_tip_doc = gab_documento.GAB_TIPO_DOCUMENTO_cod_tip_doc "
                        . "LEFT JOIN gab_status_documento ON gab_status_documento.cod_status = gab_documento.GAB_STATUS_DOCUMENTO_cod_status "
                        . "LEFT JOIN gab_unidade_documento ON gab_unidade_documento.cod_uni_doc = gab_documento.GAB_UNIDADE_DOCUMENTO_cod_uni_doc "
                        . "WHERE gab_documento.ind_status='A' ";
                        
                        if (isset($_POST['cod_tipo']) && !empty($_POST['cod_tipo'])){
                            $cod_tipo=$_POST['cod_tipo'];
                            $sql.="AND gab_tipo_documento.cod_tip_doc=$cod_tipo ";
                        } else
                        if (isset($_GET['cod_tipo']) && !empty($_GET['cod_tipo'])){
                            $cod_tipo=$_GET['cod_tipo'];
                            $sql.="AND gab_tipo_documento.cod_tip_doc=$cod_tipo ";
                        }
                        else
                        {
                            $cod_tipo = "";
                        }
                        if (isset($_POST['nom_documento']) && !empty($_POST['nom_documento'])){
                            $nom_documento=$_POST['nom_documento'];
                            $sql.=" and gab_documento.nom_documento='$nom_documento' ";
                        } else
                        if (isset($_GET['nom_documento']) && !empty($_GET['nom_documento'])){
                            $nom_documento=$_GET['nom_documento'];
                            $sql.=" and gab_documento.nom_documento='$nom_documento' ";
                        }
                        else
                        {
                            $nom_documento = "";
                        }
                        if (isset($_POST['dat_ano']) && !empty($_POST['dat_ano'])){
                            $dat_ano=$_POST['dat_ano'];
                            $sql.=" and gab_documento.dat_ano='$dat_ano' ";
                        } else
                        if (isset($_GET['dat_ano']) && !empty($_GET['dat_ano'])){
                            $dat_ano=$_GET['dat_ano'];
                            $sql.=" and gab_documento.dat_ano='$dat_ano' ";
                        }
                        else
                        {
                            $dat_ano = "";
                        }
                        if (isset($_POST['dat_documento']) and !empty ($_POST['dat_documento']))
                        {
                            $dat_documento=  converte_data($_POST['dat_documento']);
                            $sql.="AND gab_documento.dat_documento='$dat_documento' ";
                        } else
                        if (isset($_GET['dat_documento']) and !empty ($_GET['dat_documento']))
                        {
                            $dat_documento=  converte_data($_GET['dat_documento']);
                            $sql.="AND gab_documento.dat_documento='$dat_documento' ";
                        }
                        else
                        {
                            $dat_documento = "";
                        }
                        if (isset($_POST['cod_status']) && !empty($_POST['cod_status'])){
                            $cod_status=$_POST['cod_status'];
                            $sql.="AND gab_status_documento.cod_status=$cod_status ";
                        } else
                        if (isset($_GET['cod_status']) && !empty($_GET['cod_status'])){
                            $cod_status=$_GET['cod_status'];
                            $sql.="AND gab_status_documento.cod_status=$cod_status ";
                        }
                        else
                        {
                            $cod_status = "";
                        }
                        if (isset($_POST['cod_uni_doc']) && !empty($_POST['cod_uni_doc'])){
                            $cod_uni_doc=$_POST['cod_uni_doc'];
                            $sql.="AND gab_unidade_documento.cod_uni_doc=$cod_uni_doc ";
                        } else
                        if (isset($_GET['cod_uni_doc']) && !empty($_GET['cod_uni_doc'])){
                            $cod_uni_doc=$_GET['cod_uni_doc'];
                            $sql.="AND gab_unidade_documento.cod_uni_doc=$cod_uni_doc ";
                        }
                        else
                        {
                            $cod_uni_doc = "";
                        }
                        
                        if ($results = $mysqli->query($sql."ORDER BY gab_documento.dat_documento DESC, gab_tipo_documento.nom_tip_doc, gab_status_documento.nom_status, gab_unidade_documento.nom_uni_doc ASC LIMIT $aux, $itens_por_pag"))
                        {
                            $num=$results->num_rows;

                            $num_total = $mysqli->query($sql)->num_rows;
                            if ($num_total>$total_registros){$num_total=$total_registros;}

                            $num_paginas=  ceil($num_total/$itens_por_pag);

                            if ($results->num_rows){
                                while($row = $results->fetch_object()){
                                    $records[]=$row;
                                }
                                $results->free_result();
                            }
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
                                    <a href="form_cad_documento.php?pagina=1&pesquisa=1&cod_tipo=<?=$cod_tipo;?>&nom_documento=<?=$nom_documento;?>&dat_ano=<?=$dat_ano;?>&dat_documento=<?=$dat_documento;?>&cod_status=<?=$cod_status;?>&cod_uni_doc=<?=$cod_uni_doc;?>#pes" aria-label="Previous">
                                       <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php 
                                 for($i=1;$i<=$num_paginas;$i++) { 
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;   
                                ?> 
                                    <li <?=$estilo; ?>><a href="form_cad_documento.php?pagina=<?=$i;?>&pesquisa=1&cod_tipo=<?=$cod_tipo;?>&nom_documento=<?=$nom_documento;?>&dat_ano=<?=$dat_ano;?>&dat_documento=<?=$dat_documento;?>&cod_status=<?=$cod_status;?>&cod_uni_doc=<?=$cod_uni_doc;?>#pes"> <?=$i;?> </a></li><?php }

                                    ?>
                                    <li>
                                        <a href="form_cad_documento.php?pagina=<?=$num_paginas;?>&pesquisa=1&cod_tipo=<?=$cod_tipo;?>&nom_documento=<?=$nom_documento;?>&dat_ano=<?=$dat_ano;?>&dat_documento=<?=$dat_documento;?>&cod_status=<?=$cod_status;?>&cod_uni_doc=<?=$cod_uni_doc;?>#pes" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>
                
                        <div class="row"><span style="float:left;"><?php echo "Total de registros: ". $num_total." ";?>(a pesquisa retorna até <?php echo $total_registros; ?> registros)</span></div>
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
                                <th>Alterar</th>
                                <th>Excluir</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($records as $r){?>
                                <tr>
                                    <?php $cod_documento=$r->cod_documento;?>
                                    <td  width='5'><?php echo converteDataBR($r->dat_documento);?></td>
                                    <td  width='10%'><?php echo escape($r->nom_documento)."/".$r->dat_ano; ?></td>
                                    <td  width='20%'><?php echo escape($r->nom_tip_doc); ?></td>
                                    <td  width='20%'><?php echo escape($r->nom_status); ?></td>
                                    <td  width='20%'><?php echo escape($r->nom_uni_doc); ?></td>
                                    <td  width='5%'><?php if (!empty($r->cod_atendimento)) {echo "Sim";}?></td>
                                    <td  width='5%'><?php if ($r->dat_resposta!=NULL) echo "Sim"; else echo "Não";?></td>
                                    <td style='text-align:center;' width='5%'><a href="form_cad_documento.php?alt=1&cod_documento=<?php echo $cod_documento; ?>"><i class="fas fa-pencil-alt" style="font-size:20px; color:000000;"></i></a></td>
                                    <td style='text-align:center;' width='5%'><a href="action_cad_documento.php?del=1&cod_documento=<?php echo $cod_documento; ?>" onclick="return confirm('Confirma exclusão?');"><i class="fas fa-trash-alt" style="font-size:20px; color:000000;"></i></a></td>
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
                                <a href="form_cad_documento.php?pagina=1&pesquisa=1&cod_tipo=<?=$cod_tipo;?>&nom_documento=<?=$nom_documento;?>&dat_ano=<?=$dat_ano;?>&dat_documento=<?=$dat_documento;?>&cod_status=<?=$cod_status;?>&cod_uni_doc=<?=$cod_uni_doc;?>#pes" aria-label="Previous">
                                   <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php 
                             for($i=1;$i<=$num_paginas;$i++) { 
                                $estilo="";
                                if ($i==$pagina)
                                    $estilo="class=\"active\"" ;   
                                ?> 
                                <li <?php echo $estilo; ?>><a href="form_cad_documento.php?pagina=<?=$i;?>&pesquisa=1&cod_tipo=<?=$cod_tipo;?>&nom_documento=<?=$nom_documento;?>&dat_ano=<?=$dat_ano;?>&dat_documento=<?=$dat_documento;?>&cod_status=<?=$cod_status;?>&cod_uni_doc=<?=$cod_uni_doc;?>#pes"> <?php echo $i;?> </a></li><?php }

                                ?>
                                <li>
                                    <a href="form_cad_documento.php?pagina=<?=$num_paginas;?>&pesquisa=1&cod_tipo=<?=$cod_tipo;?>&nom_documento=<?=$nom_documento;?>&dat_ano=<?=$dat_ano;?>&dat_documento=<?=$dat_documento;?>&cod_status=<?=$cod_status;?>&cod_uni_doc=<?=$cod_uni_doc;?>#pes" aria-label="Next">
                                         <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                
                                </ul>
                                <a href="<?php echo$actual_link;?>" class="btn btn-default" style="margin-top: 18px;padding: 17px 20px;float: right;"><i class="fas fa-angle-double-up" title="Ir ao topo"></i></a>
                            
                                
                            </nav>
                    <?php
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