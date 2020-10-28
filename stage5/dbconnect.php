<?php
$server = "localhost"; // имя хоста
$username = "root"; // Имя пользователя БД
$password = "rootroot"; // Пароль пользователя. Если у пользователя нету пароля то, оставляем пустое значение ""
$database = "stage1"; // Имя базы данных

// Подключение к базе данных через MySQLi
$mysqli = new mysqli($server, $username, $password, $database);

// Проверяем, успешность соединения.
if ($mysqli->connect_errno) {
    die("<p><strong>Ошибка подключения к БД</strong></p><p><strong>Код ошибки: </strong> ". $mysqli->connect_errno ." </p><p><strong>Описание ошибки:</strong> ".$mysqli->connect_error."</p>");
}

// Устанавливаем кодировку подключения
$mysqli->set_charset('utf8');
