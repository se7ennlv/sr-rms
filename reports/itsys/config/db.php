<?php

$data = array(
    "server" => "sqlc1",
    "db" => "RMS",
    "user" => "sa",
    "password" => "Kiss@@33",
);

try {
    $conn = new PDO("sqlsrv:server=" . $data["server"] . "; database=" . $data["db"], $data["user"], $data["password"]);
    // echo 'Connect pass';
} catch (Exception $e) {
    echo "Can't connect to server";
}
