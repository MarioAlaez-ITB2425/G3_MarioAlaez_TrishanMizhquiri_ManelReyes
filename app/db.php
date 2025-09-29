<?php
// Fichero de conexión a la Base de Datos

// CORRECCIÓN: El nombre del servidor era "locahost" y ha sido corregido a "localhost".
$servername = "localhost"; 
$username = "root";
// MEJORA: Es recomendable usar un usuario específico para la app en lugar de 'root'.
// Deja la contraseña vacía "" si usas una instalación por defecto de XAMPP/WAMP.
$password = "root"; 
$dbname = "crud_db";

// Crear conexión usando el paradigma orientado a objetos de mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Establecer el charset a utf8mb4 para soportar caracteres especiales y emojis
$conn->set_charset("utf8mb4");

// Verificar si la conexión ha fallado
if ($conn->connect_error) {
    // die() detiene la ejecución del script y muestra un mensaje de error.
    // Es más seguro no mostrar detalles del error en producción.
    die("Connexió fallida: " . $conn->connect_error);
}
?>
