<?php
// config.php
session_start();

// Настройки базы данных
define('DB_HOST', 'localhost');
define('DB_USER', 'g95074s7_noteboo');
define('DB_PASS', 'g&6Bs4fCVvui');
define('DB_NAME', 'g95074s7_noteboo');

// Установка часового пояса
date_default_timezone_set('Europe/Moscow');

// Создаем подключение к базе данных
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Функция для безопасного вывода данных
function escape($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
?>