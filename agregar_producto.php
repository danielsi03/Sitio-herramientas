<?php
require 'db_conexion.php'; // Incluye tu archivo de conexión
require 'navbar.php'; // Incluye tu archivo de conexión

// Función para generar un slug
function generarSlug($cadena) {
    $slug = strtolower(trim($cadena));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

// Obtener las categorías disponibles
$query = $cnnPDO->query("SELECT name_category FROM category");
$categorias = $query->fetchAll(PDO::FETCH_ASSOC);

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_product = $_POST['id_product'] ?? null;
    $name_product = $_POST['name_product'] ?? null;
    $beneficios = $_POST['beneficios'] ?? null;
    $aplicaciones = $_POST['aplicaciones'] ?? null;
    $name_category = $_POST['category_name'] ?? null;

    if (!$id_product || !$name_product || !$beneficios || !$aplicaciones || !$name_category) {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        $slug_product = generarSlug($name_product);
        $slug_category = generarSlug($name_category);

        // Manejo de la imagen
        if (isset($_FILES['image_1']) && $_FILES['image_1']['error'] === UPLOAD_ERR_OK) {
            $imagen = file_get_contents($_FILES['image_1']['tmp_name']);
        } else {
            $imagen = null;
        }

        try {
            $sql = "INSERT INTO product (id_product, name_product, beneficios, aplicaciones, image_1, name_category, slug_product, slug_category) 
                    VALUES (:id_product, :name_product, :beneficios, :aplicaciones, :image_1, :name_category, :slug_product, :slug_category)";
            $stmt = $cnnPDO->prepare($sql);
            $stmt->bindParam(':id_product', $id_product, PDO::PARAM_INT);
            $stmt->bindParam(':name_product', $name_product);
            $stmt->bindParam(':beneficios', $beneficios);
            $stmt->bindParam(':aplicaciones', $aplicaciones);
            $stmt->bindParam(':image_1', $imagen, PDO::PARAM_LOB);
            $stmt->bindParam(':name_category', $name_category);
            $stmt->bindParam(':slug_product', $slug_product);
            $stmt->bindParam(':slug_category', $slug_category);

            if ($stmt->execute()) {
                $mensaje = "Producto agregado correctamente.";
            } else {
                $mensaje = "Error al agregar el producto.";
            }
        } catch (PDOException $e) {
            $mensaje = "Error en la base de datos: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Herramienta</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <h2>Agregar Nueva Herramienta</h2>
    <?php if (isset($mensaje)): ?>
        <p><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="id_product">ID:</label>
        <input type="number" name="id_product" id="id_product" required>

        <label for="name_product">Nombre de la Herramienta:</label>
        <input type="text" name="name_product" id="name_product" required>

        <label for="beneficios">Beneficios:</label>
        <textarea name="beneficios" id="beneficios" required></textarea>

        <label for="aplicaciones">Aplicaciones:</label>
        <textarea name="aplicaciones" id="aplicaciones" required></textarea>

        <label for="image_1">Imagen de la Herramienta:</label>
        <input type="file" name="image_1" id="image_1" accept="image/*" required>

        <label for="category_name">Categoría:</label>
        <select name="category_name" id="category_name" required>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= htmlspecialchars($categoria['name_category']) ?>">
                    <?= htmlspecialchars($categoria['name_category']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Agregar Herramienta</button>
    </form>
</body>
</html>
