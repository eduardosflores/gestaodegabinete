<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';

    session_start(); 

    if (isset($_POST['nom_nome']) )
    {
      $_SESSION['nom_nome'] = $_POST['nom_nome'];
    }
    elseif (!isset($_SESSION['nom_nome']))
    {
        $_SESSION['nom_nome'] = "";
    } 
    if (isset($_POST['nom_apelido']))
    {
      $_SESSION['nom_apelido'] = $_POST['nom_apelido'];
    }
    elseif (!isset($_SESSION['nom_apelido']))
    {
        $_SESSION['nom_apelido'] = "";
    } 
    if (isset($_POST['cod_cpf_cnpj']))
    {
      $_SESSION['cod_cpf_cnpj'] = $_POST['cod_cpf_cnpj'];
    }
    elseif (!isset($_SESSION['cod_cpf_cnpj']))
    {
        $_SESSION['cod_cpf_cnpj'] = "";
    } 
    if (isset($_POST['cod_rg']))
    {
      $_SESSION['cod_rg'] = $_POST['cod_rg'];
    }
    elseif (!isset($_SESSION['cod_rg']))
    {
        $_SESSION['cod_rg'] = "";
    } 
    if (isset($_POST['dat_nascimento']))
    {
      $_SESSION['dat_nascimento'] = $_POST['dat_nascimento'];
    }
    elseif (!isset($_SESSION['dat_nascimento']))
    {
        $_SESSION['dat_nascimento'] = "";
    } 
    if (isset($_GET['pagina']))
    {
        $_SESSION['pagina'] = $_GET['pagina'];
    }
    elseif (!isset($_SESSION['pagina']))
    {
        $_SESSION['pagina'] = "1";
    }
?>
<!DOCTYPE html>
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

        <script language="JavaScript">



            function er_replace( pattern, replacement, subject ){
                return subject.replace( pattern, replacement );
            }

            $(document).ready(function(){
         

                    // Somente letras maiúsculas e minúsculas e numeros
                    $("#cod_ie").keyup(function() {
                        var $this = $( this );
                        $this.val( er_replace( /[^a-z0-9]+/gi,'', $this.val() ) );
                    });

                    // Somente letras maiúsculas e minúsculas e numeros
                    $("#cod_rg").keyup(function(){
                        var $this = $( this );
                       // $this.val( preg_replace( /[^a-z0-9]+/gi,'', $this.val() ) );
                    });
                    $(".meuselect").select2();

            });

            function tipo_pessoa(){
                var rad = $("input[name='ind_pessoa']:checked").val();
                location.href = 'form_cad_pessoa.php?var_rad='+rad;
            }

            function checkAll(ele) {
                var checkboxes = document.getElementsByTagName('input');
                if (ele.checked) {
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].type == 'checkbox') {
                            checkboxes[i].checked = true;
                        }
                    }
                } else {
                    for (var i = 0; i < checkboxes.length; i++) {
                        console.log(i)
                        if (checkboxes[i].type == 'checkbox') {
                            checkboxes[i].checked = false;
                        }
                    }
                }
            }

            function pesquisar()
            {
                document.form.action = "form_cad_pessoa.php?pagina=1&pesquisa=1#pes";
                document.form.submit();
            }

            function voltarPagina()
            {
                window.location.href = "form_cad_pessoa.php?pagina=<?=$_SESSION['pagina'];?>&pesquisa=1&nom_nome=<?=$_SESSION['nom_nome'];?>&nom_apelido=<?=$_SESSION['nom_apelido'];?>&cod_cpf_cnpj=<?=$_SESSION['cod_cpf_cnpj'];?>&cod_rg=<?=$_SESSION['cod_rg'];?>&dat_nascimento=<?=$_SESSION['dat_nascimento'];?>&cod_ie=#pes"; 
            }

            


            function checaPulaLinhaEtiquetas()
            {

               /* if((document.getElementsByName("tip_et")[0].checked)&&(document.getElementById("op_re").checked))
                {
                    if (document.getElementById("pular").value>8){
                        alert("O valor para pular linhas deve ser MENOR ou IGUAL a 8.");
                    }
                    else{
                        document.form_etiquetas.submit();
                    }
                }else*/
                if (document.getElementsByName("tip_et")[2].checked || document.getElementsByName("tip_et")[1].checked)//opção 30 ou 20 etiquetas selecionada
                {
                    if (document.getElementById("pular").value>9){
                        alert("O valor para pular linhas deve ser MENOR ou IGUAL a 9.");
                    }
                    else{
                        document.form_etiquetas.submit();
                    }
                }else {//opção 14 etiquetas selecionada
                    if (document.getElementById("pular").value>6){
                        alert("O valor para pular linhas de etiquetas deve ser MENOR ou IGUAL a 6.");
                    }
                    else{
                        document.form_etiquetas.submit();
                    }

                }

            }


        </script>
    </head>

    <body>

        <?php if (login_check($mysqli) == true) {
                include 'includes/cabecalho.php';

                if(empty($_GET['var_rad']))
                    $_SESSION['ind_pessoa'] = "PF";
                else
                    $_SESSION['ind_pessoa'] = $_GET['var_rad'];

                if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])){
                    $cod_pessoa = $_GET['cod_pessoa'];
                    if ($resultado=$mysqli->query("SELECT cod_pessoa, ind_pessoa, nom_nome, nom_apelido, nom_ocupacao, dat_nascimento, cod_cpf_cnpj, cod_ie, cod_rg, ind_sexo, num_cep, nom_endereco, nom_numero, nom_bairro, nom_complemento, nom_cidade, nom_estado, num_ddd_tel, num_tel, num_ddd_cel, num_cel, nom_email, nom_rede_social, img_foto, ind_status, txt_obs, nom_re FROM gab_pessoa WHERE cod_pessoa='$cod_pessoa'")){
                        if ($resultado->num_rows){
                            $linha=$resultado->fetch_object();
                            if($linha->ind_pessoa == "PF")
                                $_SESSION['ind_pessoa'] = "PF";
                            else
                                $_SESSION['ind_pessoa'] = "PJ";
                        }

                        $num_tel= preg_replace('/([0-9]{4})([0-9]{4})/',"$1-$2",$linha->num_tel);
                        $num_cel= preg_replace('/([0-9]{5})([0-9]{4})/',"$1-$2",$linha->num_cel);
                        $cod_rg= preg_replace('/([A-Za-z0-9]{2})([A-Za-z0-9]{3})([A-Za-z0-9]{3})([A-Za-z0-9]{1})/',"$1.$2.$3-$4",$linha->cod_rg);
                        $num_cep= preg_replace('/([0-9]{2})([0-9]{3})([0-9]{3})/',"$1$2-$3",$linha->num_cep);

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
                <h1 class="h2">Cadastro de Pessoa</h1>

                <form  name="form" class="form-horizontal" action="<?php if (isset ($_GET['mod'])){
                echo "action_cad_pessoa.php?mod=1";} else {echo "action_cad_pessoa.php";} ?>" method="post" autocomplete="off">


                    <?php
                    if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])){
                    echo "<input type='hidden' name='alt' id='alt'>";
                    echo "<input type='hidden' name='cod_pessoa' value=".$_GET['cod_pessoa'].">";
                    }?>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="foto" autocomplete="on"></label>

                        <div class="col-md-1" style="border: 0px solid;">
                            <?php
                            if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])){
                                echo "<button type='button' class='btn btn-default btn-xs' onclick=modal('form_cad_foto_pessoa.php?cod_pessoa=$cod_pessoa','modal',800,500)><i class='fas fa-camera' style='font-size:20px; color:000000;'></i></button>";
                            }
                            else{
                                 //gerando número de identificação único
                                $id_foto=uniqid(rand(), true);
                                //echo 'id:'.$id_foto;
                                $id_foto=str_replace(".", "", substr($id_foto, 0, 10));
                                //echo 'id:'.$id_foto;

                                echo "<button type='button' class='btn btn-default btn-xs' onclick=modal('form_cad_foto_pessoa.php?id_foto=$id_foto','modal',800,500)><i class='fas fa-camera' style='font-size:20px; color:000000;'></i></button>";
                            }
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])){
                                $img="fotos/".$_GET['cod_pessoa'].".jpg";

                                echo "<div>";
                                if (file_exists($img)) {
                                   echo "<a href=javascript:modal_foto('form_mostrar_foto_pessoa.php?cod_pessoa=$cod_pessoa','modal',800,500)><img id='div_foto' src=". $img . " width='160' height='120'></a>";
                                } else {
                                   echo "<img id='div_foto' src='fotos/sem-foto.jpg' width='160' height='120'>";
                                }
                                echo "</div>";

                            }else {
                                echo "<div>";
                                echo "<img id='div_foto'>";
                                echo "</div>";


                                echo "<input type='hidden' name='id_foto' value='$id_foto'>";
                            }
                            ?>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="radios">Tipo de Pessoa:</label>
                        <div class="col-md-3">
                            <div class="radio">
                                <label for="fisica">
                                    <input type="radio" name="ind_pessoa" id="fisica" onclick="tipo_pessoa()" value="PF"
                                    <?php if($_SESSION['ind_pessoa'] == "PF") echo "checked";?>>
                                    Física&nbsp&nbsp&nbsp
                                </label>
                                <label for="juridica">
                                    <input type="radio" name="ind_pessoa" id="juridica" onclick="tipo_pessoa()" value="PJ"
                                    <?php if($_SESSION['ind_pessoa'] == "PJ") echo "checked";?> >
                                    Jurídica
                                </label>
                            </div>
                        </div>
                    </div>

                    <?php if($_SESSION['ind_pessoa'] == "PF"){ ?>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="nome" autocomplete="on" id="nm">Nome:</label>
                            <div class="col-md-8">
                                <input id="nome" name="nom_nome" type="text"  required placeholder="" class="form-control input-md"
                                       value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_nome);} elseif (!empty($_SESSION['nom_nome']) && isset($_GET['pesquisa'])) {echo $_SESSION['nom_nome'];}?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="apelido" autocomplete="on">Apelido:</label>
                            <div class="col-md-8">
                                <input id="apelido" name="nom_apelido" type="text" placeholder="" class="form-control input-md"
                                       value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_apelido);} elseif (!empty($_SESSION['nom_apelido']) && isset($_GET['pesquisa'])) {echo $_SESSION['nom_apelido'];}?>">
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="nome" autocomplete="on">Razão Social:</label>
                            <div class="col-md-8">
                                <input id="nome" name="nom_nome" type="text" required placeholder="" class="form-control input-md"
                                       value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_nome);}?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="fantasia" autocomplete="on">Nome Fantasia:</label>
                            <div class="col-md-8">
                                <input id="fantasua" name="nom_fantasia" type="text" placeholder="" class="form-control input-md"
                                       value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_apelido);}?>">
                            </div>
                        </div>
                        <!-- CAMPOS REPRESENTANTE -->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="representante">Representante/Contato:</label>
                            <div class="col-md-8">
                                <input id= "representante" name="nom_re" type="text" placeholder="" class="form-control input-md"
                                    value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_re);}?>">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="nom_ocupacao" autocomplete="on"><?php if($_SESSION['ind_pessoa'] == "PF") echo"Profissão:"; else echo "Segmento:";?> </label>
                        <div class="col-md-8">
                            <input id="nom_ocupacao" name="nom_ocupacao" type="text" placeholder="" class="form-control input-md"
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_ocupacao);}?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="data"><?php if($_SESSION['ind_pessoa'] == "PF") {echo 'Data de Nascimento:';}else {echo 'Data de Constituição:';}?></label>
                        <div class="col-md-3">
                            <input id="data" maxlength="10" name="dat_nascimento" type="text" placeholder="" class="form-control input-md datepicker" onblur="validaData(this)"
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape(converteDataBR($linha->dat_nascimento));} elseif (!empty($_SESSION['dat_nascimento']) && isset($_GET['pesquisa'])) {echo $_SESSION['dat_nascimento'];}?>">
                        </div>
                        <?php if($_SESSION['ind_pessoa'] == "PJ"){ ?>
                        <label class="col-md-2 control-label" for="ie">Inscrição Estadual:</label>
                        <div class="col-md-3">
                            <input maxlength="15" id="cod_ie" name="cod_ie" type="text" class="form-control input-md" title="Favor não utilizar pontuação."
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo $linha->cod_ie;}?>">
                        </div>
                        <?php } else { ?>
                        <label class="col-md-2 control-label" for="radios">Sexo:</label>
                        <div class="col-md-3">
                            <div class="radio">
                                <label for="masculino">
                                    <input type="radio" name="ind_sexo" id="masculino" value="M" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo $linha->ind_sexo == 'M' ? "checked" : null;}?>>
                                    Masculino&nbsp&nbsp&nbsp
                                </label>
                                <label for="feminino">
                                    <input type="radio" name="ind_sexo" id="feminino" value="F" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo $linha->ind_sexo == 'F' ? "checked" : null;}?> >
                                    Feminino
                                </label>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" autocomplete="on"><?php if($_SESSION['ind_pessoa'] == "PF") {echo 'CPF:';}else {echo 'CNPJ:';}?></label>
                        <div class="col-md-3">
                            <input id="<?php if($_SESSION['ind_pessoa'] == "PF") {echo 'cpf';}else {echo 'cnpj';}?>"name="cod_cpf_cnpj" type="text" class="form-control input-md"
                                   <?php if($_SESSION['ind_pessoa'] == "PF") {?> onblur="javascript: validarCPF(document.form.cpf);" onkeypress="javascript: mascara(this, cpf_mask);"<?php } ?>
                                   maxlength="<?php if($_SESSION['ind_pessoa'] == "PF") {echo '14';}else {echo '18';}?>"
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->cod_cpf_cnpj);} elseif (!empty($_SESSION['cod_cpf_cnpj']) && isset($_GET['pesquisa'])) {echo $_SESSION['cod_cpf_cnpj']; }?>"/>
                        <span id="message" ></span>
                        <span id="msgCPF"></span>
                        </div>
                        <?php if($_SESSION['ind_pessoa'] == "PF"){ ?>
                        <label class="col-md-2 control-label" for="rg">RG:</label>
                        <div class="col-md-3">
                            <input maxlength="12" id="cod_rg" name="cod_rg" type="text" class="form-control input-md" title="Favor utilizar pontuação."
                            value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($cod_rg);} elseif (!empty($_SESSION['cod_rg']) && isset($_GET['pesquisa'])) {echo $_SESSION['cod_rg'];}?>">
                        </div>
                        <?php }?>
                    </div>
                    <!--Endereço do Usuario -->
                    <div class="form-group">
                        <label class="col-md-2 control-label">CEP:</label>
                        <div class="col-md-3">
                            <input id="num_cep" name="num_cep" type="text" placeholder="" class="form-control input-md"  maxlength="8" title="Favor utilizar pontuação."
                            value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($num_cep);}?>">
                            <span id="messagecep" ></span>
                        </div>
                        <label class="col-md-2 control-label" for="estado">Estado:</label>
                        <div class="col-md-3">
                            <select id="estado" name="nom_estado"   class="meuselect">
                                <option value="" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "") ?  "selected=\"selected\"" : null;}?> >Selecione</option>
                                <option value="AC" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "AC") ?  "selected=\"selected\"" : null;}?>>Acre</option>
                                <option value="AL" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "AL") ?  "selected=\"selected\"" : null;}?>>Alagoas</option>
                                <option value="AP" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "AP") ?  "selected=\"selected\"" : null;}?>>Amapá</option>
                                <option value="AM" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "AM") ?  "selected=\"selected\"" : null;}?>>Amazonas</option>
                                <option value="BA" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "BA") ?  "selected=\"selected\"" : null;}?>>Bahia</option>
                                <option value="CE" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "CE") ?  "selected=\"selected\"" : null;}?>>Ceará</option>
                                <option value="DF" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "DF") ?  "selected=\"selected\"" : null;}?>>Distrito Federal</option>
                                <option value="ES" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "ES") ?  "selected=\"selected\"" : null;}?>>Espirito Santo</option>
                                <option value="GO" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "GO") ?  "selected=\"selected\"" : null;}?>>Goiás</option>
                                <option value="MA" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "MA") ?  "selected=\"selected\"" : null;}?>>Maranhão</option>
                                <option value="MS" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "MS") ?  "selected=\"selected\"" : null;}?>>Mato Grosso do Sul</option>
                                <option value="MT" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "MT") ?  "selected=\"selected\"" : null;}?>>Mato Grosso</option>
                                <option value="MG" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "MG") ?  "selected=\"selected\"" : null;}?>>Minas Gerais</option>
                                <option value="PA" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "PA") ?  "selected=\"selected\"" : null;}?>>Pará</option>
                                <option value="PB" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "PB") ?  "selected=\"selected\"" : null;}?>>Paraíba</option>
                                <option value="PR" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "PR") ?  "selected=\"selected\"" : null;}?>>Paraná</option>
                                <option value="PE" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "PE") ?  "selected=\"selected\"" : null;}?>>Pernambuco</option>
                                <option value="PI" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "PI") ?  "selected=\"selected\"" : null;}?>>Piauí</option>
                                <option value="RJ" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "RJ") ?  "selected=\"selected\"" : null;}?>>Rio de Janeiro</option>
                                <option value="RN" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "RN") ?  "selected=\"selected\"" : null;}?>>Rio Grande do Norte</option>
                                <option value="RS" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "RS") ?  "selected=\"selected\"" : null;}?>>Rio Grande do Sul</option>
                                <option value="RO" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "RO") ?  "selected=\"selected\"" : null;}?>>Rondônia</option>
                                <option value="RR" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "RR") ?  "selected=\"selected\"" : null;}?>>Roraima</option>
                                <option value="SC" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "SC") ?  "selected=\"selected\"" : null;}?>>Santa Catarina</option>
                                <option value="SP" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "SP") ?  "selected=\"selected\"" : null;}?>>São Paulo</option>
                                <option value="SE" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "SE") ?  "selected=\"selected\"" : null;}?>>Sergipe</option>
                                <option value="TO" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa']))
                                    {echo ($linha->nom_estado == "TO") ?  "selected=\"selected\"" : null;}?>>Tocantins</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="cidade" id="cd">Cidade:</label>
                        <div class="col-md-8">
                            <input id="cidade" name="nom_cidade" type="text" placeholder="" class="form-control input-md"
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_cidade);}?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Bairro:</label>
                        <div class="col-md-8">
                            <input id="bairro" name="nom_bairro" type="text" placeholder="" class="form-control input-md"
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_bairro);}?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="endereco">Endereço:</label>
                        <div class="col-md-8">
                            <input id="endereco" name="nom_endereco" type="text" placeholder="" class="form-control input-md"
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_endereco);}?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="complemento">Complemento:</label>
                            <div class="col-md-3">
                                <input id="complemento" name="nom_complemento" type="text" placeholder="" class="form-control input-md"
                                       value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_complemento);}?>">
                            </div>

                        <label class="col-md-2 control-label" for="numero">Número:</label>
                        <div class="col-md-3">
                            <input id="numero" name="nom_numero" type="text" placeholder="" class="form-control input-md"
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_numero);}?>">
                        </div>
                    </div>





                    <div class="form-group">
                        <label class="col-md-2 control-label" for="telefone">Telefone:</label>
                        <div class="col-md-1 en">
                            <input id="telefone" maxlength="2" name="num_ddd_tel" type="text" placeholder="" class="form-control input-md"
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->num_ddd_tel);}?>">
                        </div>
                        <div class="col-md-2 em">
                             <input id="telefone" maxlength="9" name="num_telefone" type="text" placeholder="" class="form-control input-md"
                                    value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($num_tel);}?>">
                        </div>


                        <label class="col-md-2 control-label arr" for="celular">Celular:</label>
                        <div class="col-md-1 en">
                            <input id="celular" maxlength="2" name="num_ddd_cel" type="text" placeholder="" class="form-control input-md "
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->num_ddd_cel);}?>">
                        </div>
                        <div class="col-md-2 em">
                             <input id="celulare" maxlength="10" name="num_celular" type="text" placeholder="" class="form-control input-md"
                                    value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($num_cel);}?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="email">Email:</label>
                        <div class="col-md-8">
                            <input id="email" name="nom_email" type="email" placeholder="" class="form-control input-md"
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_email);}?>">
                        </div>

                    </div>
                        <div class="form-group">
                        <label class="col-md-2 control-label" for="email">Link Rede Social:</label>
                        <div class="col-md-8">
                            <input name="nom_rede_social" type="text" placeholder="" class="form-control input-md"
                                   value="<?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->nom_rede_social);}?>">
                        </div>

                    </div>




                    <div class="form-group">
                        <label class="col-md-2 control-label" for="obs">Observações:</label>
                        <div class="col-md-8">
                            <textarea class="form-control input-md" name="txt_obs" rows="4"><?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) {echo escape($linha->txt_obs);}?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                         <div class="col-md-8 text-right">
                             <input type="submit" class="btn btn-default" onclick="return confirm('Confirma cadastro?'); <?php $_SESSION['ind_pessoa'] = "PF"; ?>" <?php if (!empty ($_GET) && isset($_GET['alt']) && isset($_GET['cod_pessoa'])) { echo "value='Alterar'";}else{ echo"value='Cadastrar'";}?>>

                             <input type="button" class="btn btn-default" value="Limpar" onclick="window.location='form_cad_pessoa.php';">
                             <input type="button" id="pes" class="btn btn-default" value="Pesquisar" onclick="pesquisar();">
	                         <input type="button" id="voltar" class="btn btn-default" value="Voltar" onclick="javaScript:voltarPagina();" <?php if (!isset($_GET['pesquisa']) && !isset($_GET['alt'])){ echo "style='visibility:hidden;'";} ?>>
                        </div>
                    </div>
                </form>
            <?php

                if (isset($_GET['pesquisa'])){
                    $limite=1000;
                    $itens_por_pag = 50;
                    if(isset($_GET['pagina'])){$pagina = intval($_GET['pagina']);}else {$pagina=1;}
                    $aux=$pagina*50-50;

                    $records=array();

                    if(isset($_POST['ind_pessoa'])){
                        $ind_pessoa=$_POST['ind_pessoa'];
                    }else
                    if(isset($_GET['ind_pessoa'])){
                        $ind_pessoa=$_GET['ind_pessoa'];
                    }else{
                        $ind_pessoa="PF";
                    }
                        $select_qry="select cod_pessoa, ind_pessoa, nom_nome, nom_apelido, cod_cpf_cnpj, cod_rg, cod_ie, nom_email, num_ddd_tel, num_tel, num_ddd_cel, num_cel, nom_re from gab_pessoa where ind_status='A'";

                            if (isset($_POST['nom_nome']) && !empty($_POST['nom_nome'])){
                                $nom_nome=$_POST['nom_nome'];
                                $select_qry.=" and nom_nome like '%$nom_nome%' ";
                            }else
                            if (isset($_GET['nom_nome']) && !empty($_GET['nom_nome'])){
                                $nom_nome=$_GET['nom_nome'];
                                $select_qry.=" and nom_nome like '%$nom_nome%' ";
                            }else{
                                $nom_nome='';
                            }

                            if (isset($_POST['nom_apelido']) && !empty($_POST['nom_apelido'])){
                                $nom_apelido=$_POST['nom_apelido'];
                                $select_qry.=" and nom_apelido like '%$nom_apelido%' ";
                            }else
                            if (isset($_GET['nom_apelido']) && !empty($_GET['nom_apelido'])){
                                $nom_apelido=$_GET['nom_apelido'];
                                $select_qry.=" and nom_apelido like '%$nom_apelido%' ";
                            }else{
                                $nom_apelido='';
                            }


                            if (isset($_POST['dat_nascimento']) && !empty($_POST['dat_nascimento'])){
                                $dat_nascimento=converte_data($_POST['dat_nascimento']);
                                $select_qry.=" and dat_nascimento = '$dat_nascimento' ";
                            }else
                            if (isset($_GET['dat_nascimento']) && !empty($_GET['dat_nascimento'])){
                                $dat_nascimento=converte_data($_GET['dat_nascimento']);
                                $select_qry.=" and dat_nascimento = '$dat_nascimento' ";
                            }else{
                                $dat_nascimento='';
                            }

                            if(isset($_POST['cod_rg']) && !empty($_POST['cod_rg']) ){
                                $cod_rg=$_POST['cod_rg'];
                                $select_qry.=" and cod_rg = '$cod_rg' ";
                            }else
                            if(isset($_GET['cod_rg']) && !empty($_GET['cod_rg']) ){
                                $cod_rg=$_GET['cod_rg'];
                                $select_qry.=" and cod_rg = '$cod_rg' ";
                            }else{
                                $cod_rg='';
                            }

                            if(isset($_POST['cod_ie']) && !empty($_POST['cod_ie']) ){
                                $cod_ie=$_POST['cod_ie'];
                                $select_qry.=" and cod_ie = '$cod_ie' ";
                            }else
                            if(isset($_GET['cod_ie']) && !empty($_GET['cod_ie']) ){
                                $cod_ie=$_GET['cod_ie'];
                                $select_qry.=" and cod_ie = '$cod_ie' ";
                            }else{
                                $cod_ie='';
                            }


                            if (isset($_POST['cod_cpf_cnpj']) && !empty($_POST['cod_cpf_cnpj'])){
                                $cod_cpf_cnpj=$_POST['cod_cpf_cnpj'];
                                $select_qry.=" and cod_cpf_cnpj = '$cod_cpf_cnpj' ";
                            }else
                            if (isset($_GET['cod_cpf_cnpj']) && !empty($_GET['cod_cpf_cnpj'])){
                                $cod_cpf_cnpj=$_GET['cod_cpf_cnpj'];
                                $select_qry.=" and cod_cpf_cnpj = '$cod_cpf_cnpj' ";
                            }else{
                                $cod_cpf_cnpj='';
                            }

                            if (isset($_POST['nom_re']) && !empty($_POST['nom_re'])){
                                $nom_re=$_POST['nom_re'];
                                $select_qry.=" and nom_re like '%$nom_re%' ";
                            }else
                            if (isset($_GET['nom_re']) && !empty($_GET['nom_re'])){
                                $nom_re=$_GET['nom_re'];
                                $select_qry.=" and nom_re like '%$nom_re%' ";
                            }else{
                                $nom_re='';
                            }


                        $select_qry.=" ORDER BY nom_nome ";
                        $_SESSION['sql']=$select_qry;
                        $_SESSION['sql'].= " ASC LIMIT $limite";

                        $select_qry.=" ASC LIMIT $aux, $itens_por_pag ";

                        if ($results = $mysqli->query($select_qry))
                        {

                            $num=$results->num_rows;
                            $select_qry="select cod_pessoa, ind_pessoa, nom_nome, nom_apelido, cod_cpf_cnpj, cod_rg, cod_ie, nom_email, num_ddd_tel, num_tel, num_ddd_cel, num_cel, nom_re from gab_pessoa where ind_status='A'";


                             if (isset($_POST['nom_nome']) && !empty($_POST['nom_nome'])){
                                $nom_nome=$_POST['nom_nome'];
                                $select_qry.=" and nom_nome like '%$nom_nome%' ";
                            }else
                            if (isset($_GET['nom_nome']) && !empty($_GET['nom_nome'])){
                                $nom_nome=$_GET['nom_nome'];
                                $select_qry.=" and nom_nome like '%$nom_nome%' ";
                            }else{
                                $nom_nome='';
                            }

                            if (isset($_POST['nom_apelido']) && !empty($_POST['nom_apelido'])){
                                $nom_apelido=$_POST['nom_apelido'];
                                $select_qry.=" and nom_apelido like '%$nom_apelido%' ";
                            }else
                            if (isset($_GET['nom_apelido']) && !empty($_GET['nom_apelido'])){
                                $nom_apelido=$_GET['nom_apelido'];
                                $select_qry.=" and nom_apelido like '%$nom_apelido%' ";
                            }else{
                                $nom_apelido='';
                            }


                            if (isset($_POST['dat_nascimento']) && !empty($_POST['dat_nascimento'])){
                                $dat_nascimento=converte_data($_POST['dat_nascimento']);
                                $select_qry.=" and dat_nascimento = '$dat_nascimento' ";
                            }else
                            if (isset($_GET['dat_nascimento']) && !empty($_GET['dat_nascimento'])){
                                $dat_nascimento=converte_data($_GET['dat_nascimento']);
                                $select_qry.=" and dat_nascimento = '$dat_nascimento' ";
                            }else{
                                $dat_nascimento='';
                            }

                            if(isset($_POST['cod_rg']) && !empty($_POST['cod_rg']) ){
                                $cod_rg=$_POST['cod_rg'];
                                $select_qry.=" and cod_rg = '$cod_rg' ";
                            }else
                            if(isset($_GET['cod_rg']) && !empty($_GET['cod_rg']) ){
                                $cod_rg=$_GET['cod_rg'];
                                $select_qry.=" and cod_rg = '$cod_rg' ";
                            }else{
                                $cod_rg='';
                            }

                            if(isset($_POST['cod_ie']) && !empty($_POST['cod_ie']) ){
                                $cod_ie=$_POST['cod_ie'];
                                $select_qry.=" and cod_ie = '$cod_ie' ";
                            }else
                            if(isset($_GET['cod_ie']) && !empty($_GET['cod_ie']) ){
                                $cod_ie=$_GET['cod_ie'];
                                $select_qry.=" and cod_ie = '$cod_ie' ";
                            }else{
                                $cod_ie='';
                            }


                            if (isset($_POST['cod_cpf_cnpj']) && !empty($_POST['cod_cpf_cnpj'])){
                                $cod_cpf_cnpj=$_POST['cod_cpf_cnpj'];
                                $select_qry.=" and cod_cpf_cnpj = '$cod_cpf_cnpj' ";
                            }else
                            if (isset($_GET['cod_cpf_cnpj']) && !empty($_GET['cod_cpf_cnpj'])){
                                $cod_cpf_cnpj=$_GET['cod_cpf_cnpj'];
                                $select_qry.=" and cod_cpf_cnpj = '$cod_cpf_cnpj' ";
                            }else{
                                $cod_cpf_cnpj='';
                            }

                            if (isset($_POST['nom_re']) && !empty($_POST['nom_re'])){
                                $nom_re=$_POST['nom_re'];
                                $select_qry.=" and nom_re like '%$nom_re%' ";
                            }else
                            if (isset($_GET['nom_re']) && !empty($_GET['nom_re'])){
                                $nom_re=$_GET['nom_re'];
                                $select_qry.=" and nom_re like '%$nom_re%' ";
                            }else{
                                $nom_re='';
                            }

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
                    }

                ?>

                <?php

                    $count_total = $mysqli->query($select_qry);
                    if ( count($records) == 0)
                    {
                      echo "Nenhum registro encontrado.";
                    }

                    if (count($records)){?>
                        <nav id="tab" aria-label="Page navigation">
                            <ul class="pagination">
                                <li>
                                    <a href="form_cad_pessoa.php?pagina=1&pesquisa=1&ind_pessoa=<?php echo $ind_pessoa; ?>&nom_nome=<?php echo $nom_nome; ?>&nom_apelido=<?php echo $nom_apelido; ?>&cod_cpf_cnpj=<?php echo $cod_cpf_cnpj; ?>&cod_rg=<?php echo $cod_rg; ?>&dat_nascimento=<?php echo $dat_nascimento; ?>&cod_ie=<?php echo $cod_ie;?>#pes" aria-label="Previous">
                                       <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php
                                 for($i=1;$i<=$num_paginas;$i++) {
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;
                                    ?>
                                    <li <?php echo $estilo; ?>><a href="form_cad_pessoa.php?pagina=<?php echo $i; ?>&pesquisa=1&ind_pessoa=<?php echo $ind_pessoa; ?>&nom_nome=<?php echo $nom_nome; ?>&nom_apelido=<?php echo $nom_apelido; ?>&cod_cpf_cnpj=<?php echo $cod_cpf_cnpj; ?>&cod_rg=<?php echo $cod_rg; ?>&dat_nascimento=<?php echo $dat_nascimento; ?>&cod_ie=<?php echo $cod_ie;?>#pes"> <?php echo $i;?> </a></li>
                                    <?php } ?>


                                    <li>
                                        <a href="form_cad_pessoa.php?pagina=<?php echo $num_paginas; ?>&pesquisa=1&ind_pessoa=<?php echo $ind_pessoa; ?>&nom_nome=<?php echo $nom_nome; ?>&nom_apelido=<?php echo $nom_apelido; ?>&cod_cpf_cnpj=<?php echo $cod_cpf_cnpj; ?>&cod_rg=<?php echo $cod_rg; ?>&dat_nascimento=<?php echo $dat_nascimento; ?>&cod_ie=<?php echo $cod_ie;?>#pes" aria-label="Next">
                                             <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>
                        <div class="row">
                            <div><span style="float:left;"><?php echo "Total de registros: ". $count_total->num_rows ." ";?>(a pesquisa retorna até <?php echo $limite; ?> registros)</span></div>
                            <div style="float:right;">
                                <a align="right" href="form_cad_pessoa_xlsx.php"><i class="far fa-file-excel fa-3x" title="Gerar relatório Excel"></i></a>
                                <a target="_blank" href="form_cad_pessoa_pdf.php"><i class="far fa-file-pdf fa-3x" title="Gerar relatório PDF"></i></a>
                            </div>
                        </div>

                        <hr>
                        <div class="table-of row">
                        <table id="example" class="mtab table table-striped table-hover table-responsive" cellspacing="0" >

                            <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox"  onchange="checkAll(this)" name="chk[]"></th>
                                <th>Nome</th>
                                <th>Doc.Identificação</th>
                                <th>Doc.Identificação</th>
                                <th>Email</th>
                                <th>Telefone/<br>Celular</th>
                                <th>Alterar</th>
                                <th>Excluir</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($records as $r){?>
                                <tr>
                                    <td  width='5%' class="text-center">
                                    <form name="form_etiquetas" target="_blank" action="form_cad_pessoa_etiqueta_pdf.php" type="post">
                                    <input name="cod_pessoa[]" type="checkbox" value="<?php echo ($r->cod_pessoa); ?>">
                                    <input type="hidden" name="origem" value="form_cad_pessoa"></td>
                                    <td  width='20%'><?php if ($r->nom_apelido!=NULL) echo escape($r->nom_nome." \"".$r->nom_apelido."\""); else echo escape($r->nom_nome) ; ?></td>
                                    <td  width='18%'>
                                        <?php
                                              if ($r->ind_pessoa == "PF" && !empty($r->cod_cpf_cnpj)){ echo escape("CPF: ".$r->cod_cpf_cnpj); }
                                              if ($r->ind_pessoa == "PJ" && !empty($r->cod_cpf_cnpj)){ echo escape("CNPJ: ".$r->cod_cpf_cnpj); }
                                        ?>
                                    </td>
                                    <td  width='12%'>
                                        <?php
                                            $cod_rg= preg_replace('/([A-Za-z0-9]{2})([A-Za-z0-9]{3})([A-Za-z0-9]{3})([A-Za-z0-9]{1})/',"$1.$2.$3-$4",$r->cod_rg);
                                            if($r->ind_pessoa == "PF" && !empty($cod_rg)){ echo escape("RG: ".$cod_rg); }
                                            if($r->ind_pessoa == "PJ" && !empty($r->cod_ie)){ echo escape("IE: ".$r->cod_ie); }
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
                                    <td  width='15%'><?php echo escape($r->nom_email); ?></td>
                                    <td  width='15%'><?php echo escape($num_ddd_tel)." ".escape($num_tel);?><br><?php echo escape($num_ddd_cel)." ".escape($num_cel);?></td>

                                    <?php $cod_pessoa=$r->cod_pessoa;?>
                                    <td style="text-align:center;" width='5%'><a href="form_cad_pessoa.php?alt=1&cod_pessoa=<?php echo $cod_pessoa; ?>"><i class="fas fa-pencil-alt" style="font-size:20px; color:000000;"></i></a></td>
                                    <td style="text-align:center;" width='5%'><a href="action_cad_pessoa.php?del=1&cod_pessoa=<?php echo $cod_pessoa; ?>" onclick="return confirm('Confirma exclusão?');"><i class="fas fa-trash-alt" style="font-size:20px; color:000000;"></i></a></td>
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
                                    <a href="form_cad_pessoa.php?pagina=1&pesquisa=1&ind_pessoa=<?php echo $ind_pessoa; ?>&nom_nome=<?php echo $nom_nome; ?>&nom_apelido=<?php echo $nom_apelido; ?>&cod_cpf_cnpj=<?php echo $cod_cpf_cnpj; ?>&cod_rg=<?php echo $cod_rg; ?>&dat_nascimento=<?php echo $dat_nascimento; ?>&cod_ie=<?php echo $cod_ie;?>#pes" aria-label="Previous">
                                       <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php
                                 for($i=1;$i<=$num_paginas;$i++) {
                                    $estilo="";
                                    if ($i==$pagina)
                                        $estilo="class=\"active\"" ;
                                    ?>
                                    <li <?php echo $estilo; ?>><a href="form_cad_pessoa.php?pagina=<?=$i; ?>&pesquisa=1&ind_pessoa=<?php echo $ind_pessoa; ?>&nom_nome=<?php echo $nom_nome; ?>&nom_apelido=<?php echo $nom_apelido; ?>&cod_cpf_cnpj=<?php echo $cod_cpf_cnpj; ?>&cod_rg=<?php echo $cod_rg; ?>&dat_nascimento=<?php echo $dat_nascimento; ?>&cod_ie=<?php echo $cod_ie;?>#pes"> <?php echo $i;?> </a></li><?php }
                                   
                                   ?>
                                    <li>
                                        <a href="form_cad_pessoa.php?pagina=<?=$num_paginas; ?>&pesquisa=1&ind_pessoa=<?php echo $ind_pessoa; ?>&nom_nome=<?php echo $nom_nome; ?>&nom_apelido=<?php echo $nom_apelido; ?>&cod_cpf_cnpj=<?php echo $cod_cpf_cnpj; ?>&cod_rg=<?php echo $cod_rg; ?>&dat_nascimento=<?php echo $dat_nascimento; ?>&cod_ie=<?php echo $cod_ie;?>#pes" aria-label="Next">
                                             <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>

                            </ul>

                            <a href="<?php echo$actual_link;?>" class="btn btn-default" style="margin-top: 18px;padding: 17px 20px;float: right;"><i class="fas fa-angle-double-up" title="Ir ao topo"></i></a>


                            <div class="text-right form-group ">
                                        <div class="text-left">

                                            <label class="text-danger">IMPRESSÃO DE ETIQUETAS</label><br>
                                                <input type="radio" name="tip_et" id="tip_et" value="Q">
                                                Folha com <b>14 etiquetas</b> (02 colunas x 07 linhas - 55 caracteres por linha da etiqueta)<br>
                                                <input type="radio" name="tip_et" id="tip_et" value="V" >
                                                Folha com <b>20 etiquetas</b> (02 colunas x 10 linhas - 55 caracteres por linha da etiqueta)<br>
                                                <input type="radio" name="tip_et" id="tip_et" value="T" checked>
                                                Folha com <b>30 etiquetas</b> (03 colunas x 10 linhas - 35 caracteres por linha da etiqueta)<br>
                                            <div style="line-height: 50px;"><input type="checkbox" name="op_re" id="op_re" checked > Deseja imprimir <b>Remetente (Agente Político)</b>?</div>
                                            Deseja <b>pular quantas linhas</b> da folha de etiquetas?
                                            <input name="pular" id="pular" type="number" min="0" max="9">
                                            <button type="button" title="Gerar documento para impressão de Etiquetas" onclick="checaPulaLinhaEtiquetas();"><i class="fas fa-print" style="font-size:20px; color:000000;"></i></button>
                                        </div>
                                </form>
                            </div>
                        </nav>

                <?php
                        }
                    }else{
                        echo "";
                    }
                ?>

                <script type="text/javascript">
                    function modal(url, title, w, h){
                        var left = (screen.width/2)-(w/2);
                        var top = (screen.height/2)-(h/1.5);
                        return window.open(url, title, 'width='+w+', height='+h+', top='+top+', left='+left, '_blank');
                    }

                    function modal_foto(url, title, w, h){
                        //var left = (screen.width/2)-(w/2);
                        //var top = (screen.height/2)-(h/1.5);
                        //window.open(url, title, 'width='+w+', height='+h+', top='+top+', left='+left, '_blank');
                        window.open(url,'_blank');
                    }

                    function limpa_formulario_cep(){
                        $("#endereco").val("");
                        $("#bairro").val("");
                        $("#cidade").val("");
                        $('#estado').val("").trigger('change'); //.meuselect (select2)
                    }

                    //Preenche os campos apartir do CEP
                    //como fazer com que o estado seja selecionado ??
                    $("#num_cep").blur(function(){
                        var cep = this.value.replace(/[^0-9]/, "");
                        var validacep = /^[0-9]{8}$/;
                        if(validacep.test(cep)) {
                            document.getElementById('messagecep').innerHTML = '';
//                            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dadosRetorno) {
//                                if (!("erro" in dadosRetorno)) {
//                                    $("#endereco").val(dadosRetorno.logradouro);
//                                    $("#bairro").val(dadosRetorno.bairro);
//                                    $("#cidade").val(dadosRetorno.localidade);
//                                    $('#estado').val(dadosRetorno.uf).trigger('change'); //.meuselect (select2)
//                                }else{
//                                    alert("CEP não encontrado.");
//                                    limpa_formulario_cep();
//                                }
//                            });

                            $.ajax({
                                url: "https://viacep.com.br/ws/"+ cep +"/json/?callback=?",
                                dataType: 'json',
                                timeout: 2000,
                                success: function(dadosRetorno) {
                                    if (!("erro" in dadosRetorno)) {
                                        $("#endereco").val(dadosRetorno.logradouro);
                                        $("#bairro").val(dadosRetorno.bairro);
                                        $("#cidade").val(dadosRetorno.localidade);
                                        $('#estado').val(dadosRetorno.uf).trigger('change'); //.meuselect (select2)
                                    }else{
                                        document.getElementById('messagecep').innerHTML = 'CEP não encontrado.';
                                        //alert("CEP não encontrado.");
                                        limpa_formulario_cep();
                                    }
                                },
                                error: function(dadosRetorno) {
                                    alert("Serviço de busca de CEP indisponível");
                                }
                            });
                        }else{
                            //alert("Formato de CEP inválido.");
                            limpa_formulario_cep();
                        }
                    });


        $("input[name='cod_cpf_cnpj']").on('blur', function(){
            var cod_cpf_cnpj = $("input[name='cod_cpf_cnpj']").val();
            $.post('action_cad_pessoa.php', {cod_cpf_cnpj: cod_cpf_cnpj} , function(data){

                if(data == 1){
                    document.getElementById('msgCPF').innerHTML = 'Já cadastrado.';
                } else{
                    document.getElementById('msgCPF').innerHTML = '';
                }
            });
        });

        </script>


            </div>
            <?php include 'includes/footer.html';
        } else { ?>
            <p>
                <span class="error">Você não tem autorização para acessar esta página.</span> Please <a href="index.php">login</a>.
            </p>
        <?php } ?>
    </body>
</html>
