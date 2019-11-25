<?php
/**
Descrição: Página de registro de acessos       
*/

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
                  
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        
  </head>

  <body>
       
   <?php if (login_check($mysqli) == true) {
        include 'includes/cabecalho.php';
            if (!empty ($_GET) && (isset($_GET['alt']) || isset($_GET['pw'])) && isset($_GET['nom_usuario'])){
                $nom_usuario = $_GET['nom_usuario'];
                if ($resultado=$mysqli->query("SELECT nom_usuario, nom_senha, ind_status  FROM login WHERE nom_usuario='$nom_usuario'")){
                    if ($resultado->num_rows){
                        $linha=$resultado->fetch_object();
                    }
                }
            }
    ?>

      <div class="container" id="main">
          
        <?php if (isset($_GET['msg'])){
            echo '<div class="alert acesso alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['msg'].'</strong></div>';                     
        }else if (isset($_GET['err'])){
            echo '<div class="alert acesso alert-warning fade in "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['err'].'</strong></div>';
        }
        ?>
        <h1 class="h2">Cadastro de Usuários</h1>
          
            <form  name="form" class="form-horizontal" method="post" action="action_cad_usuario.php">
                <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['nom_usuario'])){
                        echo "<input type='hidden' name='alt' id='alt'>";
                    }
                    else if(!empty ($_GET) && isset($_GET['pw']) && isset($_GET['nom_usuario'])){
                        echo "<input type='hidden' name='pw' id='pw'>";
                    }
                    ?>
                <div class="form-group">
                    <label class="col-md-2 control-label" autocomplete="on">Nome de Usuário: </label>
                    <div class="col-md-8">
                        <input class="txt-auto form-control" type='text' name='nom_usuario' id='nom_usuario' required
                        <?php if ((isset($_GET['alt']) || isset($_GET['pw'])) && isset($_GET['nom_usuario'])) {echo "value='$linha->nom_usuario' readonly";}?>/>
                    </div>
                </div> 
                <?php if (!isset($_GET['alt'])){?>
                <div class="form-group">
                    <label class="col-md-2 control-label">Senha:</label> 
                    <div class="col-md-8">
                        <input type="password" class="form-control txt-auto" name="nom_senha" id="nom_senha" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" autocomplete="on">Confirmar Senha: </label>
                    <div class="col-md-8">
                        <input type="password" class="form-control txt-auto" name="confirma_nom_senha" id="confirma_nom_senha" required/>
                    </div>
                </div>
                <?php }
                if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['nom_usuario'])){?>
                <div class="form-group">
                    <label class="col-md-2 control-label">Status:</label> 
                    <div class="col-md-8">
                        <div class="radio">
                            <label for="ativo">
                                <input name="ind_status" required type="radio" id="ativo" value="A" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['nom_usuario'])) {echo ($linha->ind_status == 'A') ? "checked" : null;} ?>/>
                                Ativo&nbsp&nbsp&nbsp
                            </label>
                            <label for="inativo">
                                <input name="ind_status" required type="radio" id="inativo" value="I" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['nom_usuario'])) {echo ($linha->ind_status == 'I') ? "checked" : null;} ?>/>
                                Inativo
                            </label>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="form-group">
                    <div class="col-md-4 text-right">
                        <input type="button" class="btn btn-default" 
                            <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['nom_usuario'])) { echo "value='Alterar'"; ?>
                            onclick="form.submit();" <?php }
                            else if (!empty ($_GET) && isset($_GET['pw']) && isset($_GET['nom_usuario'])) { echo "value='Alterar Senha'"; ?>
                            onclick="return regformhash(this.form, this.form.nom_usuario, this.form.nom_senha, this.form.confirma_nom_senha);" <?php
                            }else { echo "value='Cadastrar'";?>  
                            onclick="return regformhash(this.form, this.form.nom_usuario, this.form.nom_senha, this.form.confirma_nom_senha);"
                            <?php } ?> />
                        <input type="button" class="btn btn-default" value="Limpar" onclick="window.location='form_cad_usuario.php';">
                    </div>
                </div>
            </form>
   
     <?php
                    $itens_por_pag = 10;
                    if(isset($_GET['pagina'])){$pagina = intval($_GET['pagina']);}else {$pagina=1;}
                    $aux=$pagina*10-10;
                    
                    
                    $records=array();
                    if ($results = $mysqli->query("SELECT nom_usuario, ind_status FROM login LIMIT $aux, $itens_por_pag ")){
                        
                        $num=$results->num_rows;
                        $num_total = $mysqli->query("SELECT nom_usuario, ind_status FROM login")->num_rows;
                    
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
                                <a href="form_cad_usuario.php?pagina=1" aria-label="Previous">
                                   <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php 
                             for($i=1;$i<=$num_paginas;$i++) { 
                                $estilo="";
                                if ($i==$pagina)
                                    $estilo="class=\"active\"" ;   
                                ?> 
                                <li <?php echo $estilo; ?>><a href="form_cad_usuario.php?pagina=<?php echo $i; ?>"> <?php echo $i;?> </a></li><?php }

                                ?>
                                <li>
                                    <a href="form_cad_usuario.php?pagina=<?php echo $num_paginas; ?>" aria-label="Next">
                                         <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                </ul>
                            </nav>
                        <div class="table-of row">
                        <table id="example" class="mtab table table-striped table-hover table-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome de Usuário</th>
                                <th>Status</th>
                                <th>Alterar</th>
                                <th>Trocar Senha</th>
                                <th>Excluir</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($records as $r){?>
                                <tr>
                                    <td  width='30%'><?php echo escape($r->nom_usuario); ?></td>
                                    
                                    <td  width='10%'><?php if($r->ind_status == 'A') echo 'Ativo'; else if ($r->ind_status == 'N') echo 'Novo usuário'; else echo 'Inativo';?></td>
                                    <?php $nom_usuario=$r->nom_usuario;?>
                                    <td  width='10%'><?php if($r->ind_status != 'N'){?><a href="form_cad_usuario.php?alt=1&nom_usuario=<?php echo $nom_usuario; ?>"><i class="fas fa-pencil-alt" style="font-size:20px; color:000000;"></i></a><?php } ?></td>
                                    <td  width='10%'><?php if($r->ind_status != 'N'){?><a href="form_cad_usuario.php?pw=1&nom_usuario=<?php echo $nom_usuario; ?>"><i class="fas fa-lock" style="font-size:20px; color:000000;"></i></a><?php }?></td>
                                    <td  width='10%'><a href="action_cad_usuario.php?del=1&nom_usuario=<?php echo $nom_usuario; ?>" onclick="return confirm('Confirma exclusão?');"><i class="fas fa-trash-alt" style="font-size:20px; color:000000;"></i></a></td>
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
                                <a href="form_cad_usuario.php?pagina=1" aria-label="Previous">
                                   <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php 
                             for($i=1;$i<=$num_paginas;$i++) { 
                                $estilo="";
                                if ($i==$pagina)
                                    $estilo="class=\"active\"" ;   
                                ?> 
                                <li <?php echo $estilo; ?>><a href="form_cad_usuario.php?pagina=<?php echo $i; ?>"> <?php echo $i;?> </a></li><?php }

                                ?>
                                <li>
                                    <a href="form_cad_usuario.php?pagina=<?php echo $num_paginas; ?>" aria-label="Next">
                                         <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                </ul>
                            </nav>
            <?php
                    }
            ?>
                
            </div> 
   
    
    <?php include 'includes/footer.html'; ?>
             
        <?php } else { ?>
            <p>
                <span class="error">Você não tem autorização para acessar esta página.</span> Please <a href="index.php">login</a>.
            </p>
        <?php } ?>
  </body>
</html>