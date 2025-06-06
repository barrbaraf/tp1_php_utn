<?php
require 'conexion-basedatos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Actualizar producto
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];

    $sql = "UPDATE productos SET 
                nombre_producto = ?, 
                descripcion = ?, 
                precio = ?, 
                stock = ?, 
                categoria = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssdisi', $nombre, $descripcion, $precio, $stock, $categoria, $id);
    mysqli_stmt_execute($stmt);

    header("Location: index.php?mensaje=modificado");
    exit;
} else {
    // Cargar producto
    if (!isset($_GET['id'])) {
        echo "ID no especificado.";
        exit;
    }

    $id = $_GET['id'];
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $producto = mysqli_fetch_assoc($result);

    if (!$producto) {
        echo "Producto no encontrado.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="style-editar_producto.css">
</head>
<body>
    <div class="contenedor-formulario">
    <form method="POST" action="editar_producto.php" class="card-agregar-producto">
        <h2>Editar producto</h2>

        <input type="hidden" name="id" value="<?= $producto['id'] ?>">

        <div class="fila-doble">
            <div class="campo">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre_producto']) ?>" required>
            </div>
            <div class="campo">
                <label>Precio:</label>
                <input type="number" step="0.01" min="0" name="precio" value="<?= $producto['precio'] ?>" required>
            </div>
        </div>

        <div class="campo">
            <label>Descripción:</label>
            <textarea name="descripcion" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
        </div>

        <div class="campo">
            <label>Stock:</label>
            <input type="number" name="stock" value="<?= $producto['stock'] ?>" required>
        </div>

        <div class="campo">
            <label>Categoría:</label>
            <select name="categoria">
                <?php
                $categorias = ['Vasos', 'Ropa', 'Accesorios', 'Mates', 'Libreria', 'Decoracion', 'Tecnologia'];
                foreach ($categorias as $cat) {
                    $selected = $producto['categoria'] == $cat ? 'selected' : '';
                    echo "<option value='$cat' $selected>$cat</option>";
                }
                ?>
            </select>
        </div>

        <div class="botones">
            <button type="submit" class="btn-blue">Guardar cambios</button>
            <a href="index.php" class="btn-red">Cancelar</a>
        </div>
    </form>
</div>

</body>
</html>
