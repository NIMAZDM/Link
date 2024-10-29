<?php

    $hostname = "localhost";
    $username = "root";
    $password = "";

    try {

        $conn = new PDO("mysql:hostname=$hostname;dbname=linkshortener;", $username, $password);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {

        echo $e -> getMessage();

    }

?>