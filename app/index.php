<?php 
// Incluimos la conexión a la base de datos
include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>CRUD mínim</title>
</head>
<body>
    <h1>Llista d’usuaris</h1>

    <!-- CORRECCIÓN: Había dos etiquetas <table> anidadas. Se ha dejado solo una. -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Accions</th>
        </tr>
        <?php
        // MEJORA: Es buena práctica seleccionar solo las columnas que necesitas.
        $result = $conn->query("SELECT id, name, email FROM users");

        // MEJORA: Comprobamos si la consulta devolvió alguna fila.
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <!-- MEJORA (Seguridad): Usamos htmlspecialchars() para prevenir ataques XSS (Cross-Site Scripting). -->
                        <!-- Esto convierte caracteres especiales como < > & en entidades HTML, evitando que se ejecute código malicioso. -->
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>
                            <a href='edit.php?id=" . htmlspecialchars($row['id']) . "'>Editar</a> | 
                            <!-- MEJORA (Usabilidad): Se añade una confirmación en JavaScript para evitar borrados accidentales. -->
                            <a href='delete.php?id=" . htmlspecialchars($row['id']) . "' onclick='return confirm(\"Estàs segur que vols eliminar aquest usuari?\");'>Eliminar</a>
                        </td>
                     </tr>";
            }
        } else {
            // MEJORA: Se muestra un mensaje si no hay usuarios en la base de datos.
            echo "<tr><td colspan='4'>No s'han trobat usuaris.</td></tr>";
        }
        ?>
    </table>

    <h2>Afegir usuari</h2>
    <!-- CORRECCIÓN: El método del formulario debe ser "post" (en minúsculas y singular). -->
    <form action="add.php" method="post">
        Nom: <input type="text" name="name" required>
        Email: <input type="email" name="email" required>
        <button type="submit">Afegir</button>
    </form>
</body>
</html>

<?php
// MEJORA: Es buena práctica cerrar la conexión a la base de datos al final del script.
$conn->close();
?>
