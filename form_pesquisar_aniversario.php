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
        <script>
        window.onload = function()
        {
            carregadias_ini();
            carregadias_fim();
        }
       function carregadias_ini() {
            var select = document.getElementById("dias_inicio");
            select.empty();
            var mes=document.getElementById('mes_inicio').value;
            var options = getDiasMes(mes, 2016);
            for (var i = 0; i < options.length; i++) {
                var opt = options[i];
                var el = document.createElement("option");
                el.textContent = opt;
                el.value = opt;
                select.appendChild(el);
            }
        }
        function carregadias_fim() {          
            var select = document.getElementById("dias_fim");
            select.empty();
            var mes=document.getElementById('mes_fim').value;
            var options = getDiasMes(mes, 2016);
            for (var i = 0; i < options.length; i++) {
                var opt = options[i];
                var el = document.createElement("option");
                el.textContent = opt;
                el.value = opt;
                select.appendChild(el);
            }
        }

        function getDiasMes(month, year) {
            month--;
            var date = new Date(year, month, 1);
            var days = [];
            while (date.getMonth() === month) {
               days.push(date.getDate());
               date.setDate(date.getDate() + 1);
            }
            return days;
        }

        function checaPulaLinhaEtiquetas()
        {
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
        
        function pesquisar() 
            {
                document.form.action = "form_pesquisar_aniversario.php?#pes";
                document.form.submit();
            }
        </script>
    </head>
    
    <body>
        <?php if (login_check($mysqli) == true) {
                include 'includes/cabecalho.php';
                
               
            ?>
            <div class="container" id="main">
                <div class="page-header">
                    <?php if (isset($_GET['msg'])){
                        echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['msg'].'</strong></div>';                     
                   }
                 else if (isset($_GET['err'])){
                        echo '<div class="alert alert-warning fade in "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['err'].'</strong></div>';
                 }
                 ?>
                    <h1 class="h2">Relatório: Etiquetas de Aniversariantes</h1>
                </div>
           
                <form name="form" class="form-horizontal" type="post">
                <div class="form-group">
                        <label class="col-md-2 control-label">Data Inicial:</label>
                        <div class="col-md-1">
                            <select required name="dat_inicio_dia" id="dias_inicio" class="form-control input-sm" value="<?php if (isset($_GET['aux'])) {echo converteDataBR($_GET['dat_inicio']);} if (empty($_GET))     echo date('d/m/Y'); ?>">
                                <option value="1" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==1)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==1)) echo "selected"; ?>>1</option>
                                <option value="2" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==2)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==2)) echo "selected";?>>2</option>
                                <option value="3" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==3)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==3)) echo "selected";?>>3</option>
                                <option value="4" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==4)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==4)) echo "selected";?>>4</option>
                                <option value="5" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==5)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==5)) echo "selected";?>>5</option>
                                <option value="6" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==6)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==6)) echo "selected";?>>6</option>
                                <option value="7" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==7)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==7)) echo "selected";?>>7</option>
                                <option value="8" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==8)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==8)) echo "selected";?>>8</option>
                                <option value="9" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==9)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==9)) echo "selected";?>>9</option>
                                <option value="10" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==10)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==10)) echo "selected";?>>10</option>
                                <option value="11" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==11)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==11)) echo "selected";?>>11</option>
                                <option value="12" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==12)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==12)) echo "selected";?>>12</option>
                                <option value="13" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==13)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==13)) echo "selected";?>>13</option>
                                <option value="14" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==14)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==14)) echo "selected";?>>14</option>
                                <option value="15" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==15)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==15)) echo "selected";?>>15</option>
                                <option value="16" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==16)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==16)) echo "selected";?>>16</option>
                                <option value="17" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==17)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==17)) echo "selected";?>>17</option>
                                <option value="18" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==18)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==18)) echo "selected";?>>18</option>
                                <option value="19" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==19)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==19)) echo "selected";?>>19</option>
                                <option value="20" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==20)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==20)) echo "selected";?>>20</option>
                                <option value="21" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==21)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==21)) echo "selected";?>>21</option>
                                <option value="22" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==22)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==22)) echo "selected";?>>22</option>
                                <option value="23" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==23)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==23)) echo "selected";?>>23</option>
                                <option value="24" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==24)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==24)) echo "selected";?>>24</option>
                                <option value="25" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==25)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==25)) echo "selected";?>>25</option>
                                <option value="26" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==26)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==26)) echo "selected";?>>26</option>
                                <option value="27" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==27)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==27)) echo "selected";?>>27</option>
                                <option value="28" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==28)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==28)) echo "selected";?>>28</option>
                                <option value="29" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==29)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==29)) echo "selected";?>>29</option>
                                <option value="30" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==30)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==30)) echo "selected";?>>30</option>
                                <option value="31" <?php if (!isset($_GET['dat_inicio_dia']) AND (DATE('d')==31)) {echo "selected";} if (isset($_GET['dat_inicio_dia']) AND !empty($_GET['dat_inicio_dia'] AND $_GET['dat_inicio_dia']==31)) echo "selected";?>>31</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select required name="dat_inicio_mes" class="form-control input-md" id="mes_inicio" onchange="carregadias_ini();">
                                <option value="01" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==1)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==1)) echo "selected"; ?>>Janeiro</option>
                                <option value="02" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==2)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==2)) echo "selected";?>>Fevereiro</option>
                                <option value="03" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==3)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==3)) echo "selected";?>>Março</option>
                                <option value="04" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==4)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==4)) echo "selected";?>>Abril</option>
                                <option value="05" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==5)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==5)) echo "selected";?>>Maio</option>
                                <option value="06" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==6)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==6)) echo "selected";?>>Junho</option>
                                <option value="07" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==7)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==7)) echo "selected";?>>Julho</option>
                                <option value="08" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==8)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==8)) echo "selected";?>>Agosto</option>
                                <option value="09" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==9)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==9)) echo "selected";?>>Setembro</option>
                                <option value="10" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==10)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==10)) echo "selected";?>>Outubro</option>
                                <option value="11" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==11)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==11)) echo "selected";?>>Novembro</option>
                                <option value="12" <?php if (!isset($_GET['dat_inicio_mes']) AND (DATE('m')==12)) {echo "selected";} if (isset($_GET['dat_inicio_mes']) AND !empty($_GET['dat_inicio_mes'] AND $_GET['dat_inicio_mes']==12)) echo "selected";?>>Dezembro</option>
                            </select>                                                    
                        </div>
                </div>
                <div class="form-group">
                        <label class="col-md-2 control-label">Data Final:</label>
                        <div class="col-md-1">
                            <select required name="dat_fim_dia" id="dias_fim" class="form-control input-sm">
                                <option value="1" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==1)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==1)) echo "selected"; ?>>1</option>
                                <option value="2" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==2)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==2)) echo "selected";?>>2</option>
                                <option value="3" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==3)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==3)) echo "selected";?>>3</option>
                                <option value="4" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==4)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==4)) echo "selected";?>>4</option>
                                <option value="5" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==5)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==5)) echo "selected";?>>5</option>
                                <option value="6" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==6)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==6)) echo "selected";?>>6</option>
                                <option value="7" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==7)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==7)) echo "selected";?>>7</option>
                                <option value="8" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==8)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==8)) echo "selected";?>>8</option>
                                <option value="9" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==9)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==9)) echo "selected";?>>9</option>
                                <option value="10" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==10)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==10)) echo "selected";?>>10</option>
                                <option value="11" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==11)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==11)) echo "selected";?>>11</option>
                                <option value="12" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==12)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==12)) echo "selected";?>>12</option>
                                <option value="13" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==13)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==13)) echo "selected";?>>13</option>
                                <option value="14" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==14)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==14)) echo "selected";?>>14</option>
                                <option value="15" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==15)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==15)) echo "selected";?>>15</option>
                                <option value="16" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==16)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==16)) echo "selected";?>>16</option>
                                <option value="17" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==17)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==17)) echo "selected";?>>17</option>
                                <option value="18" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==18)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==18)) echo "selected";?>>18</option>
                                <option value="19" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==19)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==19)) echo "selected";?>>19</option>
                                <option value="20" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==20)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==20)) echo "selected";?>>20</option>
                                <option value="21" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==21)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==21)) echo "selected";?>>21</option>
                                <option value="22" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==22)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==22)) echo "selected";?>>22</option>
                                <option value="23" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==23)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==23)) echo "selected";?>>23</option>
                                <option value="24" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==24)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==24)) echo "selected";?>>24</option>
                                <option value="25" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==25)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==25)) echo "selected";?>>25</option>
                                <option value="26" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==26)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==26)) echo "selected";?>>26</option>
                                <option value="27" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==27)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==27)) echo "selected";?>>27</option>
                                <option value="28" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==28)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==28)) echo "selected";?>>28</option>
                                <option value="29" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==29)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==29)) echo "selected";?>>29</option>
                                <option value="30" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==30)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==30)) echo "selected";?>>30</option>
                                <option value="31" <?php if (!isset($_GET['dat_fim_dia']) AND (DATE('d')==31)) {echo "selected";} if (isset($_GET['dat_fim_dia']) AND !empty($_GET['dat_fim_dia'] AND $_GET['dat_fim_dia']==31)) echo "selected";?>>31</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select required name="dat_fim_mes" class="form-control input-md" onchange="carregadias_fim();" id="mes_fim" value="<?php if (isset($_GET['aux'])) {echo converteDataBR($_GET['dat_inicio']);} if (empty($_GET))     echo date('d/m/Y'); ?>">
                                <option value="01" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==1)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==1)) echo "selected";?>>Janeiro</option>
                                <option value="02" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==2)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==2)) echo "selected";?>>Fevereiro</option>
                                <option value="03" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==3)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==3)) echo "selected";?>>Março</option>
                                <option value="04" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==4)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==4)) echo "selected";?>>Abril</option>
                                <option value="05" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==5)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==5)) echo "selected";?>>Maio</option>
                                <option value="06" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==6)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==6)) echo "selected";?>>Junho</option>
                                <option value="07" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==7)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==7)) echo "selected";?>>Julho</option>
                                <option value="08" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==8)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==8)) echo "selected";?>>Agosto</option>
                                <option value="09" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==9)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==9)) echo "selected";?>>Setembro</option>
                                <option value="10" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==10)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==10)) echo "selected";?>>Outubro</option>
                                <option value="11" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==11)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==11)) echo "selected";?>>Novembro</option>
                                <option value="12" <?php if (!isset($_GET['dat_fim_mes']) AND (DATE('m')==12)) {echo "selected";} if (isset($_GET['dat_fim_mes']) AND !empty($_GET['dat_fim_mes'] AND $_GET['dat_fim_mes']==12)) echo "selected";?>>Dezembro</option>
                            </select>                       
                        </div>
                </div>
                <div class="form-group">
                     <div class="col-md-5 text-center">
                        <input type="button" id="pes" class="btn btn-default" value="Pesquisar" onclick="pesquisar();"> 
                        
                        <input type="reset" class="btn btn-default" value="Limpar" onclick="window.location='form_pesquisar_aniversario.php';">
                    </div>
                </div>  
                </form>

                <?php 
                if (isset($_GET['dat_inicio_dia']) and isset($_GET['dat_fim_mes']) and isset($_GET['dat_fim_dia']) and isset($_GET['dat_fim_mes']))
                {
                    $data_inicio_dia=$_GET['dat_inicio_dia'];
                    $data_inicio_mes=$_GET['dat_inicio_mes'];
                    $data_fim_dia=$_GET['dat_fim_dia'];
                    $data_fim_mes=$_GET['dat_fim_mes'];
                    $sql2="SELECT nom_nome,dat_nascimento, nom_endereco, nom_numero, nom_complemento, nom_bairro, nom_cidade,nom_estado, num_cep, ind_pessoa, cod_rg, cod_cpf_cnpj, cod_ie, nom_re ".
                          " FROM gab_pessoa  ".
                          " WHERE ind_status='A' and (($data_inicio_mes<MONTH(dat_nascimento)) OR ($data_inicio_dia<=DAY(dat_nascimento) AND $data_inicio_mes<=MONTH(dat_nascimento)))  AND (($data_fim_mes>MONTH(dat_nascimento)) OR ($data_fim_mes=MONTH(dat_nascimento)AND  $data_fim_dia>=DAY(dat_nascimento))) ORDER BY dat_nascimento";
                  
                    $resultado2=$mysqli->query($sql2);
                           $_SESSION['sql']=$sql2;
                           
                }
                else
                {
                    $sql2="SELECT nom_nome,dat_nascimento, nom_endereco, nom_numero, nom_complemento,  nom_bairro, nom_cidade,nom_estado, num_cep, ind_pessoa, cod_rg, cod_cpf_cnpj, cod_ie, nom_re ".
                          " FROM gab_pessoa ".
                          " WHERE ind_status='A' and ((MONTH(CURDATE())<MONTH(dat_nascimento)) OR (DAY(CURDATE())<=DAY(dat_nascimento) AND MONTH(CURDATE())<=MONTH(dat_nascimento))) AND ((MONTH(CURDATE())>MONTH(dat_nascimento)) OR (MONTH(CURDATE())=MONTH(dat_nascimento)AND DAY(CURDATE())>=DAY(dat_nascimento))) ORDER BY dat_nascimento";
                   $resultado2=$mysqli->query($sql2);
                           $_SESSION['sql']=$sql2;
                }
                
                if ($resultado2->num_rows){
                ?>
                <br>
                    <div class="table-of row">
                        <table id="example" class="mtab table table-striped table-hover table-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Doc. Identificação</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php while($linha=$resultado2->fetch_object()){?>
                                <tr>
                                    <td  width='50%'><?php echo escape($linha->nom_nome); ?></td>
                                    <td  width='30%'>
                                        <?php if($linha->ind_pessoa == "PF" && !empty($linha->cod_rg)){ echo "<b> RG:</b>".escape($linha->cod_rg); }
                                              if ($linha->ind_pessoa == "PF" && !empty($linha->cod_cpf_cnpj)){ echo "<b> CPF:</b>".escape($linha->cod_cpf_cnpj); }
                                              if ($linha->ind_pessoa == "PJ" && !empty($linha->cod_cpf_cnpj)){ echo "<b> CNPJ:</b>".escape($linha->cod_cpf_cnpj); }
                                              if ($linha->ind_pessoa == "PJ" && !empty($linha->cod_ie)){ echo "<b> IE:</b>".escape($linha->cod_ie); }
                                        ?>
                                    </td>
                                    <td  width='20%'><?php echo escape(converteDataBR($linha->dat_nascimento)); ?></td>
                                    
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . "#pes";?>
                <a href="<?php echo$actual_link;?>" class="btn btn-default" style="margin-top: 1px;padding: 17px 20px;float: right;" title="Ir ao topo"><i class="fas fa-angle-double-up"></i></a>
                <div class="text-right form-group ">
                    <form name="form_etiquetas" action="form_cad_pessoa_etiqueta_pdf.php" target="_blank" type="post">  
                            <div class="text-left">

                                <label class="text-danger">IMPRESSÃO DE ETIQUETAS</label><br>
                                    <input type="radio" name="tip_et" id="tip_et" value="Q">
                                    Folha com <b>14 etiquetas</b> (02 colunas x 07 linhas - 55 caracteres por linha da etiqueta)<br>
                                    <input type="radio" name="tip_et" id="tip_et" value="V" >
                                    Folha com <b>20 etiquetas</b> (02 colunas x 10 linhas - 55 caracteres por linha da etiqueta)<br>
                                    <input type="radio" name="tip_et" id="tip_et" value="T" checked>
                                    Folha com <b>30 etiquetas</b> (03 colunas x 10 linhas - 35 caracteres por linha da etiqueta)<br>
                                <div style="line-height: 50px;"><input type="checkbox" name="op_re" id="op_re" checked > Deseja imprimir <b>Remetente (Parlamentar)</b>?</div>
                                Deseja <b>pular quantas linhas</b> da folha de etiquetas?
                                <input name="pular" id="pular" type="number" min="0" max="9" >
                                <input type="hidden" name="origem" value="paginicial">
                                <button type="button" title="Gerar documento para impressão de Etiquetas" onclick="checaPulaLinhaEtiquetas();"><i class="fas fa-print" style="font-size:20px; color:000000;"></i></button>
                            </div>
                    </form>    
                </div>
                <?php  }else
                            {
                                echo ("Não há Aniversariante no período selecionado.");
                            } ?>         
                </div>
                <?php include 'includes/footer.html';
                    } else { ?>
                    <p>
                         <span class="error">Você não tem autorização para acessar esta página.</span> Please <a href="index.php">login</a>.
                    </p>
                <?php } ?>
    </body>
</html>