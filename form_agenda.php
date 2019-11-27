<?php 
    include_once 'includes/conexao.php';
    include_once 'includes/functions.php';
    session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

    <?php include 'includes/head.html'; ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" type="text/css" href="./fullcalendar/core/main.min.css">
    <link rel="stylesheet" type="text/css" href="./fullcalendar/daygrid/main.min.css">
    <link rel="stylesheet" type="text/css" href="./fullcalendar/timegrid/main.min.css">
    <link rel="stylesheet" type="text/css" href="./fullcalendar/list/main.min.css">

    <style>
        #calendar{font-size: 14px !important;}
    </style>

    <title>Agenda</title>
</head>
<body>
    <?php
    if (login_check($mysqli) == true){
        include 'includes/cabecalho.php'; 
        if ($resultado=$mysqli->query("SELECT api_key, calendar_id FROM gab_calendar_key")){
            if ($resultado->num_rows){
                $aux=1;
                $linha=$resultado->fetch_object();
    ?>

    <div id="main" class="container">
    <h1 class="h2">Agenda de Eventos</h1>

    <div id='calendar'></div>

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
                    <h2 class="h3 text-center" id="titulo" style="margin-top: 0px;"></h2>
                    <p>
                        <strong><span>Quando: </span></strong>
                        <span id="duracao"></span>
                    </p>
                    <p>
                        <strong><span id="titulolocal">Onde: </span></strong>
                        <span id="local"></span>
                    </p>
                    <p>
                        <strong><span id="titulodescricao">Descrição: </span></strong>
                        <span id="descricao"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="main" class="container" style="margin-top: 20px;">
        <p>Para adicionar a Agenda, siga os passos descritos na <a href="https://support.google.com/calendar/answer/37100?hl=pt-BR">página "Adicionar a agenda do Google de outra pessoa", item "Adicionar usando um link"</a>.</p>
        <p>Para verificar a sincronização com o Google Agenda, acesse a <a href="https://support.google.com/calendar/answer/6261951?co=GENIE.Platform%3DAndroid&hl=pt-BR">página "Corrigir problemas de sincronização com o aplicativo Google Agenda"</a>.</p>
    </div>

    <script src="./fullcalendar/core/locales/pt-br.js"></script>
    <script src="./fullcalendar/core/main.min.js"></script>
    <script src="./fullcalendar/daygrid/main.min.js"></script>
    <script src="./fullcalendar/timegrid/main.min.js"></script>
    <script src="./fullcalendar/list/main.min.js"></script>
    <script src="./fullcalendar/google-calendar/main.min.js"></script>
    <script src="./fullcalendar/moment/main.min.js"></script>
    <script src="./fullcalendar/moment/moment-with-locales.min.js"></script>
    <script src="./fullcalendar/moment/moment-timezone-with-data.min.js"></script>
    <script src="./fullcalendar/bootstrap/main.min.js"></script>

    <script>
        $(document).ready(function () {
            var view
            var header
            var footer
            if ($(window).width() <= 767) {
                view = 'listMonth';
                header = {
                    left : 'prev',
                    center : 'title',
                    right : 'next'
                };
                footer = {
                    left: '',
                    center: 'today',
                    right: ''
                };
            } else{
                view = 'dayGridMonth';
                header = {
                    left : 'prev,today,next',
                    center : "title",
                    right : "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                };
                footer = {
                    left: "prev,today,next",
                    center: '',
                    right: ''
                };
            }
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid', 'timeGrid', 'list', 'googleCalendar', 'bootstrap'],
                googleCalendarApiKey: '<?php echo escape($linha->api_key) ?>',
                events: {
                    googleCalendarId: '<?php echo escape($linha->calendar_id) ?>'
                },
                locale: 'pt-br',
                timeZone: '<?php echo date_default_timezone_get() ?>',
                themeSystem: 'bootstrap',
                defaultView: view,
                header: header,
                footer: footer,
                
                // titleFormat: {year: 'numeric', month: 'short'},
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: false
                },
                eventLimit: true, // limit the number of events to the height of the day cell

                height:700,
	  
                views: {
                        dayGridMonth: { // name of view
                            showNonCurrentDates: false, //dates in the previous or next month should NOT be rendered at all
                            fixedWeekCount:false //the calendar will have either 4, 5, or 6 weeks, depending on the month
                        }
                },
                
                //function resize layout responsive 
                windowResize: function(view) {
                    if ($(window).width() <= 767){
                        calendar.changeView('listMonth');
                        calendar.setOption('header', {
                            left: 'prev',
                            center: 'title',
                            right: 'next'
                         });
                        calendar.setOption('footer', {
                            left: '',
                            center: 'today',
                            right: ''
                         });
                    } else {
                        calendar.changeView('dayGridMonth');
                        calendar.setOption('header', { 
                            left: 'prev,today,next',
                            center: 'title', 
                            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                        });
                        calendar.setOption('footer', { 
                            left: 'prev,today,next',
                            center: '',
                            right: ''
                        });
                    }
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
    </div>

    <?php    }else{ ?>
        <div id="main" class="container" style="margin-top: 20px;">
            <p>Para utilizar a Agenda no sistema, é necessário <a href="form_cad_agenda.php">cadastrar as Chaves do Google Agenda.</a></p>
        </div>
    <?php    
            }
        }
        include 'includes/footer.html';
    } else {
    ?>
           <p><span class="error">Você não tem autorização para acessar esta página.</span> Please <a href="index.php">login</a>.</p>
    <?php } ?>
    </body>
</html>