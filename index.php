<!-- Prevzate od pana Mateja Rabeka -->
<?php

require_once "MyPdo.php";
require_once "Word.php";
require_once "Translation.php";

$myPdo = new MyPDO("mysql:host=localhost;dbname=glosar", "xhrcan", "SQsBCnIEq5Vnxum");

if(isset($_FILES['file'])){

    $file = fopen($_FILES['file']['tmp_name'], "r");
    while(! feof($file)){
        $pole = fgetcsv($file, null, ';');
        $word = new Word($myPdo);
        $word->setTitle($pole[0]);
        $word->save();

        $slovakTranslation = new Translation($myPdo);
        $slovakTranslation->setTitle($pole[0]);
        $slovakTranslation->setDescription($pole[1]);
        $slovakTranslation->setLanguageId(1);
        $slovakTranslation->setWordId($word->getId());
        $slovakTranslation->save();

        $englishTranslation = new Translation($myPdo);
        $englishTranslation->setTitle($pole[2]);
        $englishTranslation->setDescription($pole[3]);
        $englishTranslation->setLanguageId(2);
        $englishTranslation->setWordId($word->getId());
        $englishTranslation->save();
    }

    fclose($file);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="fei.png">
    <link rel="stylesheet" href="style.css">
    <title>Search</title>
</head>
<body>

<div id="nav">
    <div id="userbutton">User</div>
    <div id="adminbutton">Admin</div>
</div>

<div id="user">
    <div class="grid">

        <form id="search-form">
            <div class="marginbottom">
                <label for="search">Zadajte slovo:</label>
                <input id="search" name="search" type="text">
            </div>
            <div class="marginbottom">
                <label for="language">Vyberte jazyk:</label>
                <select name="language_code" id="language">
                    <option value="sk">Slovenčina</option>
                    <option value="en">Angličtina</option>
                </select>
            </div>
            <div class="marginbottom">
                <label for="trans">Prikazat:</label>
                <select name="trans_lan" id="trans_lan">
                    <option value="trhere">Iba vo zadanom jazyku</option>
                    <option value="trthere">V oboch jazykoch</option>
                </select>
            </div>
            <div class="marginbottom">
                <input type="checkbox" id="desc" name="desc" onchange="changeCheck()">
                <label for="desc">Hladat aj v popise</label>
                <br>
            </div>
            <button id="search-button" type="button">Vyhladaj</button>
        </form>

        <table id="result-table">
            <thead>
            <tr>
                <th>sk</th>
                <th>en</th>
                <th>sk description</th>
                <th>en description</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<div id="admin">
    <div class="grid">
        <div>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <div class="marginbottom">
                    <label for="file"></label>
                    <input id="file" type="file" name="file">
                </div>
                <div class="marginbottom">
                    <input type="submit" value="Upload">
                </div>
            </form>

            <form id="upload" action="upload.php" method="post">
                <div class="marginbottom">
                    <label for="uploadsk"></label>
                    <input id="uploadsk" name="uploadsk" type="text" placeholder="Sk pojem">
                </div>
                <div class="marginbottom">
                    <label for="uploaden"></label>
                    <input id="uploaden" name="uploaden" type="text" placeholder="En pojem">
                </div>
                <div class="marginbottom">
                    <label for="uploadskd"></label>
                    <input id="uploadskd" name="uploadskd" type="text" placeholder="Sk popis">
                </div>
                <div class="marginbottom">
                    <label for="uploadend"></label>
                    <input id="uploadend" name="uploadend" type="text" placeholder="En popis">
                </div>
                <input type="submit" value="Upload">
            </form>

            <form id="update" action="update.php" method="post">
                <div class="marginbottom">
                    <label for="updateTitle"></label>
                    <input id="updateTitle" name="updateTitle" type="text" placeholder="Nazov">
                </div>
                <div class="marginbottom">
                    <label for="updated"></label>
                    <input id="updated" name="updated" type="text" placeholder="Popis">
                </div>
                <input type="submit" value="Update">
            </form>
        </div>

        <table id="glosary-table">
            <thead>
            <tr>
                <th>sk</th>
                <th>en</th>
                <th>sk description</th>
                <th>en description</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script src="./script.js"></script>

</body>
</html>