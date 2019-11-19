<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    
    session_start();
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
            
            function pesquisar() 
            {
                document.form.action = "form_pesquisar_atendimento.php?#pes";
                document.form.submit();
            }
            
            $(document).ready(function() {
                 $(".meuselect").select2();
            });
        </script>
    <body>
        <?php if (login_check($mysqli) == true){
                include 'includes/cabecalho.php';
        ?>
            <div class="container" id="main">

            <?php if (isset($_GET['msg'])){
                echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['msg'].'</strong></div>';                     
            }else if (isset($_GET['err'])){
                echo '<div class="alert alert-warning fade in "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['err'].'</strong></div>';
            }
            ?>
            <h1 class="h2">Relatório: Atendimentos</h1>

                <form  name="form" class="form-horizontal" type="post">
                   
                    <div class="form-group">
                        <label class="col-md-2 control-label" autocomplete="on">Pessoa:</label>  
                        <div class="col-md-5">
                            <input name="nom_nome" id="busca" type="text" placeholder="" class="form-control input-md" 
                                   value="<?php if (isset($_GET['pessoa'])) {echo $_GET['pessoa'];}?>">
                            <input type="hidden" id="cod_pessoa" name="cod_pessoa" value="<?php if (isset($_GET['cod_pessoa'])) {echo $_GET['cod_pessoa'];}?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                        <div class="col-md-5">
                            <?php
                                echo "<div>";
                                echo "<img id='div_foto'>";
                                echo "</div>";
                            ?>
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <label class="col-md-2 control-label">Estado:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT distinct nom_estado FROM gab_pessoa WHERE nom_estado is not null and ind_status ='A' order by nom_estado")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-3">
                                   <select class="meuselect" name="nom_estado">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['nom_estado'];?>"> 
                                               <?php echo $linha_set_gab['nom_estado'];?>
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
                                    <select class="form-control" name="nom_estado" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Estado cadastrado">
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-5">
                                   <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe estado cadastrado.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }?>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">Cidade:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT distinct nom_cidade FROM gab_pessoa WHERE nom_cidade is not null and ind_status ='A' order by nom_cidade")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-3">
                                   <select class="meuselect" name="nom_cidade">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['nom_cidade'];?>"> 
                                               <?php echo $linha_set_gab['nom_cidade'];?>
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
                                    <select class="form-control" name="nom_cidade" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Cidade cadastrada">
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-5">
                                   <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe cidade cadastrada.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }?>
                    </div>

                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Bairro:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT distinct nom_bairro FROM gab_pessoa WHERE nom_bairro is not null and ind_status ='A' order by nom_bairro")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-3">
                                   <select class="meuselect" name="nom_bairro">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['nom_bairro'];?>"> 
                                               <?php echo $linha_set_gab['nom_bairro'];?>
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
                                    <select class="form-control" name="nom_bairro" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Bairro cadastrado">
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-5">
                                   <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe Bairro cadastrado.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }?>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label" for="dataInicio">Data inicial:</label>  
                        <div class="col-md-2">
                            <input name="dataInicio"  type="text" class="form-control input-md datepicker" onblur="validaData(this)" value="<?php if (isset($_GET['dataInicio'])){if(strpos($_GET['dataInicio'], '/') === false) echo converteDataBR($_GET['dataInicio']);else echo $_GET['dataInicio'];}  ?>">
                        </div>
                        <label class="col-md-2 control-label" for="dataFim">Data final:</label>  
                        <div class="col-md-2">
                            <input  name="dataFim" type="text" class="form-control input-md datepicker" onblur="validaData(this)" value="<?php if (isset($_GET['dataFim'])){if(strpos($_GET['dataFim'], '/') === false) echo converteDataBR($_GET['dataFim']);else echo $_GET['dataFim'];} ?>">
                        </div>
                    </div>
                    <!--parei por aqui-->
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tipo de Atendimento:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT cod_tipo, nom_tipo FROM gab_tipo_atendimento WHERE ind_tipo ='A' order by nom_tipo")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-5">
                                   <select class="meuselect" name="cod_tipo">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['cod_tipo'];?>"> 
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
                                <div class="col-md-5">
                                    <select class="form-control" name="cod_tipo" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Tipo de Atendimento cadastrado"</option> 
                                   </select>
                                </div>
                                <div class="col-md-5">
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

                               <div class="col-md-5">
                                   <select class="meuselect" name="cod_status">
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['cod_status'];?>"> 
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
                                <div class="col-md-5">
                                    <select class="form-control" name="cod_status" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Situação de Atendimento cadastrada"</option> 
                                   </select>
                                </div>
                                <div class="col-md-5">
                                    <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe Situação de Atendimento cadastrada.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }
                        ?>
                    </div>
                    
                    <br>
                    <input type="hidden" name="all" value="1">
                    <input type="hidden" name="pesquisa" value="1">
                    <div class="form-group">
                        <div class="col-md-5 text-right">
                            <input type="button" id="pes" class="btn btn-default" value="Pesquisar" onclick="pesquisar();">
                            
                            <input type="button" class="btn btn-default" value="Limpar" onclick="window.location='form_pesquisar_atendimento.php';">
                            
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
                     
                            $select_rel="SELECT gab_atendimento.cod_atendimento, gab_tipo_atendimento.nom_tipo tipo, "
                            . "gab_atendimento.dat_atendimento data, gab_atendimento.txt_detalhes, gab_status_atendimento.nom_status status, "
                            . "gab_pessoa.nom_nome, gab_pessoa.ind_pessoa, gab_pessoa.nom_apelido, gab_pessoa.cod_cpf_cnpj, gab_pessoa.cod_rg, gab_pessoa.cod_ie, gab_pessoa.nom_bairro, gab_pessoa.nom_cidade, gab_pessoa.nom_estado, gab_pessoa.num_ddd_tel, gab_pessoa.num_tel, gab_pessoa.num_ddd_cel, gab_pessoa.num_cel "
                            . "FROM gab_atendimento "
                            . "LEFT JOIN gab_tipo_atendimento ON gab_tipo_atendimento.cod_tipo = gab_atendimento.GAB_TIPO_ATENDIMENTO_cod_tipo "
                            . "LEFT JOIN gab_pessoa ON gab_pessoa.cod_pessoa = gab_atendimento.GAB_PESSOA_cod_pessoa "
                            . "LEFT JOIN gab_status_atendimento ON gab_atendimento.GAB_STATUS_ATENDIMENTO_cod_status = gab_status_atendimento.cod_status "
                            . "WHERE gab_atendimento.ind_status='A' ";
                            
                                if (isset($_GET['nom_nome']) && !empty($_GET['nom_nome'])){
                                    $nom_nome=$_GET['nom_nome'];
                                    $select_rel.=" and gab_pessoa.nom_nome like '%$nom_nome%' ";
                                } else   
                                if (isset($_POST['nom_nome']) && !empty($_POST['nom_nome'])){
                                    $nom_nome=$_POST['nom_nome'];
                                    $select_rel.=" and gab_pessoa.nom_nome like '%$nom_nome%' ";
                                }else{$nom_nome="";}

                                if (isset($_GET['nom_bairro']) && !empty($_GET['nom_bairro'])){
                                    $nom_bairro=$_GET['nom_bairro'];
                                    $select_rel.=" and gab_pessoa.nom_bairro like '%$nom_bairro%' ";
                                } else   
                                if (isset($_POST['nom_bairro']) && !empty($_POST['nom_bairro'])){
                                    $nom_bairro=$_POST['nom_bairro'];
                                    $select_rel.=" and gab_pessoa.nom_bairro like '%$nom_bairro%' ";
                                }else{$nom_bairro="";}

                                if (isset($_GET['nom_cidade']) && !empty($_GET['nom_cidade'])){
                                    $nom_cidade=$_GET['nom_cidade'];
                                    $select_rel.=" and gab_pessoa.nom_cidade like '%$nom_cidade%' ";
                                } else   
                                if (isset($_POST['nom_cidade']) && !empty($_POST['nom_cidade'])){
                                    $nom_cidade=$_POST['nom_cidade'];
                                    $select_rel.=" and gab_pessoa.nom_cidade like '%$nom_cidade%' ";
                                }else{$nom_cidade="";}

                                if (isset($_GET['nom_estado']) && !empty($_GET['nom_estado'])){
                                    $nom_estado=$_GET['nom_estado'];
                                    $select_rel.=" and gab_pessoa.nom_estado like '%$nom_estado%' ";
                                } else   
                                if (isset($_POST['nom_estado']) && !empty($_POST['nom_estado'])){
                                    $nom_estado=$_POST['nom_estado'];
                                    $select_rel.=" and gab_pessoa.nom_estado like '%$nom_estado%' ";
                                }else{$nom_estado="";}

                                if (isset($_GET['cod_tipo']) and !empty ($_GET['cod_tipo']))
                                {
                                    $cod_tipo=$_GET['cod_tipo'];
                                    $select_rel.="AND gab_tipo_atendimento.cod_tipo=$cod_tipo ";
                                }else
                                if (isset($_POST['cod_tipo']) and !empty ($_POST['cod_tipo']))
                                {
                                    $cod_tipo=$_POST['cod_tipo'];
                                    $select_rel.="AND gab_tipo_atendimento.cod_tipo=$cod_tipo ";
                                }else{$cod_tipo="";}

                                if (isset($_GET['cod_status']) and !empty ($_GET['cod_status']))
                                {
                                    $cod_status=  $_GET['cod_status'];
                                    $select_rel.="AND gab_status_atendimento.cod_status=$cod_status ";
                                }else
                                if (isset($_POST['cod_status']) and !empty ($_POST['cod_status']))
                                {
                                    $cod_status=  $_POST['cod_status'];
                                    $select_rel.="AND gab_status_atendimento.cod_status=$cod_status ";
                                }else{$cod_status="";}
                                
                                //pesquisa por data
                                if (isset($_GET['dataInicio']) && !empty($_GET['dataInicio'])){
                                    $dataInicio=converte_data($_GET['dataInicio']);
                                    $select_rel.=" AND gab_atendimento.dat_atendimento >='$dataInicio'";
                                    $dataInicio=$_GET['dataInicio'];
                                }else
                                if (isset($_POST['dataInicio']) && !empty($_POST['dataInicio'])){
                                    $dataInicio=converte_data($_POST['dataInicio']);
                                    $select_rel.=" AND gab_atendimento.dat_atendimento >='$dataInicio'";
                                    $dataInicio=$_POST['dataInicio'];
                                }
                                else{$dataInicio="";}

                                if (isset($_GET['dataFim']) && !empty($_GET['dataFim'])){
                                    $dataFim=converte_data($_GET['dataFim']);
                                    $select_rel.=" AND gab_atendimento.dat_atendimento <='$dataFim'";
                                    $dataFim=$_GET['dataFim'];
                                }else
                                if (isset($_POST['dataFim']) && !empty($_POST['dataFim'])){
                                    $dataFim=converte_data($_POST['dataFim']);
                                    $select_rel.=" AND gab_atendimento.dat_atendimento <='$dataFim'";
                                    $dataFim=$_POST['dataFim'];
                                }
                                else{$dataFim="";}

                                if (isset($_GET['all'])){
                                    $all=1;
                                }else{
                                    $all="";
                                }
                                
                  

                                $_SESSION['sql']=$select_rel." order by gab_atendimento.dat_atendimento DESC LIMIT $limite";
                                
                                 $select_rel.=" order by gab_atendimento.dat_atendimento DESC LIMIT $aux,$itens_por_pag";
                                                     
                                
                                if ($results = $mysqli->query($select_rel))
                                {
                                    $num=$results->num_rows;


                                    $select_rel="SELECT gab_atendimento.cod_atendimento, gab_tipo_atendimento.nom_tipo tipo, "
                                    . "gab_atendimento.dat_atendimento data, gab_atendimento.txt_detalhes, gab_status_atendimento.nom_status status, "
                                    . "gab_pessoa.nom_nome, gab_pessoa.ind_pessoa, gab_pessoa.nom_apelido, gab_pessoa.cod_cpf_cnpj, gab_pessoa.cod_rg, gab_pessoa.cod_ie, gab_pessoa.nom_bairro, gab_pessoa.nom_cidade, gab_pessoa.nom_estado, gab_pessoa.num_ddd_tel, gab_pessoa.num_tel, gab_pessoa.num_ddd_cel, gab_pessoa.num_cel "
                                    . "FROM gab_atendimento "
                                    . "LEFT JOIN gab_tipo_atendimento ON gab_tipo_atendimento.cod_tipo = gab_atendimento.GAB_TIPO_ATENDIMENTO_cod_tipo "
                                    . "LEFT JOIN gab_pessoa ON gab_pessoa.cod_pessoa = gab_atendimento.GAB_PESSOA_cod_pessoa "
                                    . "LEFT JOIN gab_status_atendimento ON gab_atendimento.GAB_STATUS_ATENDIMENTO_cod_status = gab_status_atendimento.cod_status "
                                    . "WHERE gab_atendimento.ind_status='A' ";
                                    
                                    if (isset($_GET['nom_nome']) && !empty($_GET['nom_nome'])){
                                        $nom_nome=$_GET['nom_nome'];
                                        $select_rel.=" and gab_pessoa.nom_nome like '%$nom_nome%' ";
                                    } else
                                    if (isset($_POST['nom_nome']) && !empty($_POST['nom_nome'])){
                                        $nom_nome=$_POST['nom_nome'];
                                        $select_rel.=" and gab_pessoa.nom_nome like '%$nom_nome%' ";
                                    }else{$nom_nome="";}
                                    
                                    if (isset($_GET['nom_bairro']) && !empty($_GET['nom_bairro'])){
                                        $nom_bairro=$_GET['nom_bairro'];
                                        $select_rel.=" and gab_pessoa.nom_bairro like '%$nom_bairro%' ";
                                    } else   
                                    if (isset($_POST['nom_bairro']) && !empty($_POST['nom_bairro'])){
                                        $nom_bairro=$_POST['nom_bairro'];
                                        $select_rel.=" and gab_pessoa.nom_bairro like '%$nom_bairro%' ";
                                    }else{$nom_bairro="";}

                                    if (isset($_GET['nom_cidade']) && !empty($_GET['nom_cidade'])){
                                        $nom_cidade=$_GET['nom_cidade'];
                                        $select_rel.=" and gab_pessoa.nom_cidade like '%$nom_cidade%' ";
                                    } else   
                                    if (isset($_POST['nom_cidade']) && !empty($_POST['nom_cidade'])){
                                        $nom_cidade=$_POST['nom_cidade'];
                                        $select_rel.=" and gab_pessoa.nom_cidade like '%$nom_cidade%' ";
                                    }else{$nom_cidade="";}

                                    if (isset($_GET['nom_estado']) && !empty($_GET['nom_estado'])){
                                        $nom_estado=$_GET['nom_estado'];
                                        $select_rel.=" and gab_pessoa.nom_estado like '%$nom_estado%' ";
                                    } else   
                                    if (isset($_POST['nom_estado']) && !empty($_POST['nom_estado'])){
                                        $nom_estado=$_POST['nom_estado'];
                                        $select_rel.=" and gab_pessoa.nom_estado like '%$nom_estado%' ";
                                    }else{$nom_estado="";}

                                    if (isset($_GET['cod_tipo']) and !empty ($_GET['cod_tipo']))
                                    {
                                        $cod_tipo=$_GET['cod_tipo'];
                                        $select_rel.="AND gab_tipo_atendimento.cod_tipo=$cod_tipo ";
                                    }else
                                    if (isset($_POST['cod_tipo']) and !empty ($_POST['cod_tipo']))
                                    {
                                        $cod_tipo=$_POST['cod_tipo'];
                                        $select_rel.="AND gab_tipo_atendimento.cod_tipo=$cod_tipo ";
                                    }else{$cod_tipo="";}

                                    if (isset($_GET['cod_status']) and !empty ($_GET['cod_status']))
                                    {
                                        $cod_status=  $_GET['cod_status'];
                                        $select_rel.="AND gab_status_atendimento.cod_status=$cod_status ";
                                    }else
                                    if (isset($_POST['cod_status']) and !empty ($_POST['cod_status']))
                                    {
                                        $cod_status=  $_POST['cod_status'];
                                        $select_rel.="AND gab_status_atendimento.cod_status=$cod_status ";
                                    }else{$cod_status="";}
                                    
                                    //pesquisa por data
                                    if (isset($_GET['dataInicio']) && !empty($_GET['dataInicio'])){
                                        $dataInicio=converte_data($_GET['dataInicio']);
                                        $select_rel.=" AND gab_atendimento.dat_atendimento >='$dataInicio'";
                                        $dataInicio=$_GET['dataInicio'];
                                    }else
                                    if (isset($_POST['dataInicio']) && !empty($_POST['dataInicio'])){
                                        $dataInicio=converte_data($_POST['dataInicio']);
                                        $select_rel.=" AND gab_atendimento.dat_atendimento >='$dataInicio'";
                                        $dataInicio=$_POST['dataInicio'];
                                    }
                                    else{$dataInicio="";}
    
                                    if (isset($_GET['dataFim']) && !empty($_GET['dataFim'])){
                                        $dataFim=converte_data($_GET['dataFim']);
                                        $select_rel.=" AND gab_atendimento.dat_atendimento <='$dataFim'";
                                        $dataFim=$_GET['dataFim'];
                                    }else
                                    if (isset($_POST['dataFim']) && !empty($_POST['dataFim'])){
                                        $dataFim=converte_data($_POST['dataFim']);
                                        $select_rel.=" AND gab_atendimento.dat_atendimento <='$dataFim'";
                                        $dataFim=$_POST['dataFim'];
                                    }
                                    else{$dataFim="";}
    
                                    
                                    
                                    if (isset($_GET['all']))
                                        $all=1;
                                    else
                                        $all="";


                                    $num_total = $mysqli->query($_SESSION['sql'])->num_rows;
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
                                    <a href="form_pesquisar_atendimento.php?pagina=1&pesquisa=1&nom_nome=<?php echo $nom_nome;?>&cod_tipo=<?php echo $cod_tipo; ?>&cod_status=<?php echo $cod_status;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&all=<?php echo $all;?>#pes" aria-label="Previous">
                                       <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php 
                                 for($i=1;$i<=$num_paginas;$i++) { 
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;   
                                    ?> 
                                    <li <?php echo $estilo; ?>><a href="form_pesquisar_atendimento.php?pagina=<?php echo $i; ?>&pesquisa=1&nom_nome=<?php echo $nom_nome;?>&cod_tipo=<?php echo $cod_tipo; ?>&cod_status=<?php echo $cod_status;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&all=<?php echo $all;?>#pes"> <?php echo $i;?> </a></li><?php }

                                    ?>
                                    <li>
                                        <a href="form_pesquisar_atendimento.php?pagina=<?php echo $num_paginas; ?>&pesquisa=1&nom_nome=<?php echo $nom_nome;?>&cod_tipo=<?php echo $cod_tipo; ?>&cod_status=<?php echo $cod_status;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&all=<?php echo $all;?>#pes" aria-label="Next">
                                             <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                            </ul>                           
                        </nav>
                        
                        <div class="row">
                        <div><span style="float:left;"><?php echo "Total de registros: ". $num_total." ";?>(a pesquisa retorna até <?php echo $limite; ?> registros)</span></div>
                        <div style="float:right;">
                            <a align="right" href="form_pesquisar_atendimento_xlsx.php" title="Gerar relatório Excel"><i class="far fa-file-excel fa-3x" title="Gerar relatório Excel"></i></a>  
                            <a target="_blank" href="form_pesquisar_atendimento_pdf.php" title="Gerar relatório PDF"><i class="far fa-file-pdf fa-3x" title="Gerar relatório PDF"></i></a>
                        </div>
                        </div>
                        <div class="table-of row">
                        <table id="example" class="mtab table table-striped table-hover table-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Pessoa</th>
								<th>Telefone/<br>Celular</th>
                                <th>Localização</th>
                                <th>Tipo</th>
                                <th>Situação</th>
								<th>Detalhes</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($records as $r){?>
                                <tr>
                                    <?php $cod_atendimento=$r->cod_atendimento;?>
                                    
                                        <td  width='5%'><?php echo converteDataBR($r->data);?></td>
                                        <td  width='25%'>
										<?php if ($r->nom_apelido!=NULL) echo escape($r->nom_nome." \"".$r->nom_apelido."\""); 
											  else echo escape($r->nom_nome) ; 
															   
											if ($r->ind_pessoa == "PF" && !empty($r->cod_cpf_cnpj)){ echo "<br><b> CPF:</b>".escape($r->cod_cpf_cnpj); }
											if ($r->ind_pessoa == "PF" && !empty($r->cod_rg)){ echo "<br><b> RG:</b>".escape($r->cod_rg); }
											if ($r->ind_pessoa == "PJ" && !empty($r->cod_cpf_cnpj)){ echo "<br><b> CNPJ:</b>".escape($r->cod_cpf_cnpj); }
											if ($r->ind_pessoa == "PJ" && !empty($r->cod_ie)){ echo "<br><b> IE:</b>".escape($r->cod_ie); }
										?>
										</td>
										
										<?php
                                        //acrescenta () no ddd do telefone
                                        $num_ddd_tel = $r->num_ddd_tel;
                                        $num_ddd_tel = preg_replace ('/([0-9]{2})/',"($1)",$num_ddd_tel);
                                        //acrescenta - no meio do numero do telefone
                                        $num_tel = $r->num_tel;
                                        if (strlen($num_tel) == 8){
                                        $num_tel= preg_replace('/([0-9]{4})([0-9]{4})/',"$1-$2",$num_tel);
                                        }
                                        //acrescenta () no ddd do celular
                                        $num_ddd_cel = $r->num_ddd_cel;
                                        $num_ddd_cel = preg_replace ('/([0-9]{2})/',"($1)",$num_ddd_cel);
                                        //acrescenta - no meio do numero do telefone
                                        $num_cel = $r->num_cel;
                                        if (strlen($num_cel) == 9){
                                        $num_cel= preg_replace('/([0-9]{5})([0-9]{4})/',"$1-$2",$num_cel);
                                        }
										?>
										
										<td  width='12%'><?php echo escape($num_ddd_tel)." ".escape($num_tel);?><br><?php echo escape($num_ddd_cel)." ".escape($num_cel);?></td>
										
                                        <td  width='15%'><?php echo $r->nom_bairro;
															   if ($r->nom_cidade!=NULL && $r->nom_estado!=NULL) echo "<br>".$r->nom_cidade."/".$r->nom_estado;
															   else if ($r->nom_cidade!=NULL) echo "<br>".$r->nom_cidade;
															   else if ($r->nom_estado!=NULL) echo "<br>".$r->nom_estado;?>
										</td>
                                        <td  width='8%'><?php echo $r->tipo;?></td>
                                        <td  width='8%'><?php echo $r->status;?></td>
										<td  width='27%'><?php if ($r->txt_detalhes!=NULL){ 
																if (strlen($r->txt_detalhes)>150) $str_continua="..."; else $str_continua="";
																echo escape(substr($r->txt_detalhes, 0, 150)).$str_continua;
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
                                    <a href="form_pesquisar_atendimento.php?pagina=1&pesquisa=1&nom_nome=<?php echo $nom_nome;?>&cod_tipo=<?php echo $cod_tipo; ?>&cod_status=<?php echo $cod_status;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&all=<?php echo $all;?>#pes" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php 
                                for($i=1;$i<=$num_paginas;$i++) { 
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;   
                                    ?> 
                                    <li <?php echo $estilo; ?>><a href="form_pesquisar_atendimento.php?pagina=<?php echo $i; ?>&pesquisa=1&nom_nome=<?php echo $nom_nome;?>&cod_tipo=<?php echo $cod_tipo; ?>&cod_status=<?php echo $cod_status;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&all=<?php echo $all;?>#pes"> <?php echo $i;?> </a></li><?php }

                                    ?>
                                    <li>
                                        <a href="form_pesquisar_atendimento.php?pagina=<?php echo $num_paginas; ?>&pesquisa=1&nom_nome=<?php echo $nom_nome;?>&cod_tipo=<?php echo $cod_tipo; ?>&cod_status=<?php echo $cod_status;?>&dataInicio=<?php echo $dataInicio;?>&dataFim=<?php echo $dataFim;?>&all=<?php echo $all;?>#pes" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                
                            </ul>
                            <a href="<?php echo$actual_link;?>" class="btn btn-default" style="margin-top: 18px;padding: 17px 20px;float: right;" title="Ir ao topo"><i class="fas fa-angle-double-up"></i></a>
                            
                        </nav>
            <?php
                    }
                }else{
                    echo"";
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
                                        
                                        if (code[3] =='PF'){ //ind_pessoa = PESSOA FÍSICA
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
                                        }
                                        
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