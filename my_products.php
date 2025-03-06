<?php
require 'db_conexion.php';
session_start();
require 'navbar.php';
if (isset($_POST['delete'])) {
    $p = $_POST['delete'];
    $delete = $cnnPDO->prepare('DELETE FROM product WHERE student_id = ? AND id_product= ?');
    $delete->execute([$_SESSION['student_id'],$p]);
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>My Productos</title>
</head>

<body class="body-productos">
    <div class="container-products">
        <h1>Mis Productos</h1>
        <?php
        $select = $cnnPDO->prepare('SELECT * FROM product WHERE student_id = ?');
        $select->execute([$_SESSION['student_id']]);
        $count = $select->rowCount();
        $column = $select->fetchAll(PDO::FETCH_ASSOC);

        if ($count) {
            try {
                echo '<div class="card-mis-productos container mt-5">';
                echo '   <div class="row">';
                foreach ($column as $data) {
                    echo '  <div>';
                    echo '           <div class="carda" style="width: 100%; border:solid 1px while;">';
                    echo '               <img src="data:image_png;base64,' . base64_encode($data['image_1']) . '" class="card-img-top" alt="...">';
                    echo '               <div class="card-body-products ">';
                    echo '<div class="element-1">';
                    echo '                   <p>id producto:  ' . htmlentities($data["id_product"]) . '</p >';
                    echo '</div>';
                    echo '<div class="element-2">';
                    echo '                   <p>Nombre:  ' . htmlentities($data["name_product"]) . '</p >';
                    echo '                   <p>Descripcion:  ' . htmlentities($data["description"]) . '</p >';
                    echo '</div>';
                    echo '<div class="element-4">';
                    echo '                   <p>Categoria:  '.htmlentities($data["name_category"]). '</p >';
                    echo '                   <p>Precio: $ '. htmlentities($data["price"]).'.00 MXN</p >';
                    echo '                   <p>Stock:  ' . htmlentities($data["stock"]) . '</p >';
                    echo '</div>';
                    echo '<div class="element-5">';
                    echo '   <form  class="element-5" method="post">';  
                    echo '      <a href="window_product.php?slug=' . htmlentities($data['slug_product']) . ' " type="button" class="boton-productos">Ver Producto</a>';
                    echo '      <button  name="delete" value="'.$data['id_product'].'" type="submit" class="boton-productos-eliminar">Eliminar </button></form>';               
                    echo '</div>';
                    echo '               </div>';
                    echo '           </div>';
                    echo '       </div>';
                }
                echo '</div';
                echo '</div>';
            } catch (PDOException $error) {
                echo 'ERROR EN LA BASE DE DATOS' . $error->getMessage();
            }
        } else {
            echo '<h3>No tienes productos registrados</h3>';
        }
        ?>
    </div>


</body>

</html>