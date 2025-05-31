<?php

require_once('config.php');

$id = $_POST['id'];
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];

$sql="UPDATE persone SET NOME='$nome', COGNOME='$cognome', EMAIL='$email' WHERE id='$id'";
if($connection->query($sql)===true){
    $data=[
        "messaggio"=>"Riga modificata con successo",
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

?>