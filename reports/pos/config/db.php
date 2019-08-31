<?php
date_default_timezone_set("Asia/Bangkok");
//echo date_default_timezone_get();

$data = array(
    "server" => "172.16.98.235\ASI2008",
    "db" => "ASIPOS600",
    "user" => "savan",
    "password" => "123456",
);

try {
    $conn = new PDO("sqlsrv:server=" . $data["server"] . "; database=" . $data["db"], $data["user"], $data["password"]);
    //echo 'Connect Pass';
} catch (Exception $e) {
    echo "Can't connect to server";
}