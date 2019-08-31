<?php
date_default_timezone_set("Asia/Bangkok");
//echo date_default_timezone_get();

$data = array(
    "server" => "172.16.98.16",
    "db" => "ASIFD600",
    "user" => "sav",
    "password" => "a123456",
);

try {
    $conn3 = new PDO("sqlsrv:server=" . $data["server"] . "; database=" . $data["db"], $data["user"], $data["password"]);
    //echo 'Connect pass';
} catch (Exception $e) {
    echo "Can't connect to server";
}
