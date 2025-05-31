<?php

require_once('config.php');

$id = $_POST['id'];

$sql = "DELETE FROM persone where id = $id";
if($connection->query($sql) === true){
    $data = [
        "messaggio" => "Riga eliminata con successo",
        "response" => 1
    ];
    echo json_encode($data);
}else{
    $data = [
        "messaggio" => "Impossibile eliminare riga",
        "response" => 0
    ];
    echo json_encode($data);
}

?>