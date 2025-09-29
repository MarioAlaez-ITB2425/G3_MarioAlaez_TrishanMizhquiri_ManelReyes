<?php
include 'db.php';

// Verificamos que se ha pasado un 'id' por la URL.
if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // Convertimos el ID a entero por seguridad.

    /*
     * CORRECCIÓN (Sintaxis y Seguridad):
     * 1. La sintaxis SQL era incorrecta. "DELETE * FROM" se ha cambiado a "DELETE FROM".
     * 2. Se usa una sentencia preparada para prevenir inyección SQL, la forma más segura.
     */
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" indica que el ID es de tipo integer.
    $stmt->execute();
    $stmt->close();
}

// Cerramos la conexión
$conn->close();

// Redirigimos al usuario a la página principal
header("Location: index.php");
exit;
?>
