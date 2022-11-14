<?php

require_once "connect.php";
echo "<pre>";

if (($file = fopen('TestFile.csv', 'r')) !== false) {
    $conn = dbConn();
    while (($fileData = fgetcsv($file, 5000, ';')) !== false) {
        $find = "SELECT * FROM `mittora_test` WHERE `goods` = '$fileData[1]'";

        $data = $conn->prepare($find);
        $data->execute();
        $count = $data->rowCount();

        if (!$count) {
            $insert_query = "INSERT INTO `mittora_test`( `chapter`, `goods`, `count`) VALUES ('$fileData[0]','$fileData[1]','$fileData[2]')";
            $data = $conn->prepare($insert_query);
            $data->execute();
        }
    }
    fclose($file);
    $conn = null;
}