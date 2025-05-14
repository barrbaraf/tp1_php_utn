<?php
require 'conexion-basedatos.php';

if (!isset($_GET['id'])) {
    die("ID no especificado.");
}

$id = (int) $_GET['id'];

$sql = "DELETE FROM productos WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Error al preparar: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php?mensaje=eliminado");
    exit;
} else {
    die("Error al eliminar: " . mysqli_stmt_error($stmt));
}
