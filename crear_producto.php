<?php
require 'conexion-basedatos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];

    $sql = "INSERT INTO productos (nombre_producto, descripcion, precio, stock, categoria)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssdis', $nombre, $descripcion, $precio, $stock, $categoria);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?mensaje=agregado");
        exit;
    } else {
        die("Error al guardar el producto: " . mysqli_stmt_error($stmt));
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar producto</title>
    <link rel="stylesheet" href="style-index.css">
</head>
<body>
    <h2>Agregar nuevo producto</h2>
    <form method="POST" action="crear_producto.php">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Descripción:</label>
        <textarea name="descripcion" required></textarea>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" required>

        <label>Stock:</label>
        <input type="number" name="stock" required>

        <label>Categoría:</label>
        <select name="categoria">
            <?php
            $categorias = ['Vasos', 'Ropa', 'Accesorios', 'Mates', 'Libreria', 'Decoracion', 'Tecnologia'];
            foreach ($categorias as $cat) {
                echo "<option value='$cat'>$cat</option>";
            }
            ?>
        </select>

        <button type="submit" class="btn-blue">Guardar</button>
        <a href="index.php" class="btn-red">Cancelar</a>
    </form>
</body>
</html>
