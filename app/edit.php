<?php
include 'db.php';

$user = null; // Variable para almacenar los datos del usuario a editar

// --- PARTE 1: OBTENER DATOS DEL USUARIO PARA MOSTRARLOS EN EL FORMULARIO ---
// Verificamos si se ha pasado un 'id' por la URL (método GET)
if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // Convertimos el ID a entero por seguridad.

    /*
     * CORRECCIÓN (Seguridad): Se usa una sentencia preparada para evitar inyección SQL
     * al obtener los datos del usuario.
     */
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" indica que el ID es de tipo integer.
    $stmt->execute();
    $result = $stmt->get_result(); // Obtenemos el resultado
    $user = $result->fetch_assoc(); // Lo guardamos en un array asociativo
    $stmt->close();
}

// --- PARTE 2: ACTUALIZAR LOS DATOS CUANDO SE ENVÍA EL FORMULARIO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = (int)$_POST['id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];

    /*
     * CORRECCIÓN (Sintaxis y Seguridad):
     * 1. La sintaxis de UPDATE era incorrecta. "where name=?" se ha cambiado por "SET name = ?".
     * 2. Se usa una sentencia preparada para la actualización, previniendo inyección SQL.
     */
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    
    // "ssi" indica los tipos de las variables: string, string, integer.
    $stmt->bind_param("ssi", $name, $email, $id);
    $stmt->execute();
    $stmt->close();

    // Redirigimos al index
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Editar usuari</title>
</head>
<body>
    <h1>Editar usuari</h1>
    
    <?php if ($user): // MEJORA: Solo mostramos el formulario si el usuario fue encontrado ?>
    <form method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
        Nom: 
        <!-- MEJORA (Seguridad): Usamos htmlspecialchars para prevenir XSS al mostrar los datos existentes. -->
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        Email: 
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <button type="submit">Desar</button>
    </form>
    <?php else: // MEJORA: Mensaje si el usuario con ese ID no existe. ?>
        <p>No s'ha trobat l'usuari. <a href="index.php">Tornar a la llista</a>.</p>
    <?php endif; ?>
</body>
</html>
