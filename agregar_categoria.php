<?php
include 'db_conexion.php';

// Agregar categoría
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_category"])) {
    $name_category = $_POST["name_category"];
    $slug_category = $_POST["slug_category"];

    // Procesar la imagen
    $image_category = file_get_contents($_FILES["image_category"]["tmp_name"]);

    $sql = "INSERT INTO category (name_category, image_category, slug_category) VALUES (:name, :image, :slug)";
    $stmt = $cnnPDO->prepare($sql);
    $stmt->bindParam(":name", $name_category);
    $stmt->bindParam(":image", $image_category, PDO::PARAM_LOB);
    $stmt->bindParam(":slug", $slug_category);

    if ($stmt->execute()) {
        echo "<script>alert('Categoría agregada correctamente');</script>";
    } else {
        echo "<script>alert('Error al agregar categoría');</script>";
    }
}

// Eliminar categoría
if (isset($_GET["delete_id"])) {
    $delete_id = $_GET["delete_id"];
    $sql = "DELETE FROM category WHERE name_category = :id";
    $stmt = $cnnPDO->prepare($sql);
    $stmt->bindParam(":id", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Categoría eliminada correctamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar categoría');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Categorías</title>
</head>
<body>
    <h2>Agregar Nueva Categoría</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Nombre de Categoría:</label>
        <input type="text" name="name_category" required>
        
        <label>Slug:</label>
        <input type="text" name="slug_category" required>
        
        <label>Imagen:</label>
        <input type="file" name="image_category" required>

        <button type="submit" name="add_category">Agregar Categoría</button>
    </form>

    <h2>Lista de Categorías</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Slug</th>
            <th>Acción</th>
        </tr>
        <?php
        $sql = "SELECT * FROM category";
        $stmt = $cnnPDO->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["name_category"]) . "</td>";
            echo "<td><img src='data:image/jpeg;base64," . base64_encode($row["image_category"]) . "' width='50'></td>";
            echo "<td>" . htmlspecialchars($row["slug_category"]) . "</td>";
            echo "<td><a href='?delete_id=" . urlencode($row["name_category"]) . "' onclick='return confirm(\"¿Eliminar esta categoría?\")'>Eliminar</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
