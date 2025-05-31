<?php

require_once('config.php');

$sql = 'SELECT * FROM persone';

if($result = $connection-> query($sql)){
    if($result-> num_rows > 0){
        $data = [];
        while($row = $result-> fetch_array(MYSQLI_ASSOC)){
            $tmp;
            $tmp['id'] = $row['id'];
            $tmp['nome'] = $row['NOME'];
            $tmp['cognome'] = $row['COGNOME'];
            $tmp['email'] = $row['EMAIL'];
            array_push($data, $tmp);
        }

        echo json_encode($data);
    }
    else{
        echo "Non ci sono righe disponibili";
    }
}
else{
    echo "Errore nell'esecuzione di $sql. " . $connection->error;
}

?>