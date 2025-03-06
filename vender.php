<?php
ob_start();
require 'db_conexion.php';
session_start();
require 'navbar.php';

function createSlug($text)
{

    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    $text = trim($text, '-');
    return $text;
}

if (isset($_POST['reg_prod'])) {
    $id_product = rand(1, 999);
    $student_id = $_SESSION['student_id'];
    $name_product = $_POST['name_product'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $name_category = $_POST['name_category'];
    $id_images = $id_product;

    $load_image = $_FILES['image_1']['tmp_name'];
    $image_1 = fopen($load_image, 'rb');
    $load_image = $_FILES['image_2']['tmp_name'];
    $image_2 = fopen($load_image, 'rb');
    $load_image = $_FILES['image_3']['tmp_name'];
    $image_3 = fopen($load_image, 'rb');
    $load_image = $_FILES['image_4']['tmp_name'];
    $image_4 = fopen($load_image, 'rb');
    $load_image = $_FILES['image_5']['tmp_name'];
    $image_5 = fopen($load_image, 'rb');

    $slug_product = createSlug($name_product).createSlug($id_product);
    $slug_category = createSlug($name_category);

    if (!empty($image_1) && !empty($name_product) && !empty($description) && !empty($stock) && !empty($price) && !empty($name_category)) {

        $insert = $cnnPDO->prepare('INSERT INTO product(id_product, student_id, name_product, description, price, stock, name_category, image_1, image_2, image_3, image_4, image_5, slug_product, slug_category) 
        VALUES (:id_product, :student_id, :name_product, :description, :price, :stock, :name_category, :image_1, :image_2, :image_3, :image_4, :image_5, :slug_product, :slug_category)');

        $insert->bindParam(':id_product', $id_product);
        $insert->bindParam(':student_id', $student_id);
        $insert->bindParam(':name_product', $name_product);
        $insert->bindParam(':description', $description);
        $insert->bindParam(':price', $price);
        $insert->bindParam(':stock', $stock);
        $insert->bindParam(':name_category', $name_category);
        $insert->bindParam(':image_1', $image_1, PDO::PARAM_LOB);
        $insert->bindParam(':image_2', $image_2, PDO::PARAM_LOB);
        $insert->bindParam(':image_3', $image_3, PDO::PARAM_LOB);
        $insert->bindParam(':image_4', $image_4, PDO::PARAM_LOB);
        $insert->bindParam(':image_5', $image_5, PDO::PARAM_LOB);
        $insert->bindParam(':slug_product', $slug_product);
        $insert->bindParam(':slug_category', $slug_category);

        $insert->execute();
        unset($insert);
        unset($cnnPDO);

?>
       
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Producto subido con exito!!</strong> <br>Seras redireccionado en 3 segundos...
        </div>
        
        <script>
            setTimeout(function() {
                window.location.href = 'main_window.php';
            }, 3000);
        </script>
<?php
       
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vender</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body class="body-vender">

    <div class="container-vender">
        <h1> VENDER</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="grid-vender">
            <div class="container-vender-titulo">
                <label>Titulo</label>
                <input class="input-vender" name="name_product" type="text">
            </div>
            <div class="container-vender-descripcion">
                <label>Descripcion</label>
                <textarea class="input-vender" name="description"></textarea>
            </div>
            <div class="container-vender-stock">
                <label>Stock</label>
                <input class="input-vender" name="stock" type="number">
            </div>
            <div class="container-vender-precio">
                <label>Precio</label>
                <input class="input-vender" name="price" type="number">
            </div>
            <select class="container-vender-categorias input-vender" name="name_category">
                <option selected>Categoria</option>
                <?php
                $select = $cnnPDO->prepare('SELECT * FROM category');
                $select->execute();
                $count = $select->rowCount();
                $colum = $select->fetchAll();
                foreach ($colum as $data) {
                    echo '<option value="' . htmlentities($data['name_category']) . '">' . htmlentities($data['name_category']) . '</option>';
                }
                ?>
            </select>

            <div class="container-vender-imagenes imagenes-vender">
            <div class="mb-3">
                <label>Imagen</label>
                <input class="custom-file-input" id="upload" type="file" id="fileInput" accept="image/jpg" name="image_1">
            </div>
            <div class="mb-3">
                <label>Imagen 2</label>
                <input class="custom-file-input" id="upload" type="file" id="fileInput" accept="image/jpg" name="image_2">
            </div>
            <div class="mb-3">
                <label>Imagen 3</label>
                <input class="custom-file-input" id="upload" type="file" id="fileInput" accept="image/jpg" name="image_3">
            </div>
            <div class="mb-3">
                <label>Imagen 4</label>
                <input class="custom-file-input" id="upload" type="file" id="fileInput" accept="image/jpg" name="image_4">
            </div>
            <div class="mb-3">
                <label>Imagen 5</label>
                <input class="custom-file-input" id="upload" type="file" id="fileInput" accept="image/jpg" name="image_5">
            </div>
            </div>
            <div class="container-vender-botones d-grid gap-2 col-6 mx-auto">
                <button name="reg_prod" class="btn btn-success" type="submit">Publicar</button>
                <a class="btn btn-success" type="button" href="main_window.php">Regresar</a>
            </div>
            </div>
        </form>
    </div>
</body>


</html>