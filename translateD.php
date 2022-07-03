<?php
header('Content-Type: application/json; charset=utf-8');
if(isset($_GET['search'])) {
    $servername = "localhost";
    $username = "xhrcan";
    $password = "SQsBCnIEq5Vnxum";
    $dbname = "glosar";

    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare(
            "select
                        t1.title as searchTitle,
                        t1.description as searchDescription,
                        t2.title as translatedTitle,
                        t2.description as translatedDescription,
                        t1.word_id
                        
                    from translations t1
                    join translations t2
                        on t1.word_id = t2.word_id
                    join languages   
                        on t1.language_id = languages.id
                    where
                        languages.code = :language and
                    (t1.description like :search) and 
                    t1.id <> t2.id"
        );
        $search = "%".$_GET['search']."%";
        $stmt->bindParam(":search", $search);
        $stmt->bindParam(":language", $_GET['language_code']);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        echo json_encode($result);
    } catch (PDOException $e) {
        echo "Error: ".$e->getMessage();
    }
}
