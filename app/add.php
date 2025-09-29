<?php
// Incluimos la conexión a la base de datos
include 'db.php';

// MEJORA: Verificamos que los datos se envían por el método POST para evitar errores.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recogemos los datos del formulario
    $name  = $_POST['name'];
    $email = $_POST['email'];

    /* 
     * CORRECCIÓN (Seguridad y Sintaxis): 
     * 1. Usamos sentencias preparadas para prevenir INYECCIÓN SQL. Esto es CRÍTICO.
     *    Nunca se deben insertar variables directamente en una consulta SQL.
     * 2. La sintaxis SQL era incorrecta. "VALUES (*, ?)" se ha corregido a "VALUES (?, ?)",
     *    usando un marcador de posición (?) por cada valor que se va a insertar.
     */
    $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");

    // Vinculamos las variables a los marcadores de posición.
    // "ss" significa que ambas variables ($name, $email) son de tipo string.
    $stmt->bind_param("ss", $name, $email);
    
    // Ejecutamos la consulta preparada
    $stmt->execute();

    // MEJORA: Cerramos la sentencia para liberar recursos.
    $stmt->close();
}

// Cerramos la conexión a la base de datos
$conn->close();

// Redirigimos al usuario de vuelta a la página principal
header("Location: index.php");
// exit() asegura que no se ejecute más código después de la redirección.
exit;
?>
