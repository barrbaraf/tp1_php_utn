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
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    
    <title>Agregar producto</title>
    <link rel="stylesheet" href="style-crear_producto.css">
</head>
<body>
    <div class="contenedor-formulario">
        <form method="POST" action="crear_producto.php" class="card-agregar-producto">
            <h2>Agregar nuevo producto</h2>

            <label for="nombre">Nombre del producto:</label>
            <input type="text" name="nombre" id="nombre" required class="input-busqueda">

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required class="textarea-estilo"></textarea>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" min=0 name="precio" id="precio" required class="input-busqueda">

            <label for="stock">Stock:</label>
            <input type="number" min=0 name="stock" id="stock" required class="input-busqueda">

            <label for="categoria">Categoría:</label>
            <select name="categoria" id="categoria" class="select-estilo">
                <option value="">Seleccionar</option>
                <option value="Vasos">Vasos</option>
                <option value="Ropa">Ropa</option>
                <option value="Accesorios">Accesorios</option>
                <option value="Mates">Mates</option>
                <option value="Libreria">Librería</option>
                <option value="Decoracion">Decoración</option>
                <option value="Tecnologia">Tecnología</option>
            </select>

            <div class="botones">
                <button type="submit" class="btn-blue">Guardar</button>
                <a href="index.php" class="btn-red">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>


