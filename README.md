# Inventarios Productos

Temática del proyecto:

Este proyecto consiste en una aplicación web para el manejo de inventario de un negocio. Permite realizar operaciones de Alta, Baja, Modificación y Consulta (ABMC) organizados por categorías como ropa, vasos, mates, tecnología, entre otros.

---

## Descripción del funcionamiento

funcionalidades de la aplicacion:

- Agregar nuevos productos con nombre, descripción, precio, stock y categoría.
- Listar todos los productos.
- Editar productos existentes.
- Eliminar productos.
- Buscar productos por nombre.
- Validaciones básicas en formularios.
- Uso de sentencias preparadas para prevenir SQL Injection.
- Uso de `htmlspecialchars()` para prevenir XSS.

---

## Instrucciones de instalación y configuración

Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor local como XAMPP, Laragon, WAMP o similar

---

###  Instalación y ejecución

1. **Cloná el repositorio**

```bash
git clone https://github.com/tu-usuario/tp1_UTN.git
cd tp1_UTN
```
## Configuracion del entorno
se incorporó un archivo .env de ejemplo con los siguientes datos:
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

## Creación de la base de datos
Se incorporó tambien un archivo llamado "crear_tabla.php" para crear la tabla de productos dentro de la base de datos.


### Cómo ejecutar la aplicación
Usando el servidor embebido de PHP, desde la raiz del proyecto se debe ejecutar:
###  php -S localhost:8000
y luego acceder a:
###  http://localhost:8000
