<?php
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    
    session_start();
?>
<html>
    <head>
        <?php include 'includes/head.html'; ?>

        <link rel="stylesheet" type="text/css" href="./fullcalendar/list/main.min.css">
        <link rel="stylesheet" type="text/css" href="./fullcalendar/core/main.min.css">
        <style>
            .fc td, .fc th {
                border-style: none;
            }
        </style>
    </head>
    
    <body>
        <?php 
            if (login_check($mysqli) == true) {
                include 'includes/cabecalho.php';
        ?>
        
        <div id="main" class="container">
            <div class="page-header">
                <h1 class="h2">
                    <?php 
                    $resultado=$mysqli->query("SELECT nom_vereador, ind_sexo, img_foto FROM gab_vereador");
                    if ($resultado->num_rows){
                        $aux=1;
                        $linha=$resultado->fetch_object();
                        echo "Parlamentar ".$linha->nom_vereador;
                    }else{
                        echo "<a href=\"form_cad_vereador.php\">Bem vindo, gostaria de cadastrar o(a) Parlamentar?</a>";
                    }
                    ?>
                </h1>
            </div>

            <div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="h4 modal-title text-center">Detalhes do Evento</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <dl class="dl-horizontal">
                                <dt id="titulo"></dt>
                                <dd></dd>

                                <dt>Quando:</dt>
                                <dd id="duracao"></dd>
            
                                <dt id="titulolocal">Onde:</dt>
                                <dd id="local"></dd>
            
                                <dt id="titulodescricao">Descrição:</dt>
                                <dd id="descricao"></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Bloco Imagem Parlamentar -->
                <div class="col-md-3 img-field">
                    <div class="thumbnail">
                        <?php if (isset($aux) && !empty($linha->img_foto)){?>
                                <img src="form_cad_vereador_foto.php" />
                        <?php } else {?>
                                <img src="fotos/sem-foto.jpg" />
                        <?php } ?>
                    </div>
                </div>

                <!-- Bloco Eventos -->
                <div class="col-md-5">
                    <div class="inicio-card">
                        <div class="card-header"><a href="form_agenda.php">Agenda<i class="far fa-calendar"></i></a></div>
                        <div id='calendar'></div>
                    </div>
                </div>

                <!-- Bloco Aniversarios -->
                <div class="col-md-4">
                    <div class="inicio-card">
                        <div class="card-header"><a href="form_pesquisar_aniversario.php">Aniversários<i class="fas fa-birthday-cake"></i></a></div>
                        <div class="card-body">
                            <div class="card-sub-header"><b>hoje<?php echo " (".date('d/m/y').")" ?></b></div>
                                <?php
                                if ($resultado=$mysqli->query("SELECT nom_nome , nom_apelido,dat_nascimento FROM gab_pessoa WHERE MONTH(dat_nascimento)=MONTH(CURDATE()) AND DAY(dat_nascimento)=DAY(CURDATE())")){
                                    if ($resultado->num_rows){
                                        while($linha=$resultado->fetch_object()){
                                            if ($linha->nom_apelido!=NULL)
                                                echo "<p><b>".$linha->nom_nome."</b> \"". $linha->nom_apelido."\""."</p>";
                                            else
                                                echo "<p><b>".$linha->nom_nome."</b></p>";
                                        }
                                    }else{
                                        echo "<p>Não há aniversariante cadastrado nesta data.</p>";
                                    }
                                }
                                ?>
                            <div class="card-sub-header"><b>amanhã<?php echo " (". date('d/m/Y', strtotime("+1 day")).")" ?></b></div>
                                <?php
                                if ($resultado=$mysqli->query("SELECT nom_nome , nom_apelido,dat_nascimento FROM gab_pessoa WHERE ((MONTH(dat_nascimento)=MONTH(CURDATE()) AND DAY(dat_nascimento)=DAY(CURDATE()+1))  OR   (MONTH(dat_nascimento)=MONTH(CURDATE()+1) AND DAY(dat_nascimento)=1 AND (MONTH(CURDATE())=1 OR MONTH(CURDATE())=3 OR MONTH(CURDATE())=5 OR MONTH(CURDATE())=7 OR MONTH(CURDATE())=8 OR MONTH(CURDATE())=10 OR MONTH(CURDATE())=12) AND (DAY(CURDATE()=31))) OR (MONTH(dat_nascimento)=MONTH(CURDATE()+1) AND DAY(dat_nascimento)=1 AND (MONTH(CURDATE())=4 OR MONTH(CURDATE())=6 OR MONTH(CURDATE())=9 OR MONTH(CURDATE())=11) AND (DAY(CURDATE()=30))) OR(MONTH(dat_nascimento)=3 AND DAY(dat_nascimento)=1 AND (MONTH(CURDATE())=2)AND ((DAY(CURDATE()=28 AND YEAR(CURDATE()%4!=0)) OR (DAY(CURDATE()=29) AND YEAR(CURDATE()%4=0))))) OR(MONTH(dat_nascimento)=1 AND DAY(dat_nascimento)=1 AND MONTH(CURDATE())=12 AND DAY(CURDATE())=31)) ORDER BY dat_nascimento")){
                                    if ($resultado->num_rows){
                                        while($linha=$resultado->fetch_object()){
                                            if ($linha->nom_apelido!=NULL)
                                                echo "<p><b>".$linha->nom_nome."</b> \"". $linha->nom_apelido."\""."</p>";
                                            else
                                                echo "<p><b>".$linha->nom_nome."</b></p>";
                                        }
                                    }else{
                                        echo "<p>Não há aniversariante cadastrado nesta data.</p>";
                                    }
                                }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if ($calResul=$mysqli->query("SELECT api_key, calendar_id FROM gab_calendar_key")){
            if ($calResul->num_rows){
                $auxx=1;
                $line=$calResul->fetch_object();
        ?>

        <script src="./fullcalendar/core/locales/pt-br.js"></script>
        <script src="./fullcalendar/core/main.min.js"></script>
        <script src="./fullcalendar/list/main.min.js"></script>
        <script src="./fullcalendar/google-calendar/main.min.js"></script>
        <script src="./fullcalendar/moment/main.min.js"></script>
        <script src="./fullcalendar/moment/moment-with-locales.min.js"></script>
        <script src="./fullcalendar/moment/moment-timezone-with-data.min.js"></script>
        <script src="./fullcalendar/bootstrap/main.min.js"></script>

        <script type='text/javascript'>
            $(document).ready(function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ['list', 'googleCalendar', 'bootstrap'],
                    googleCalendarApiKey: '<?php echo escape($line->api_key) ?>',
                    events: {
                        googleCalendarId: '<?php echo escape($line->calendar_id) ?>'
                    },
                    locale: 'pt-br',
                    timeZone: 'America/Sao_Paulo',
                    themeSystem: 'bootstrap',
                    defaultView: 'listTodayTomorrow',
                    height: 500,

                    views: {
                        listTodayTomorrow: {
                            type: 'list',
                            duration: { days: 2 },
                            visibleRange: function(currentDate) {
                                // Generate a new date for manipulating in the next step
                                var startDate = new Date(currentDate.valueOf());
                                var endDate = new Date(currentDate.valueOf());

                                // Adjust the start & end dates, respectively
                                startDate.setDate(startDate.getDate() - 1); // One day in the past
                                endDate.setDate(endDate.getDate() + 2); // Two days into the future

                                return { start: startDate, end: endDate };
                            }
                        }
                    },

                    header: false,
                    listDayFormat: {
                        month: 'long',
                        year: 'numeric',
                        day: 'numeric',
                        weekday: 'long'
                    },
                    eventClick: function (info) {
                    info.jsEvent.preventDefault(); // prevent browser from visiting event's URL in the current tab
                    // console.log(info.event);
                    moment.locale('pt-BR');

                    var fim = new moment.tz(info.event.end,"UTC");
                    var ini = new moment.tz(info.event.start,"UTC");

                    var duration = moment.duration(fim.diff(ini));
                    var texto;
                    if (ini.isValid() && !fim.isValid()) { //verificar se data inicial é válida e final não é válida  - mostrar apenas data e horario iniciais
                        //OBS: Se as datas e horários inicial e final foram iguais no Google Agenda, 
                        //o horário final não é considerado/exportado pelo Google Agenda e o FullCalendar não recebe uma data válida
                        texto = ini.format("dddd, D") + " de " + ini.format("MMMM") + " de " + ini.format("YYYY") + ", a partir da(s) " + ini.format("HH:mm") + " h";
                    } else if (moment(ini).isSame(fim, 'day')) { //verificar se data inicial e final são as mesmas sem considerar horário
                        if ((ini.minutes() > 0 || ini.hours() > 0) && (fim.minutes() > 0 || fim.hours() > 0)) { //TEM HORARIO INICIAL CADASTRADO e TEM HORARIO FINAL CADASTRADO
                            texto = ini.format("dddd, D") + " de " + ini.format("MMMM") + " de " + ini.format("YYYY, HH:mm") + " h - " + fim.format("HH:mm") + " h";
                        } else if (ini.minutes() > 0 || ini.hours() > 0) {//TEM APENAS HORARIO INICIAL CADASTRADO
                            texto = ini.format("dddd, D") + " de " + ini.format("MMMM") + " de " + ini.format("YYYY") + ", a partir da(s) " + ini.format("HH:mm") + " h";
                        } else if (fim.minutes() > 0 || fim.hours() > 0) { //TEM APENAS HORARIO FINAL CADASTRADO
                            texto = ini.format("dddd, D") + " de " + ini.format("MMMM") + " de " + ini.format("YYYY") + " até à(s) " + fim.format("HH:mm") + " h";
                        } else {//NÃO TEM HORARIO CADASTRADO
                            texto = ini.format("dddd, D") + " de " + ini.format("MMMM") + " de " + ini.format("YYYY");
                        }
                    } else { //dia inicial diferente do dia final
                        if ((ini.minutes() == 0 && ini.hours() == 0) && (fim.minutes() == 0 && fim.hours() == 0) && duration.days() == 1) { //não tem horário definido e possui duração de 1 dia
                            texto = ini.format("dddd, D") + " de " + ini.format("MMMM") + " de " + ini.format("YYYY");
                        } else if ((ini.minutes() > 0 || ini.hours() > 0) && (fim.minutes() > 0 || fim.hours() > 0)) { // TEM HORARIO INICIAL CADASTRADO e TEM HORARIO FINAL CADASTRADO
                            texto = ini.format("D") + " de " + ini.format("MMMM") + " de " + ini.format("YYYY, HH:mm") + " h - " + fim.format("D") + " de " + fim.format("MMMM") + " de " + fim.format("YYYY, HH:mm") + " h";
                        } else if (ini.minutes() > 0 || ini.hours() > 0) {//TEM APENAS HORARIO INICIAL CADASTRADO
                            texto = ini.format("D") + " de " + ini.format("MMMM") + " de " + ini.format("YYYY, HH:mm") + " h - " + fim.format("D") + " de " + fim.format("MMMM") + " de " + fim.format("YYYY");
                        } else if (fim.minutes() > 0 || fim.hours() > 0) { //TEM APENAS HORARIO FINAL CADASTRADO
                            texto = ini.format("D") + " de " + ini.format("MMMM") + " de " + ini.format("YYYY") + " - " + fim.format("D") + " de " + fim.format("MMMM") + " de " + fim.format("YYYY, HH:mm") + " h ";
                        } else {//NÃO TEM HORARIO CADASTRADO
                            fim = fim.subtract(1, 'days'); //subtrai 1 dia da data final

                            if (moment(ini).isSame(fim, 'month')) { //verificar se mês e ano são os mesmos sem considerar horário
                                texto = ini.format("D") + " - " + fim.format("D") + " de " + ini.format("MMMM") + " de " + ini.format("YYYY");
                            } else {
                                texto = ini.format("D") + " de " + ini.format("MMMM") + " de " + ini.format("YYYY") + " - " + fim.format("D") + " de " + fim.format("MMMM") + " de " + fim.format("YYYY");
                            }
                        }
                    }

                    //Limpar campos
                    // $('#visualizar #titulo').text("");
                    // $('#visualizar #duracao').text("");
                    $('#visualizar #local').text("");
                    $('#visualizar #descricao').text("");

                    //Popular campos
                    $('#visualizar #titulo').text(info.event.title);
                    $('#visualizar #duracao').text(texto);

                    if (!info.event.extendedProps.location) { //local vazio
                        document.getElementById("titulolocal").style.display = "none";
                        document.getElementById("local").style.display = "none";
                    } else {//local com valor
                        document.getElementById("titulolocal").style.display = "";
                        document.getElementById("local").style.display = "";
                        $('#visualizar #local').text(info.event.extendedProps.location);
                    }

                    if (!info.event.extendedProps.description) { //descrição vazia
                        document.getElementById("titulodescricao").style.display = "none";
                        document.getElementById("descricao").style.display = "none";
                    } else {//descrição com valor
                        //console.log(info.event.extendedProps.description); 
                        document.getElementById("titulodescricao").style.display = "";
                        document.getElementById("descricao").style.display = "";
                        $('#visualizar #descricao').html(info.event.extendedProps.description);
                    }

                    $('#visualizar').modal('show');
                    return false;
                }
                });
                calendar.render();
            });
            </script>
        <?php   }else{ ?>
            <script>
            (function insertCardBody (){
                var regmsg =    `<div class="card-body">
                                    <p>Pra ter acesso a Agenda do sistema, é necessário <a href="form_cad_agenda.php">cadastrar as Chaves do Google Agenda.</a></p>
                                </div>`;
                $('#calendar').append(regmsg);

                calendarEl.appendChild(newDiv);
            })();
            </script>
        <?php    
                }
            }
            include 'includes/footer.html';
        } else { ?>
            <p>
                <span class="error">Você não tem autorização para acessar esta página.</span> Por favor faça <a href="index.php">login</a>.
            </p>
        <?php } ?>
    </body>
</html>