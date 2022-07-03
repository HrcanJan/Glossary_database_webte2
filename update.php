<?php
header('Content-Type: application/json; charset=utf-8');

if(isset($_POST['updateTitle'])) {
    $servername = "localhost";
    $username = "xhrcan";
    $password = "SQsBCnIEq5Vnxum";
    $dbname = "glosar";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $stmt = $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare( "UPDATE translations t 
                                        INNER JOIN word w
                                        ON t.word_id = w.id
                                        SET t.description=:desc  
                                        WHERE t.title like :title");

        $title= "%".$_POST['updateTitle']."%";
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":desc", $_POST['updated']);


        // execute the query
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        echo "Success";
    } catch (PDOException $e) {
        echo "Error: ".$e->getMessage();
    }

}
