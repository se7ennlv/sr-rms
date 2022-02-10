<?php

$data = array(
    "server" => "172.16.98.142",
    "db" => "SRRMS",
    "user" => "sa",
    "password" => "Kiss@@33",
);

try {
    $conn = new PDO("sqlsrv:server=" . $data["server"] . "; database=" . $data["db"], $data["user"], $data["password"]);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo 'Connect pass';
} catch (Exception $e) {
    echo "Can't connect to server";
}
