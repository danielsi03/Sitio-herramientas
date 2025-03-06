<?php
require 'db_conexion.php';

function createSlug($text)
{

    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    $text = trim($text, '-');
    return $text;
}

if (isset($_POST['summit'])) {

    $name_category = $_POST['name_category'];
    $load_image = $_FILES['image_category']['tmp_name'];
    $image_category = fopen($load_image, 'rb');
    $slug_category = createSlug($name_category);
  

    if (!empty($image_category) && !empty($name_category)) {

        $insert = $cnnPDO->prepare('INSERT INTO category (name_category, image_category, slug_category) 
        VALUES (:name_category, :image_category, :slug_category)');

        $insert->bindParam(':image_category', $image_category, PDO::PARAM_LOB);
        $insert->bindParam(':name_category', $name_category);
        $insert->bindParam(':slug_category', $slug_category);


        $insert->execute();
        unset($insert);
        unset($cnnPDO);

?>
       
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Categoria subida con Exito!!</strong> 
        </div>
    
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
        <h1> Categorias</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nombre de la categoria</label>
                <input class="input-vender" name="name_category" type="text">
            </div>
            <div class="mb-3">
                <label>Imagen</label>
                <input class="custom-file-input" id="upload" type="file" id="fileInput" accept="image/jpg" name="image_category">
            </div>

            <div class="d-grid gap-2 col-6 mx-auto">
                <button name="summit" class="btn btn-success" type="submit">Subir</button>
                <a class="btn btn-success" type="button" href="login.php">Login</a>
            </div>
        </form>
    </div>
</body>


</html>