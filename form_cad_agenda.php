<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start(); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <?php include 'includes/head.html'; ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Cadastro Agenda</title>

</head>
<body>
    <?php 
        if (login_check($mysqli) == true) {
            include 'includes/cabecalho.php'; 
            if ($resultado=$mysqli->query("SELECT api_key, calendar_id FROM gab_calendar_key")){
                if ($resultado->num_rows){
                    $aux=1;
                    $linha=$resultado->fetch_object();
                }
            }
    ?>

    <div class="container" id="main">
        <div class="page-header">
            <?php
                if (isset($_GET['msg'])){
                    echo '<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['msg'].'</strong></div>';
                }else if (isset($_GET['err'])){
                    echo '<div class="alert alert-warning fade in "><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$_GET['err'].'</strong></div>';
                }
            ?>
        <h1 class="h2">Cadastro das Chaves do Google Agenda</h1>
        </div>

        <form id="formId" name="form" class="form-horizontal" action="action_cad_agenda.php" method="post" autocomplete="off">

            <?php
                if (isset($aux)){
                    echo "<input type='hidden' name='alt' id='alt'>";
                }
            ?>

            <div class="form-group">
                <label class="col-md-2 control-label" for="googleCalendarApiKey" autocomplete="on">Google API Key:</label>
                <div class="col-md-5">
                    <input id="googleCalendarApiKey" name="api_key" type="text" required placeholder="" class="form-control input-md"
                            value="<?php if (isset($aux)) {echo escape($linha->api_key);}?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label" for="googleCalendarId" autocomplete="on">Google Calendar ID:</label>
                <div class="col-md-5">
                    <input id="googleCalendarId" name="calendar_id" type="text" required placeholder="" class="form-control input-md"
                            value="<?php if (isset($aux)) {echo escape($linha->calendar_id);}?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3 text-right">
                    <input id="submitButton" type="submit" class="btn btn-default" <?php if (isset($aux)) { echo "value='Alterar'";} else {echo "value='Cadastrar'";}?>>
                    <input type="reset" class="btn btn-default" value="Limpar">
                </div>
            </div>
        </form>
    </div>
    <script>
        $('#submitButton').click(function(e){

            e.preventDefault();

            var
            apiKey = document.getElementById("googleCalendarApiKey").value,
            calendarId = document.getElementById("googleCalendarId").value,
            url = 'https://www.googleapis.com/calendar/v3/calendars/'+calendarId+'/events?key='+apiKey;

            var errmsg =   `<div class="alert alert-warning fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Por favor, insira um par de credenciais válidos.</strong>
                            </div>`;

            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    console.log('Request Sucessful', xhr);
                    $('#formId').submit();
                    return true;
                } else {
                    if($('.alert').length){
                        $('.alert').remove();
                    }
                    $('.page-header').prepend(errmsg);
                    console.log('Request failed', xhr);
                    return false;
                }
            };
            xhr.onerror = function () {
                console.log('Request failed', xhr);
                return false;
            };
            xhr.send();
        });
    </script>
    <?php include 'includes/footer.html';
        } else { ?>
            <p><span class="error">Você não tem autorização para acessar esta página.</span> Please <a href="index.php">login</a>.</p>
    <?php } ?>
</body>