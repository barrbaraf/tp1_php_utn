<?php
require 'vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    die('Error: configuración no encontrada.');
}

// Obtener variables desde .env
$host = $_ENV['DB_HOST'] ?? 'localhost';
$user = $_ENV['DB_USERNAME'] ?? 'root';
$pass = $_ENV['DB_PASSWORD'] ?? '';
$db   = $_ENV['DB_DATABASE'] ?? 'mi_base_de_datos';

// Crear conexión
$conn = mysqli_connect($host, $user, $pass, $db);

// Verificar conexión
if (!$conn) {
    die('Error de conexión: ' . mysqli_connect_error());
}
