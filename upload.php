<?php

require_once "index.php";
require_once "MyPdo.php";
require_once "Word.php";
require_once "Translation.php";

$myPdo = new MyPDO("mysql:host=localhost;dbname=glosar", "xhrcan", "SQsBCnIEq5Vnxum");

$sk = $_POST['uploadsk'];
$en = $_POST['uploaden'];
$skd = $_POST['uploadskd'];
$end = $_POST['uploadend'];

if($end != "" && $sk != "" && $skd != "" && $en != "") {

    $word = new Word($myPdo);
    $word->setTitle($sk);
    $word->save();

    $slovakTranslation = new Translation($myPdo);
    $slovakTranslation->setTitle($sk);
    $slovakTranslation->setDescription($skd);
    $slovakTranslation->setLanguageId(2);
    $slovakTranslation->setWordId($word->getId());
    $slovakTranslation->save();

    $englishTranslation = new Translation($myPdo);
    $englishTranslation->setTitle($en);
    $englishTranslation->setDescription($end);
    $englishTranslation->setLanguageId(1);
    $englishTranslation->setWordId($word->getId());
    $englishTranslation->save();
}
