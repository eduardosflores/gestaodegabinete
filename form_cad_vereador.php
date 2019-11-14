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
            $(document).ready(function() {
                 $(".meuselect").select2();
            });
        </script>
    </head>

    <body>
        <?php if (login_check($mysqli) == true) {
                include 'includes/cabecalho.php';

                    if ($resultado=$mysqli->query("SELECT nom_vereador, GAB_CARGO_POLITICO_cod_car_pol, nom_orgao, nom_endereco, nom_numero, nom_complemento, nom_cidade, nom_estado, num_cep, img_foto FROM gab_vereador")){
                        if ($resultado->num_rows){
                            $aux=1;
                            $linha=$resultado->fetch_object();
                        }
                    }

            ?>
            <div class="container" id="main">
                <?php if (isset($_GET['msg'])){
                echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['msg'].'</strong></div>';
                }
                else if (isset($_GET['err'])){
                    echo '<div class="alert alert-warning fade in "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['err'].'</strong></div>';
                }
                ?>
                <h1 class="h2">Cadastro do Agente Político</h1>

                <form  name="form" class="form-horizontal" action="action_cad_vereador.php" method="post" enctype="multipart/form-data">

                    <?php
                    if (isset($aux)){
                    echo "<input type='hidden' name='alt' id='alt'>";

                    }?>


                    <div class="form-group">
                        <label class="col-md-2 control-label">Cargo Político:</label>
                        <?php
                        if ($resultado=$mysqli->query("SELECT cod_car_pol, nom_car_pol, ind_car_pol FROM gab_cargo_politico WHERE ind_car_pol ='A' order by nom_car_pol")){
                            if ($resultado->num_rows){?>

                               <div class="col-md-3">
                                   <select class="meuselect" name="cod_car_pol" required>
                                       <option value="">Selecione</option>
                                       <?php
                                       foreach ($resultado as $linha_set_gab)
                                       {?>
                                       <option value="<?php echo $linha_set_gab['cod_car_pol'];?>"
                                           <?php if (isset($aux) && $linha->GAB_CARGO_POLITICO_cod_car_pol==$linha_set_gab['cod_car_pol']){
                                            echo "selected";}?>> <?php echo $linha_set_gab['nom_car_pol'];?>
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
                                    <select class="form-control" name="cod_car_pol" disabled="true">
                                       <option value="">Selecione</option>
                                       <option value="Não existe Cargo Político cadastrado">
                                       </option> 
                                   </select>
                                </div>
                                <div class="col-md-5">
                                   <span class ="label-warning" style="float: left !important; margin-top: 2px; font-size: 20px;">Não existe Cargo Político cadastrado.</span>
                                </div><?php 
                                $cond = true;
                            }
                        }
                        ?>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label" for="nome" autocomplete="on">Nome do Agente Político:</label>
                        <div class="col-md-5">
                            <input id="nome" name="nom_vereador" type="text" required placeholder="" class="form-control input-md"
                                   value="<?php if (isset($aux)) {echo escape($linha->nom_vereador);}?>">
                        </div>
                    </div>
					
					<div class="form-group">
                        <label class="col-md-2 control-label" for="radios"><u>Endereço do Órgão</u></label>
                        <div class="col-md-3">
                        
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-2 control-label" for="cidade">Nome do Órgão:</label>
                        <div class="col-md-4">
                            <input id="nom_orgao" name="nom_orgao" type="text" required placeholder="" class="form-control input-md"
                                   value="<?php if (isset($aux)) {echo escape($linha->nom_orgao);}?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="estado">Estado:</label>
                        <div class="col-md-2">
                            <select id="estado" name="nom_estado" class="meuselect" required>
                                <option value="" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "") ?  "selected=\"selected\"" : null;}?> >Selecione</option>
                                <option value="AC" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "AC") ?  "selected=\"selected\"" : null;}?>>Acre</option>
                                <option value="AL" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "AL") ?  "selected=\"selected\"" : null;}?>>Alagoas</option>
                                <option value="AP" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "AP") ?  "selected=\"selected\"" : null;}?>>Amapá</option>
                                <option value="AM" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "AM") ?  "selected=\"selected\"" : null;}?>>Amazonas</option>
                                <option value="BA" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "BA") ?  "selected=\"selected\"" : null;}?>>Bahia</option>
                                <option value="CE" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "CE") ?  "selected=\"selected\"" : null;}?>>Ceará</option>
                                <option value="DF" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "DF") ?  "selected=\"selected\"" : null;}?>>Distrito Federal</option>
                                <option value="ES" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "ES") ?  "selected=\"selected\"" : null;}?>>Espirito Santo</option>
                                <option value="GO" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "GO") ?  "selected=\"selected\"" : null;}?>>Goiás</option>
                                <option value="MA" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "MA") ?  "selected=\"selected\"" : null;}?>>Maranhão</option>
                                <option value="MS" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "MS") ?  "selected=\"selected\"" : null;}?>>Mato Grosso do Sul</option>
                                <option value="MT" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "MT") ?  "selected=\"selected\"" : null;}?>>Mato Grosso</option>
                                <option value="MG" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "MG") ?  "selected=\"selected\"" : null;}?>>Minas Gerais</option>
                                <option value="PA" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "PA") ?  "selected=\"selected\"" : null;}?>>Pará</option>
                                <option value="PB" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "PB") ?  "selected=\"selected\"" : null;}?>>Paraíba</option>
                                <option value="PR" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "PR") ?  "selected=\"selected\"" : null;}?>>Paraná</option>
                                <option value="PE" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "PE") ?  "selected=\"selected\"" : null;}?>>Pernambuco</option>
                                <option value="PI" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "RI") ?  "selected=\"selected\"" : null;}?>>Piauí</option>
                                <option value="RJ" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "RJ") ?  "selected=\"selected\"" : null;}?>>Rio de Janeiro</option>
                                <option value="RN" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "RN") ?  "selected=\"selected\"" : null;}?>>Rio Grande do Norte</option>
                                <option value="RS" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "RS") ?  "selected=\"selected\"" : null;}?>>Rio Grande do Sul</option>
                                <option value="RO" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "RO") ?  "selected=\"selected\"" : null;}?>>Rondônia</option>
                                <option value="RR" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "RR") ?  "selected=\"selected\"" : null;}?>>Roraima</option>
                                <option value="SC" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "SC") ?  "selected=\"selected\"" : null;}?>>Santa Catarina</option>
                                <option value="SP" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "SP") ?  "selected=\"selected\"" : null;}?>>São Paulo</option>
                                <option value="SE" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "SE") ?  "selected=\"selected\"" : null;}?>>Sergipe</option>
                                <option value="TO" <?php if (isset($aux))
                                    {echo ($linha->nom_estado == "TO") ?  "selected=\"selected\"" : null;}?>>Tocantins</option>
                            </select>
                        </div>
                        <label class="col-md-1 control-label">CEP:</label>
                        <div class="col-md-2">
                            <input id="num_cep" name="num_cep" required type="text" placeholder="" class="form-control input-md"  maxlength="8" onblur="javascript: ValidaCep(document.form.cep);"
                            value="<?php if (isset($aux)) {echo escape($linha->num_cep);}?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="cidade">Cidade:</label>
                        <div class="col-md-4">
                            <input id="cidade" name="nom_cidade" required type="text" placeholder="" class="form-control input-md"
                                   value="<?php if (isset($aux)) {echo escape($linha->nom_cidade);}?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="endereco">Endereço:</label>
                        <div class="col-md-5">
                            <input id="endereco" name="nom_endereco" type="text" required placeholder="" class="form-control input-md"
                                   value="<?php if (isset($aux)) {echo escape($linha->nom_endereco);}?>">
                        </div>
                        <label class="col-md-1 control-label"  for="numero">Número:</label>
                        <div class="col-md-1">
                            <input id="numero" name="nom_numero" type="text" required placeholder="" class="form-control input-md"
                                   value="<?php if (isset($aux)) {echo escape($linha->nom_numero);}?>">
                        </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-2 control-label"  for="complemento">Bairro/Complemento:</label>
                            <div class="col-md-5">
                                <input id="complemento" name="nom_complemento" type="text" required placeholder="" class="form-control input-md"
                                       value="<?php if (isset($aux)) {echo escape($linha->nom_complemento);}?>">
                            </div>
                    </div>
                    <?php if (isset($aux) && !empty($linha->img_foto)){?>
                    <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-5">
                                 <img src="form_cad_vereador_foto.php" />
                            </div>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                            <label class="col-md-2 control-label">Foto do Agente Político:</label>
                            <div class="col-md-5">
                                <input type="file" name="foto"/>
                                <span>Tamanho máximo:2 MB</span><br>
                                <span>Para uma melhor qualidade de imagem, por favor selecione uma foto de 300x500 pixels.</span>
                            </div>
                    </div>
                    <div class="form-group">
                         <div class="col-md-3 text-right">
                             <input type="submit" <?php if($cond) { echo "disabled";}?> class="btn btn-default" <?php if (isset($aux)) { echo "value='Alterar'";} else {echo "value='Cadastrar'";}?>>
                             <input type="reset" class="btn btn-default" value="Limpar">
                        </div>
                    </div>
                </form>
            </div>
            <?php include 'includes/footer.html';
        } else { ?>
            <p>
                <span class="error">Você não tem autorização para acessar esta página.</span> Please <a href="index.php">login</a>.
            </p>
        <?php } ?>
    </body>
</html>
