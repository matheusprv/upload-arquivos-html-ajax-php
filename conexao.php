<?php
    $servername = ""; 
    $username = ""; 
    $password = ""; 
    $dbname = ""; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    //checar conexão
    if($conn->connect_error){
        die("Falha na conexão: " . $conn->connect_error);
    }    
    else{
        //echo "Conectado";
    }

?>