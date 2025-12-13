<?php
// Configuración de la base de datos
define('DB_HOST', 'sql102.infinityfree.com');
define('DB_NAME', 'if0_40640194_skechersplus');
define('DB_USER', 'if0_40640194');
define('DB_PASS', 'Wilteamo07');

function getDB() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
