<?php 
$hostname = "localhost";
$name = "root";
$password = "SmartPassword";
$database = "StealPlaze";

$conn = mysqli_connect($hostname, $name, $password, $database);

if (!$conn) {
    die("ОШИБКА ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ: " . mysqli_connect_error());
}

session_start();
?>