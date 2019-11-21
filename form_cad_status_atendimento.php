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
        </head>
    
    <body>
        <?php if (login_check($mysqli) == true) 
            {
                include 'includes/cabecalho.php';
                if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_status'])){
                    $cod_status = $_GET['cod_status'];
                    if ($resultado=$mysqli->query("SELECT cod_status, nom_status, ind_status FROM gab_status_atendimento WHERE cod_status='$cod_status'")){
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
                <h1 class="h2">Cadastro de Situação do Atendimento</h1>

                <form  name="form" class="form-horizontal" action="action_cad_status_atendimento.php" method="post">
                    
                    <?php 
                        if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_status']))
                        {
                            echo "<input type='hidden' name='alt' id='alt'>";
                            echo "<input type='hidden' name='cod_status' value=".$_GET['cod_status'].">";
                        }
                    ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label" autocomplete="on">Situação Atendimento:</label>
                        <div class="col-md-8">
                            <input name="nom_status" type="text" placeholder="" class="form-control input-md" required
                                value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_status'])) {echo escape($linha->nom_status);}?>">
                        </div>
                    </div>
                    <?php
                        if(isset($_GET['alt']))
                        {
                    ?>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="radios">Status:</label>
                            <div class="col-md-8">
                                <div class="radio">
                                    <label for="ativo">
                                        <input type="radio" name="ind_status" id="ativo" value="A" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_status'])) {echo $linha->ind_status == 'A' ? "checked" : null;}?>>
                                        Ativo&nbsp&nbsp&nbsp
                                    </label>
                                    <label for="inativo">
                                        <input type="radio" name="ind_status" id="inativo" value="I" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_status'])) {echo $linha->ind_status == 'I' ? "checked" : null;}?>>
                                        Inativo
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                    <div class="form-group">
                        <div class="col-md-4 text-right">
                            <input type="submit" class="btn btn-default" value="Cadastrar">
                            <input type="reset" class="btn btn-default" value="Limpar">
                        </div>
                    </div>
                </form>
                <?php
                    $itens_por_pag = 10;
                    if(isset($_GET['pagina'])){$pagina = intval($_GET['pagina']);}else {$pagina=1;}
                    $aux=$pagina*10-10;
                    
                    
                    $records=array();
                    if ($results = $mysqli->query("SELECT cod_status, nom_status, ind_status FROM gab_status_atendimento ORDER BY nom_status ASC LIMIT $aux, $itens_por_pag "))
                    {
                        
                        $num=$results->num_rows;
                        $num_total = $mysqli->query("SELECT cod_status, nom_status, ind_status FROM gab_status_atendimento")->num_rows;
                    
                        $num_paginas=  ceil($num_total/$itens_por_pag);
                        
                        if ($results->num_rows){
                            while($row = $results->fetch_object()){
                                $records[]=$row;
                            }
                            $results->free_result();
                        }
                    }
                ?>
                <?php 
                    if (count($records)){?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li>
                                    <a href="form_cad_status_atendimento.php?pagina=1" aria-label="Previous">
                                       <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php 
                                 for($i=1;$i<=$num_paginas;$i++) { 
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;   
                                    ?> 
                                        <li <?php echo $estilo; ?>><a href="form_cad_status_atendimento.php?pagina=<?php echo $i; ?>"> <?php echo $i;?> </a></li><?php }

                                    ?>
                                    <li>
                                        <a href="form_cad_status_atendimento.php?pagina=<?php echo $num_paginas; ?>" aria-label="Next">
                                             <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>
                        <div class="table-of row">
                        <table id="example" class="mtab table table-striped table-hover table-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Situação do Atendimento</th>
                                <th>Status</th>
                                <th>Alterar</th>
                                <th>Excluir</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($records as $r){?>
                                <tr>
                                    <td  width='60%'><?php echo escape($r->nom_status); ?></td>
                                    <td  width='20%'><?php if($r->ind_status == 'A') echo 'Ativo'; else echo 'Inativo'; ?></td>
                                    <?php $cod_status=$r->cod_status;?>
                                    <td  width='10%'><a href="form_cad_status_atendimento.php?alt=1&cod_status=<?php echo $cod_status; ?>"><i class="fas fa-pencil-alt" style="font-size:20px; color:000000;"></i></a></td>
                                    <td  width='10%'><a href="action_cad_status_atendimento.php?del=1&cod_status=<?php echo $cod_status; ?>" onclick="return confirm('Confirma exclusão?');"><i class="fas fa-trash-alt" style="font-size:20px; color:000000;"></i></a></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        </div>
                        <nav aria-label="Page navigation">
                        <ul class="pagination">
                           <li>
                               <a href="form_cad_status_atendimento.php?pagina=1" aria-label="Previous">
                                   <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php 
                             for($i=1;$i<=$num_paginas;$i++) { 
                                $estilo="";
                                if ($i==$pagina)
                                    $estilo="class=\"active\"" ;   
                                ?> 
                            <li <?php echo $estilo; ?>><a href="form_cad_status_atendimento.php?pagina=<?php echo $i; ?>"> <?php echo $i;?> </a></li><?php }

                                ?>
                                <li>
                                    <a href="form_cad_status_atendimento.php?pagina=<?php echo $num_paginas; ?>" aria-label="Next">
                                         <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                </ul>
                            </nav>
            <?php
                    }
            ?>
                
            </div>
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