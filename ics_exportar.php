<?php
include_once './agenda/bdd.php';
include_once 'includes/conexao.php';
include_once 'includes/functions.php';
include 'includes/ics.php';

session_start();

$sql = "SELECT id, title, start, end, txt_obs FROM gab_agenda";

$req = $bdd->prepare($sql);
$req->execute();

$event = new ICS('eventos_agenda_gabinete');
foreach ($req as $row){
    $event->add($row['id'], $row['start'], $row['end'], $row['title'], $row['txt_obs']);
}

$event->show();