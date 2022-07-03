<?php
header('Content-Type: application/json; charset=utf-8');
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data)) {
    $servername = "localhost";
    $username = "xhrcan";
    $password = "SQsBCnIEq5Vnxum";
    $dbname = "glosar";

    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare(
            "delete from word where id = :id"
        );
        $stmt->bindParam(":id",  $data['id'], PDO::PARAM_INT);
        $stmt->execute();

        $result = ["deleted" => true, "message" => "Deleted successfully"];

        echo json_encode($result);
    } catch (PDOException $e) {
        $result = ["deleted" => false, "message" => "Error: ".$e->getMessage()];
        echo json_encode($result);
    }
}