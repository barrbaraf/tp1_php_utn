<?php
require 'conexion-basedatos.php';

$nombre = isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '';
$categoria = isset($_GET['categoria']) ? htmlspecialchars($_GET['categoria']) : '';

$sql_select = "SELECT * FROM productos WHERE 1=1";

if ($nombre != '') {
    $sql_select .= " AND nombre_producto LIKE '%" . mysqli_real_escape_string($conn, $nombre) . "%'";
}
if ($categoria != '') {
    $sql_select .= " AND categoria = '" . mysqli_real_escape_string($conn, $categoria) . "'";
}

// Opcional: orden por nombre
$sql_select .= " ORDER BY nombre_producto ASC";

$result = mysqli_query($conn, $sql_select);
$productos = [];

while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = $row;
}
mysqli_free_result($result);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <link rel="stylesheet" href="style-index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVENTARIO</title>
</head>
<body>
    <h1 class="encabezado">INVENTARIO</h1>
    
    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'agregado') : ?>
    <div class="mensaje_productoagregado">
    Producto agregado correctamente.
    </div>
<?php endif; ?>
<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'eliminado') : ?>
    <div class="mensaje_productoeliminado" >
    Producto eliminado correctamente.
    </div>
<?php endif; ?>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#">Buscar producto</a>
        </li>
        <li class="nav-item">
             <a class="nav-link" href="crear_producto.php">Agregar producto</a>
        </li>
    </ul>

    <div class="card" >
        
        <div class="contenedor">
        <h2>Lista de productos:</h2>

        <form method="GET" action="index.php" class="filtros">
            

            <input type="text" name="nombre" class="input-busqueda" placeholder="Ingrese el nombre..." value="<?= htmlspecialchars($nombre) ?>">
            <select name="categoria" class="select-estilo">
                <option value="">Todas</option>
                <?php
                $categorias = ['Vasos', 'Ropa', 'Accesorios', 'Mates', 'Libreria', 'Decoracion', 'Tecnologia'];
                foreach ($categorias as $cat) {
                    $selected = ($categoria == $cat) ? 'selected' : '';
                    echo "<option value='$cat' $selected>$cat</option>";
                }
                ?>
            </select>
            <button type="submit" class="button">Buscar...</button>
        </form>
        </div>

    <?php if (empty($productos)) : ?>
        <p>Productos no encontrados...</p>
    <?php else : ?>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($productos as $producto) : ?>
                <tr>
                    <td><?= htmlspecialchars($producto['nombre_producto']) ?></td>
                    <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                    <td><?= htmlspecialchars($producto['precio']) ?></td>
                    <td><?= htmlspecialchars($producto['categoria']) ?></td>
                    <td><?= htmlspecialchars($producto['stock']) ?></td>
                    <td>
                        <a class="btn-blue" href="editar_producto.php?id=<?= $producto['id'] ?>">Editar</a>
                        
                        <a class="btn-red" href="eliminar_producto.php?id=<?= $producto['id'] ?>" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    </div>
    
</body>
</html>
