<?php
// config.php EN LA RAÍZ - VERIFICA QUE ESTÉ ASÍ:

// Detectar entorno
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1') {
    $config = require __DIR__ . '/config/config.local.php';
} else {
    $config = require __DIR__ . '/config/config.prod.php';
}

function getDB() {
    global $config;

    try {
        $pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4",
            $config['user'],
            $config['pass'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        // Para depuración
        if (isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1')) {
            die('Error de conexión a BD: ' . $e->getMessage());
        } else {
            die('Error de conexión a la base de datos');
        }
    }
}