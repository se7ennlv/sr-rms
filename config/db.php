<?php

$data = array(
    "server" => "",
    "db" => "",
    "user" => "",
    "password" => "",
);

$data2 = array(
    "server" => "",
    "db" => "",
    "user" => "",
    "password" => "",
);

$data3 = array(
    "server" => "",
    "db" => "",
    "user" => "",
    "password" => "",
);

$data4 = array(
    "server" => "",
    "db" => "",
    "user" => "",
    "password" => "",
);

$data5 = array(
    "server" => "",
    "db" => "",
    "user" => "",
    "password" => "",
);

$data6 = array(
    "server" => "",
    "db" => "",
    "user" => "",
    "password" => "",
);
$data7 = array(
    "server" => "",
    "db" => "",
    "user" => "",
    "password" => "",
);


try {
    $rms_connect = new PDO("sqlsrv:server=" . $data["server"] . "; database=" . $data["db"], $data["user"], $data["password"]);
    $norm_connect = new PDO("sqlsrv:server=" . $data2["server"] . "; database=" . $data2["db"], $data2["user"], $data2["password"]);
    $psa_connect = new PDO("sqlsrv:server=" . $data3["server"] . "; database=" . $data3["db"], $data3["user"], $data3["password"]);
    $fp_connect = new PDO("sqlsrv:server=" . $data4["server"] . "; database=" . $data4["db"], $data4["user"], $data4["password"]);
    $hon_connect = new PDO("sqlsrv:server=" . $data5["server"] . "; database=" . $data5["db"], $data5["user"], $data5["password"]);
    $srut_connect = new PDO("sqlsrv:server=" . $data6["server"] . "; database=" . $data6["db"], $data6["user"], $data6["password"]);
    $irs_connect = new PDO("sqlsrv:server=" . $data7["server"] . "; database=" . $data7["db"], $data7["user"], $data7["password"]);

    $rms_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $norm_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $psa_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $fp_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $hon_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $srut_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $irs_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //echo 'Connect pass';
} catch (Exception $ex) {
    echo "Can't connect to server ".$ex->getMessage();
}
