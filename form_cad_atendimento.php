<?php
    include_once 'includes/conexao.php';
    
    include_once 'includes/functions.php';
    
    session_start(); 

    if (isset($_POST['nom_nome']))
    {
      $_SESSION['nom_nome'] = $_POST['nom_nome'];
    }
    else if (!isset($_SESSION['nom_nome']))
    {
        $_SESSION['nom_nome'] = "";
    }
    if (isset($_POST['dat_atendimento']))
    {   
        $_SESSION['dat_atendimento'] = $_POST['dat_atendimento'];
    }
    else if (!isset($_SESSION['dat_atendimento']))
    {
        $_SESSION['dat_atendimento'] = "";
    }
    if (isset($_POST['cod_tipo']))
    {   
        $_SESSION['cod_tipo'] = $_POST['cod_tipo'];
    }
    else if (!isset($_SESSION['cod_tipo']))
    {
        $_SESSION['cod_tipo'] = "";
    }
    if (isset($_POST['cod_status']))
    {
        $_SESSION['cod_status'] = $_POST['cod_status'];
    }
    else if (!isset($_SESSION['cod_status']))
    {
        $_SESSION['cod_status'] = "";
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
        <script src="js/jquery-1.10.2.min.js"></script>	
        <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="js/jquery-1.12.4.js"></script>
        <script src="js/jquery-ui-1.12.0.js"></script>
        <script src="js/jquery.maskedinput.js"></script>
        <script src="js/functions.js"></script>
        <!--bibliotecas para select pesquisavel -->
        <link href="css/select2.min.css" rel="stylesheet" />
        <script src="js/select2.min.js"></script>
        <script>
            function checarCampos(){
                var sala=document.form.nom_nome.value;
                var aux=document.form.cod_pessoa.value;
                if (sala=="")
                {
                    alert("Selecione o setor");
                    return false;
                }
                if (aux=="")
                {
                    alert("Selecione o munícipe");
                    return false;
                }
                else {
                    return true;
                }
            }
            
            function pesquisar(){
                 <?php 
                 if (isset ($_GET['mod'])){?>
                    document.form.action = "form_cad_atendimento.php?pesquisa=1&mod=1#pes";
                 <?php
                 }
                 else {?>
                    document.form.action = "form_cad_atendimento.php?pagina=1&pesquisa=1#pes";
                 <?php
                 }?>
                document.form.submit();

            }

            function voltarPagina()
            {
                window.location.href = "form_cad_atendimento.php?pagina=<?=$_SESSION['pagina'];?>&pesquisa=1&nom_nome=<?=$_SESSION['nom_nome'];?>&dat_atendimento=<?=$_SESSION['dat_atendimento'];?>&cod_tipo=<?=$_SESSION['cod_tipo'];?>&cod_status=<?=$_SESSION['cod_status'];?>#pes"; 
            }

            $(document).ready(function() {
                 $(".meuselect").select2();
            });
        </script>
    <body>
        <?php if (login_check($mysqli) == true) 
            {
                if (isset ($_GET['mod'])){
                   echo"";
                }else{
                     include 'includes/cabecalho.php';
                }
                if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_atendimento'])){
                    $cod_atendimento = $_GET['cod_atendimento'];
                    if ($resultado=$mysqli->query("SELECT gab_atendimento.cod_atendimento cod_atendimento, gab_atendimento.GAB_TIPO_ATENDIMENTO_cod_tipo cod_tipo, "
                            . "gab_tipo_atendimento.nom_tipo tipo, gab_atendimento.dat_atendimento data, gab_pessoa.nom_nome pessoa, gab_atendimento.txt_detalhes detalhes, "
                            . "gab_atendimento.GAB_PESSOA_cod_pessoa cod_pessoa, gab_atendimento.GAB_STATUS_ATENDIMENTO_cod_status cod_status "
                            . "FROM gab_atendimento "
                            . "LEFT JOIN gab_tipo_atendimento ON gab_tipo_atendimento.cod_tipo = gab_atendimento.GAB_TIPO_ATENDIMENTO_cod_tipo "
                            . "LEFT JOIN gab_pessoa ON gab_pessoa.cod_pessoa = gab_atendimento.GAB_PESSOA_cod_pessoa "
                            . "LEFT JOIN gab_status_atendimento ON gab_status_atendimento.cod_status = gab_atendimento.GAB_STATUS_ATENDIMENTO_cod_status "
                            . "WHERE cod_atendimento='$cod_atendimento' ")){
                        if ($resultado->num_rows){
                            $linha=$resultado->fetch_object();
                        }
                    }
                }
                
        ?>
            <div class="container" id="main">
                    
                <?php if (isset($_GET['msg']))
                {
                    echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['msg'].'</strong></div>';                     
                }
                else if (isset($_GET['err']))
                {
                    echo '<div class="alert alert-warning fade in "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['err'].'</strong></div>';
                }
                ?>
                <h1 class="h2">Cadastro de Atendimento</h1>

                <form  if="myForm" name="form" class="form-horizontal" action="action_cad_atendimento.php" method="post" onsubmit="return checarCampos()">
                    
                    <?php
                    if (isset ($_GET['mod'])){
                        echo "<div><span style='float:left; font-weight: bold; color: red; width:100%; height:30px;'>Favor realizar a pesquisa e clicar no Atendimento desejado.</span></div>";
                    }?>

                    
                    <?php 
                        if (isset ($_GET['mod'])){
                            echo "<input type='hidden' name='mod' value='1'>";
                        }
                        if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_atendimento']))
                        {
                            echo "<input type='hidden' name='alt' id='alt'>";
                            echo "<input type='hidden' name='cod_atendimento' value=".$_GET['cod_atendimento'].">";
                        }
                    ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label" autocomplete="on">Pessoa:</label>  
                        <div class="col-md-8">
                            <input name="nom_nome" id="busca" type="text" placeholder="" class="form-control input-md" required
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_atendimento'])) {echo $linha->pessoa;} elseif (!empty($_SESSION['nom_nome']) && isset($_GET['pesquisa'])) {echo $_SESSION['nom_nome']; }?>">
                            <input type="hidden" id="cod_pessoa" name="cod_pessoa" value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_atendimento'])) {echo $linha->cod_pessoa;}?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                        <div class="col-md-8">
                            <?php
                                echo "<div>";
                                echo "<img id='div_foto'>";
                                echo "</div>";
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label" autocomplete="on">Data:</label>  
                        <div class="col-md-3">
                            <input name="dat_atendimento" id="data" type="text" placeholder="" class="form-control input-md datepicker" onblur="validaData(this)" required
                                value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_atendimento'])) {echo escape(converteDataBR($linha->data));} elseif (!empty($_SESSION['dat_atendimento']) && isset($_GET['pesquisa'])) {echo $_SESSION['dat_atendimento']; } /*else echo date("d/m/Y");*/?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tipo de Atendimento:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT cod_tipo, nom_tipo FROM gab_tipo_atendimento WHERE ind_tipo ='A' order by nom_tipo")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-8">
                                   <select class="meuselect" name="cod_tipo">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['cod_tipo'];?>"
                                           <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_atendimento'])){
                                            if (($linha->cod_tipo==$linha_set_gab['cod_tipo'])){echo "selected";}}
                                           elseif (!empty($_SESSION['cod_tipo']) && isset($_GET['pesquisa'])){
                                            if (($_SESSION['cod_tipo']==$linha_set_gab['cod_tipo'])){echo "selected";}}
                                        ?>> 
                                               <?php echo $linha_set_gab['nom_tipo'];?>
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
                                    <select class="form-control" name="cod_tipo" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Tipo de Atendimento cadastrado">
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-4">
                                    <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe Tipo de Atendimento cadastrado.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Situação:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT cod_status, nom_status FROM gab_status_atendimento WHERE ind_status='A' order by nom_status")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-8">
                                   <select class="meuselect" name="cod_status">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['cod_status'];?>"
                                           <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_atendimento'])){
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
                                <div class="col-md-4">
                                    <select class="form-control" name="cod_status" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Situação de Atendimento cadastrada">
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-4">
                                    <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe Situação de Atendimento cadastrada.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }
                        ?>
                    </div>
                    <?php if (isset ($_GET['mod'])){ 
                        echo""; 
                        
                        }else{?>
                            
                    <div class="form-group">
                        <label for="observ" class="col-md-2 control-label">Detalhes:</label>
                        <div class="col-md-8">
                            <textarea name="txt_detalhes" class="form-control" id="observ" rows="10" autocomplete="off"><?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_atendimento'])) {echo trim($linha->detalhes);}?></textarea>
                        </div>
                    </div>
                    <?php
                    } ?>
                    <br>
                    <div class="form-group">
                        <div class="col-md-5 text-right">
                            <input type="submit" <?php if($cond) { echo "disabled";}?> class="btn btn-default" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_atendimento'])) { echo "value='Alterar'";} else{ echo"value='Cadastrar'";}?>>
                            <input type="button" class="btn btn-default" value="Limpar" onclick="window.location='form_cad_atendimento.php';"> 
                            <input type="button" id="pes" class="btn btn-default" value="Pesquisar" onclick="pesquisar();">
                            <input type="button" id="voltar" class="btn btn-default" value="Voltar" onclick="voltarPagina();" <?php if (isset($_GET['mod']) || !isset($_GET['pesquisa']) && !isset($_GET['alt'])){ echo "style='visibility:hidden;'";} else { echo "style='visibility:block;'";}?>	 >
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
                            $sql="SELECT gab_atendimento.cod_atendimento, gab_tipo_atendimento.nom_tipo tipo, "
                            . "gab_atendimento.dat_atendimento data, gab_status_atendimento.nom_status status, "
                            . "gab_pessoa.nom_nome, gab_pessoa.ind_pessoa, gab_pessoa.nom_apelido, gab_pessoa.cod_cpf_cnpj, gab_pessoa.cod_rg, gab_pessoa.cod_ie "
                            . "FROM gab_atendimento "
                            . "LEFT JOIN gab_tipo_atendimento ON gab_tipo_atendimento.cod_tipo = gab_atendimento.GAB_TIPO_ATENDIMENTO_cod_tipo "
                            . "LEFT JOIN gab_pessoa ON gab_pessoa.cod_pessoa = gab_atendimento.GAB_PESSOA_cod_pessoa "
                            . "LEFT JOIN gab_status_atendimento ON gab_atendimento.GAB_STATUS_ATENDIMENTO_cod_status = gab_status_atendimento.cod_status "
                            . "WHERE gab_atendimento.ind_status='A' ";
                            
                                if (isset($_POST['nom_nome']) && !empty($_POST['nom_nome'])){
                                    $nom_nome=$_POST['nom_nome'];
                                    $sql.=" and gab_pessoa.nom_nome like '%$nom_nome%' ";
                                }
                                else if (isset($_GET['nom_nome']) && !empty($_GET['nom_nome'])){
                                    $nom_nome=$_GET['nom_nome'];
                                    $sql.=" and gab_pessoa.nom_nome like '%$nom_nome%' ";
                                }
                                else
                                {
                                    $nom_nome="";
                                }
                                if (isset($_POST['dat_atendimento']) and !empty ($_POST['dat_atendimento']))
                                {
                                    $dat_atendimento=  converte_data($_POST['dat_atendimento']);
                                    $sql.="AND gab_atendimento.dat_atendimento='$dat_atendimento' ";
                                } else
                                if (isset($_GET['dat_atendimento']) and !empty ($_GET['dat_atendimento']))
                                {
                                    $dat_atendimento=  converte_data($_GET['dat_atendimento']);
                                    $sql.="AND gab_atendimento.dat_atendimento='$dat_atendimento' ";
                                }
                                else
                                {
                                    $dat_atendimento = "";
                                }
                                if (isset($_POST['cod_tipo']) and !empty ($_POST['cod_tipo']))
                                {
                                    $cod_tipo=$_POST['cod_tipo'];
                                    $sql.="AND gab_tipo_atendimento.cod_tipo=$cod_tipo ";
                                } else
                                if (isset($_GET['cod_tipo']) and !empty ($_GET['cod_tipo']))
                                {
                                    $cod_tipo=$_GET['cod_tipo'];
                                    $sql.="AND gab_tipo_atendimento.cod_tipo=$cod_tipo ";
                                }
                                else
                                {
                                    $cod_tipo = "";
                                }
                                if (isset($_POST['cod_status']) and !empty ($_POST['cod_status']))
                                {
                                    $cod_status=  $_POST['cod_status'];
                                    $sql.="AND gab_status_atendimento.cod_status=$cod_status ";
                                } else
                                if (isset($_GET['cod_status']) and !empty ($_GET['cod_status']))
                                {
                                    $cod_status=  $_GET['cod_status'];
                                    $sql.="AND gab_status_atendimento.cod_status=$cod_status ";
                                }
                                else
                                {
                                    $cod_status = "";
                                }

                                if ($results = $mysqli->query($sql."ORDER BY gab_atendimento.dat_atendimento DESC, gab_pessoa.nom_nome ASC LIMIT $aux, $itens_por_pag"))
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
                        <?php if (isset($_GET['mod'])){?>
                            <ul class="pagination">
                                <li>
                                    <a href="form_cad_atendimento.php?pagina=1&mod=1#pes" aria-label="Previous">
                                       <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php 
                                 for($i=1;$i<=$num_paginas;$i++) { 
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;   
                                    ?> 
                                    <li <?php echo $estilo; ?>><a href="form_cad_atendimento.php?pagina=<?php echo $i; ?>&mod=1#pes"> <?php echo $i;?> </a></li><?php }

                                    ?>
                                    <li>
                                        <a href="form_cad_atendimento.php?pagina=<?php echo $num_paginas; ?>&mod=1#pes" aria-label="Next">
                                             <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        <?php }else{?>
                            <ul class="pagination">
                                <li>
                                    <a href="form_cad_atendimento.php?pagina=1&pesquisa=1&nom_nome=<?=$nom_nome;?>&dat_atendimento=<?=$dat_atendimento;?>&cod_tipo=<?=$cod_tipo;?>&cod_status=<?=$cod_status?>#pes" aria-label="Previous">
                                       <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php 
                                 for($i=1;$i<=$num_paginas;$i++) { 
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;   
                                    ?> 
                                    <li <?php echo $estilo; ?>><a href="form_cad_atendimento.php?pagina=<?=$i;?>&pesquisa=1&nom_nome=<?=$nom_nome;?>&dat_atendimento=<?=$dat_atendimento;?>&cod_tipo=<?=$cod_tipo;?>&cod_status=<?=$cod_status?>#pes"> <?php echo $i;?> </a></li><?php }

                                    ?>
                                    <li>
                                        <a href="form_cad_atendimento.php?pagina=<?php echo $num_paginas; ?>&pesquisa=1&nom_nome=<?=$nom_nome;?>&dat_atendimento=<?=$dat_atendimento;?>&cod_tipo=<?=$cod_tipo;?>&cod_status=<?=$cod_status?>#pes" aria-label="Next">
                                             <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        <?php }?>                            
                        </nav>
                        
                        <div class="row"><p style="float:left;"><?php echo "Total de registros: ". $num_total." ";?>(a pesquisa retorna até <?php echo $total_registros; ?> registros)</p></div>
                    <div class="table-of row">
                        <table id="example" class="mtab table table-striped table-hover table-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Pessoa</th>
                                <th>Doc. Identificação</th>
                                <th>Tipo</th>
                                <th>Situação</th>
                                <?php if (!isset ($_GET['mod'])){?> 
                                <th></th>
                                <th>Alterar</th>
                                <th>Excluir</th>
                                <?php }?>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($records as $r){?>
                                <tr>
                                    <?php $cod_atendimento=$r->cod_atendimento;?>
                                    <?php if (isset($_GET['mod'])){?>
                                    
                                        <td  width='5%'><a href="action_cad_atendimento.php?mod=1&cod_atendimento=<?php echo $cod_atendimento;?>"><?php echo converteDataBR($r->data);?></a></td>
                                        <td  width='25%'><a href="action_cad_atendimento.php?mod=1&cod_atendimento=<?php echo $cod_atendimento;?>"><?php if ($r->nom_apelido!=NULL) echo escape($r->nom_nome." \"".$r->nom_apelido."\""); else echo escape($r->nom_nome);?></a></td>
                                        <td  width='25%'><a href="action_cad_atendimento.php?mod=1&cod_atendimento=<?php echo $cod_atendimento;?>">
                                            <?php if($r->ind_pessoa == "PF" && !empty($r->cod_rg)){ echo "<b> RG:</b>".escape($r->cod_rg); }
                                                  if ($r->ind_pessoa == "PF" && !empty($r->cod_cpf_cnpj)){ echo "<b> CPF:</b>".escape($r->cod_cpf_cnpj); }
                                                  if ($r->ind_pessoa == "PJ" && !empty($r->cod_cpf_cnpj)){ echo "<b> CNPJ:</b>".escape($r->cod_cpf_cnpj); }
                                                  if ($r->ind_pessoa == "PJ" && !empty($r->cod_ie)){ echo "<b> IE:</b>".escape($r->cod_ie); }
                                            ?>
                                            </a>
                                        </td>
                                        
                                        <td  width='15%'><a href="action_cad_atendimento.php?mod=1&cod_atendimento=<?=$cod_atendimento;?>"><?php echo $r->tipo;?></a></td>
                                        <td  width='15%'><a href="action_cad_atendimento.php?mod=1&cod_atendimento=<?=$cod_atendimento;?>"><?php echo $r->status;?></a></td>
                                    <?php }
                                    else{?>
                                        <td  width='5%'><?php echo converteDataBR($r->data);?></td> 
                                        <td  width='30%'><?php if ($r->nom_apelido!=NULL) echo escape($r->nom_nome." \"".$r->nom_apelido."\""); else echo escape($r->nom_nome) ; ?></td>
                                        <td  width='20%'>
                                            <?php if ($r->ind_pessoa == "PF" && !empty($r->cod_cpf_cnpj)){ echo "<p><b> CPF:</b>".escape($r->cod_cpf_cnpj)."</p>";}
                                                if ($r->ind_pessoa == "PF" && !empty($r->cod_rg)){ echo "<p><b> RG:</b>".escape($r->cod_rg)."</p>";}
                                                if ($r->ind_pessoa == "PJ" && !empty($r->cod_cpf_cnpj)){ echo "<p><b> CNPJ:</b>".escape($r->cod_cpf_cnpj)."</p>";}
                                                if ($r->ind_pessoa == "PJ" && !empty($r->cod_ie)){ echo "<b> IE:</b>".escape($r->cod_ie)."</p>";}
                                            ?>
                                        </td>
                                        <td  width='15%'><?php echo $r->tipo;?></td>
                                        <td  width='15%'><?php echo $r->status;?></td>
                                        <td  width='5%' class="text-center"><a target="_blank" href="form_cad_atendimento_protocolo_pdf.php?cod_atendimento=<?php echo $cod_atendimento; ?>"><i class="fas fa-file-alt" style="font-size:20px; color:000000;" title="Gerar Relatório do Atendimento"></i></a></td>                                        
                                        <td style="text-align:center;"   width='5%'><a href="form_cad_atendimento.php?alt=1&cod_atendimento=<?php echo $cod_atendimento; ?>"><i class="fas fa-pencil-alt" style="font-size:20px; color:000000;"></i></a></td>
                                        <td style="text-align:center;"  width='5%'><a href="action_cad_atendimento.php?del=1&cod_atendimento=<?php echo $cod_atendimento; ?>" onclick="return confirm('Confirma exclusão?');"><i class="fas fa-trash-alt" style="font-size:20px; color:000000;"></i></a></td>
                                    <?php }?>
                                    
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        </div>
                        <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . "#pes";?>
                        <nav aria-label="Page navigation">
                        <?php if (isset($_GET['mod'])){?>
                            <ul class="pagination">
                                <li>
                                    <a href="form_cad_atendimento.php?pagina=1&mod=1#pes" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php 
                                for($i=1;$i<=$num_paginas;$i++) { 
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;   
                                    ?> 
                                    <li <?php echo $estilo; ?>><a href="form_cad_atendimento.php?pagina=<?=$i; ?>&mod=1#pes"> <?php echo $i;?> </a></li><?php }

                                    ?>
                                    <li>
                                        <a href="form_cad_atendimento.php?pagina=<?=$num_paginas; ?>&mod=1#pes" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    
                            </ul>
                            <a href="<?php echo$actual_link;?>" class="btn btn-default" style="margin-top: 18px;padding: 17px 20px;float: right;"><i class="fas fa-angle-double-up"></i></a>
                            
                            <hr>
                        <?php }else{ ?>
                            <ul class="pagination">
                                <li>
                                    <a href="form_cad_atendimento.php?pagina=1&pesquisa=1&nom_nome=<?=$nom_nome;?>&dat_atendimento=<?=$dat_atendimento;?>&cod_tipo=<?=$cod_tipo;?>&cod_status=<?=$cod_status?>#pes" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php 
                                for($i=1;$i<=$num_paginas;$i++) { 
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;   
                                    ?> 
                                    <li <?php echo $estilo; ?>><a href="form_cad_atendimento.php?pagina=<?=$i;?>&pesquisa=1&nom_nome=<?=$nom_nome;?>&dat_atendimento=<?=$dat_atendimento;?>&cod_tipo=<?=$cod_tipo;?>&cod_status=<?=$cod_status?>#pes"> <?=$i;?> </a></li><?php }

                                    ?>
                                    <li>
                                        <a href="form_cad_atendimento.php?pagina=<?=$num_paginas;?>&pesquisa=1&nom_nome=<?=$nom_nome;?>&dat_atendimento=<?=$dat_atendimento;?>&cod_tipo=<?=$cod_tipo;?>&cod_status=<?=$cod_status?>#pes" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    
                            </ul>
                            <a href="<?=$actual_link;?>" class="btn btn-default" style="margin-top: 18px;padding: 17px 20px;float: right;"><i class="fas fa-angle-double-up" title="Ir ao topo"></i></a>
                            
                           
                        <?php }?>
                        </nav>
            <?php
                    }
            ?>
            </div>
        <script>
            $('#busca').on('input', limpaCampos);

            $('#busca').autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url : 'form_busca_pessoa.php',
                        dataType: "json",
                        data: {
                            name_startsWith: request.term,
                            type: 'country_table',
                            row_num : 1
                         },
                        success: function( data ) {
                            response( $.map( data, function( item ) {
                                var code = item.split("|");

                                if (code[3] === 'PF'){ //ind_pessoa = PESSOA FÍSICA
                                    //alert('PF');
                                    texto=code[0]+" - CPF:"+code[1]+" - RG:"+code[4];
                                } 
                                else{//ind_pessoa = PESSOA JURÍDICA
                                    //alert('PJ');
                                    texto=code[0]+" - CNPJ:"+code[1]+" - IE:"+code[5];
                                }
                                return {
                                    label: texto,
                                    value: code[0],
                                    data : item
                                };
                           }));
                        }
                    });
                },
                autoFocus: true,	      	
                minLength: 2,
                select: function( event, ui ) {
                    var names = ui.item.data.split("|");
                    console.log(names[2]);						
                    $('#cod_pessoa').val(names[2]);

                    document.getElementById("div_foto").width="160";
                    document.getElementById("div_foto").height="120";
                    document.getElementById("div_foto").src ="fotos/"+names[2]+ ".jpg?"+ new Date().getTime();
                }
            });
            function limpaCampos(){
                   var busca = $('#busca').val();

                   if(busca == ""){
                       $('#cod_pessoa').val('');
                       
                       document.getElementById("div_foto").width="1";
                       document.getElementById("div_foto").height="1";
                       document.getElementById("div_foto").src ="";
                   }
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