<?php

// Cargar dependencias de Composer
require 'vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    header('Content-Type: application/json');
    http_response_code(500); // Error interno del servidor
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: configuración no encontrada.'
    ]);
    exit;
} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
    exit;
}

// --- 2. Obtener Credenciales ---
$dbHost = $_ENV['DB_HOST'] ?? '127.0.0.1';
$dbPort = $_ENV['DB_PORT'] ?? '3306';
$dbName = $_ENV['DB_DATABASE'] ?? null;
$dbUser = $_ENV['DB_USERNAME'] ?? null;
$dbPass = $_ENV['DB_PASSWORD'] ?? null;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect(
        $dbHost,
        $dbUser,
        $dbPass,
        $dbName,
        (int)$dbPort
    );

    mysqli_set_charset($conn, "utf8mb4");

} catch (mysqli_sql_exception $e) {
    header('Content-Type: application/json');
    http_response_code(500); // Error interno del servidor
    echo json_encode([
        'status' => 'error',
        'message' => 'Error de conexión a BD: ' . $e->getMessage()
    ]);
    exit;
}

//CREAMOS TABLA
$sql_table = "
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    categoria VARCHAR(100),
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb5 COLLATE=utf8mb4_unicode_ci;
)";


try{
    mysql_query(mysql: $conn, query: $sql_table);
} catch(mysqly_sql_exception $e){
    header(header:'Content-Type: application/json');
    http_response_code(responde_code:500);
    echo json_encode(
        value:[
            'status'=> 'error',
            'message'=> 'Error al crear la tabla: '.$e->getMessage()
        ]
        );
        exit;
}

//RESPUESTA POR DEFECTO
$response=[
    'status'=> 'success',
    'message'=>'Accion no valida o no encontrada'
];

$data= null;
$status_code= 400;


//ACCIONES: LISTAR, CREAR, EDITAR, BORRADO LOGICO
$accion= $_REQUEST['accion'] ?? null;

try{
    switch($accion){

        //LISTAR
        case 'listar':
            $allowed_colums = ['nombre_producto', 'descripcion', 'precio', 'precio', 'stock', 'categoria'];
            $sort_column = 'nombre_producto';
            $sort_dir = 'ASC';

            if (isset($_GET['sort']) && in_array(needle: $_GET['sort'], haystack: $allowed_colums)){
                $sort_column = $_GET['sort'];
            }

            if (isset($_GET['dir']) && in_array(needle: strtoupper(string: $GET['dir']), haystack: ['ASC', 'DES'])){
                $sort_dir = strtoupper(string: $_GET['dir']);
            }

            $sql_select= "SELECT nombre_producto, descripcion, precio, precio, stock, categoria FROM productos ORDER BY " . $sort_column . " " . $sort_dir;
            $result = mysqli_query(mysql: $conn, query: $sql_select);
            $productos = [];
            while ($row = mysqly_fetch_assoc(result: $result)){
                $productos[] = $row;
            }
            mysql_free_result(result: $result);

            $response= [
                'status'=>'success',
                'message'=>'Lista de productos obtenidos correctamente',
            ];

            $data= $productos;
            $status_code= 200;
            break;
        
            case 'crear':
                if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                    $response = ['message' => 'Metodo no permitido, se requiere POST'];
                    $status_code= 405;
                    break;
                }

                
}
}

?>