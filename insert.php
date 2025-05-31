<?php

require_once('config.php');

$nome=$connection->real_escape_string($_POST['nome']);
$cognome=$connection->real_escape_string($_POST['cognome']);
$email=$connection->real_escape_string($_POST['email']);

$sql="INSERT INTO persone (nome, cognome, email) VALUES ('$nome', '$cognome', '$email')";
if($connection->query($sql)===true){
    $data=[
        "messaggio"=>"Riga inserita con successo",
        "response"=>1
    ];
    echo json_encode($data);
}else{
    $data=[
        "messaggio"=>$connection->error,
        "response"=>0
    ];
    echo json_encode($data);
}
