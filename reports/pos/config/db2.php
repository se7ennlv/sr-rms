<?php
date_default_timezone_set("Asia/Bangkok");
//echo date_default_timezone_get();

$data = array(
    "server" => "172.16.98.142",
    "db" => "POSExtension",
    "user" => "sa",
    "password" => "Kiss@@33",
);

try {
    $conn2 = new PDO("sqlsrv:server=" . $data["server"] . "; database=" . $data["db"], $data["user"], $data["password"]);
    //echo 'Connect pass';
} catch (Exception $e) {
    echo "Can't connect to server";
}
