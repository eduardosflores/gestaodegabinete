<?php

$rawData = $_POST['imgBase64'];
$filteredData = explode(',', $rawData);
$unencoded = base64_decode($filteredData[1]);

$datime = date("Y-m-d-H.i.s", time() ) ; # - 3600*7

$userid  = $_POST['userid'] ;

if ($_POST['insere']=="S"){
    //inserção
    $fp = fopen('temp/'.$userid.'.jpg', 'w');
}
else{
    //alteração
    $fp = fopen('fotos/'.$userid.'.jpg', 'w');
}
fwrite($fp, $unencoded);
fclose($fp);
                    
  // next, update or insert a users record  