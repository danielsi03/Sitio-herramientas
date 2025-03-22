<?php
require 'db_conexion.php';

ob_start();
require 'navbar.php';

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];

    $select = $cnnPDO->prepare('SELECT * FROM product WHERE slug_product = :slug_product');
    $select->bindParam(':slug_product', $slug);
    $select->execute();
    $column = $select->fetch(PDO::FETCH_ASSOC);
} else {
    echo '<p>No se encontró el producto</p>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlentities($column['name_product']) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="body-detalles">
    <div class="container-detalles">
        <div class="detalles-imagen">
            <div class="carrusel-detalles">
                <div id="carouselExampleFade" class="carousel slide carousel-fade">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <?php echo '<img class="imgenes-carrusel-detalles d-block w-100" src="data:image/png;base64,' . base64_encode($column['image_1']) . '" width="150px" height="350px" style="margin:10px auto;"/>' ?>
                        </div>    
                    </div>

                </div>
            </div>
        </div>

        <div class="detalles-texto">
            <h4><?php echo htmlentities($column['name_product']) ?> </h4>
        
            <p><b>Beneficios: </b> <?php echo htmlentities($column['beneficios']) ?></p>
            <p><b>Aplicaciones: </b> <?php echo htmlentities($column['aplicaciones']) ?></p>
          
            <p><b>Categoria:</b> <?php echo htmlentities($column['name_category']) ?></p>
       
    </div>
</body>

</html>

