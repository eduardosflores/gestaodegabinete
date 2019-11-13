<!--- 
Descrição: Cabeçalho do sistema
--->
<!-- barra cinza -->
<nav class="navbar navbar-inverse navbar-fixed-top nav1">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <?php if ( isset($_SESSION['ind_status']) && $_SESSION['ind_status'] == 'N' ){ 
          echo "<li><a class='navbar-brand' href='form_troca_senha.php'><b>Gestão de Gabinete</b></a><li>";
        }
        else{
          echo "<li><a class='navbar-brand' href='form_inicio.php'><b>Gestão de Gabinete</b></a><li>";
        }?>
        <li class="nav-exit"><a href="login/logout.php"><i class="fas fa-sign-out-alt"></i> Sair (<?php if (login_check($mysqli) == true || (isset($_SESSION['ind_status']) && $_SESSION['ind_status'] == 'N' )){ echo htmlentities($_SESSION['username']); } ?>)</a></li>
      </ul>
    </div>
</nav>

<!-- barra branca -->
<nav class="navbar navbar-default navbar-fixed-top nav2">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
      </div>

      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <?php if ( isset($_SESSION['ind_status']) && $_SESSION['ind_status'] == 'N' ){ 
              echo "<li><a  href='form_troca_senha.php'><b> AGENDA</b></a></li>";
            } else {
              echo "<li><a  href='form_agenda.php'><b> AGENDA</b></a></li>";
            }
            ?>

            <?php if ( isset($_SESSION['ind_status']) && $_SESSION['ind_status'] == 'N' ){ 
              echo "<li><a  href='form_troca_senha.php'><b> PESSOA</b></a></li>";
            } else {
              echo "<li><a href='form_cad_pessoa.php'><b> PESSOA</b></a></li>";
            }
            ?>

            <?php if ( isset($_SESSION['ind_status']) && $_SESSION['ind_status'] == 'N' ){ 
              echo "<li><a  href='form_troca_senha.php'><b> ATENDIMENTO</b></a></li>";
            } else {
              echo "<li><a href='form_cad_atendimento.php'><b> ATENDIMENTO</b></a></li>";
            }
            ?>

            <?php if ( isset($_SESSION['ind_status']) && $_SESSION['ind_status'] == 'N' ){ 
              echo "<li><a  href='form_troca_senha.php'><b> DOCUMENTO</b></a></li>";
            } else {
              echo "<li><a href='form_cad_documento.php'><b> DOCUMENTO</b></a></li>";
            }
            ?>

            <?php if ( isset($_SESSION['ind_status']) && $_SESSION['ind_status'] == 'N' ){ 
              echo "<li><a  href='form_troca_senha.php'><b> CADASTROS&#9662;</b></a></li>";
            } else { ?>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <b>CADASTROS&#9662;</b></a>
                <ul class="dropdown-menu">
                    <li><a href="form_cad_cargo_politico.php"><b>Cargo Político</b></a></li>
                    <li><a href="form_cad_vereador.php"><b>Agente Político</b></a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="form_cad_agenda.php"><b>Chaves do Google Agenda</b></a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="form_cad_tipo_atendimento.php"><b>Tipo de Atendimento</b></a></li>
                    <li><a href="form_cad_status_atendimento.php"><b>Situação do Atendimento</b></a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="form_cad_tipo_documento.php"><b>Tipo de Documento</b></a></li>
                    <li><a href="form_cad_status_documento.php"><b>Situação do Documento</b></a></li>
                    <li><a href="form_cad_unidade.php"><b>Unidade Administrativa (Documento)</b></a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="form_cad_usuario.php"><b>Usuários do Sistema</b></a></li>
                </ul>
              </li>
            <?php } ?>

            <?php if ( isset($_SESSION['ind_status']) && $_SESSION['ind_status'] == 'N' ){ 
              echo "<li><a  href='form_troca_senha.php'><b> RELATÓRIOS&#9662;</b></a></li>";
            } else { ?>

              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <b>RELATÓRIOS&#9662;</b></a>
                <ul class="dropdown-menu">
                    <li><a href="form_pesquisar_atendimento.php"><b>Atendimentos</b></a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="form_pesquisar_documento.php"><b>Documentos</b></a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="form_pesquisar_aniversario.php"><b>Etiquetas de Aniversariantes</b></a></li>
                </ul>
            <?php } ?>

            <?php if ( isset($_SESSION['ind_status']) && $_SESSION['ind_status'] == 'N' ){ 
              echo "<li><a  href='form_troca_senha.php'><b> AJUDA&#9662;</b></a></li>";
            } else { ?>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <b>AJUDA&#9662;</b></a>
                <ul class="dropdown-menu">
                    <li><a href="form_sobre.php"><b>Sobre o Sistema</b></a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="form_manual.php"><b>Manual do Usuário</b></a></li>
                </ul>
              </li>
            <?php } ?>
        </ul>
      </div><!--/.nav-collapse -->
  </div>
</nav>