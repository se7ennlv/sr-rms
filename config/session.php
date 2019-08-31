<?php
session_start();

if ($_SESSION['valid_user'] != true) {
    header('Location: http://172.16.98.171/rms/login.php');
    
    exit();
}
