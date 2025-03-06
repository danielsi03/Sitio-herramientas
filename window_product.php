<?php
require 'db_conexion.php';
session_start();
ob_start();
require 'navbar.php';
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];

    $select = $cnnPDO -> prepare('SELECT * FROM product WHERE slug_product = :slug_product');
    $select->bindParam(':slug_product', $slug);
    $select->execute();
    $column = $select->fetch(PDO::FETCH_ASSOC);

    $select2 = $cnnPDO ->prepare('SELECT * FROM user WHERE student_id =?');
    $select2 ->execute([$column['student_id']]);
    $column2 = $select2->fetch(PDO::FETCH_ASSOC);
    
} else {
    echo '<p>No se encontro el producto</p>';
}


if (isset($_POST['add'])) {
    $student_id = $_SESSION['student_id'];
    $id_product = $column['id_product'];
    $name_product = $column['name_product'];
    $amount = $_POST['amount'];
    $price = $column['price'];
    $total = $amount * $price;
    $date = date('Y-m-d');
    if ($amount <= $column['stock']) {

        if (!empty($student_id) && !empty($name_product) && !empty($amount) && !empty($price) && !empty($total) &&  !empty($date)) {
            $insert = $cnnPDO->prepare('INSERT INTO shopping_cart (student_id, id_product, name_product, total, price, amount, date) VALUES (?,?,?,?,?,?,?)');
            $insert->execute([$student_id, $id_product, $name_product, $total, $price, $amount, $date]);
            unset($insert);

            header('location:window_product.php?slug='.$slug);
        }
    } else {
        echo  '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>ATENCION!</strong> La cantidad solicitada supera el stock.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

if (isset($_POST['save_comm'])) {
    $id_review = rand(1, 999);
    $comment = $_POST['comment'];
    $student_id = $_SESSION['student_id'];
    $date_review = date("Y,m,d\TH:i:sP");
    $id_product = $column['id_product'];
    $name_student = $_SESSION['name']; 
    $pic_profile= $_SESSION['pic_profile'];


    if (!empty($id_review) && !empty($comment) && !empty($student_id) && !empty($date_review) && !empty($id_product) && !empty($name_student) && !empty($pic_profile)) {

        $ins_comm = $cnnPDO->prepare('INSERT INTO review (id_review, id_product, name_student, student_id, comment, date_review, pic_profile)VALUES (:id_review, :id_product, :name_student, :student_id, :comment, :date_review, :pic_profile)');
        $ins_comm->bindParam(':id_review', $id_review);
        $ins_comm->bindParam(':id_product', $id_product);
        $ins_comm->bindParam(':name_student', $name_student);
        $ins_comm->bindParam(':student_id', $student_id);
        $ins_comm->bindParam(':comment', $comment);
        $ins_comm->bindParam(':date_review', $date_review);
        $ins_comm->bindParam(':pic_profile', $pic_profile,PDO::PARAM_LOB);
        $ins_comm->execute();


?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>EXITO</strong> El comentario se publico con exito
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
    <title><?php echo htmlentities($column['name_product']) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="body-detalles">
<div class="vendedor-container">
        <div class="comentario-del-usuario">
                <div>
                <?php  echo  '<img src="data:image/png;base64,'.base64_encode($column2['pic_profile']).'" alt="">';?>
                </div>
                <div>
                    <p><b><?php echo $column2['name'] ?></b></p>
                    <p><b>Telefono:</b> <?php echo htmlentities( $column2['phone'])?> </p>
                    <p><b>Edificio:</b> <?php echo htmlentities($column2['building'])?> </p>
                </div>
        </div>
    </div>
    <div class="container-detalles">
        <div class="detalles-imagen">
            <div class="carrusel-detalles">
                <div id="carouselExampleFade" class="carousel slide carousel-fade">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <?php echo '<img class="imgenes-carrusel-detalles d-block w-100" src="data:image/png;base64,' . base64_encode($column['image_1']) . '" width="150px" height="350px class="card-img-top " style="margin:10px auto;"/>' ?>

                        </div>
                        <div class="carousel-item">
                            <?php echo '<img class="imgenes-carrusel-detalles d-block w-100" src="data:image/png;base64,' . base64_encode($column['image_2']) . '" width="150px" height="350px class="card-img-top " style="margin:10px auto;"/>' ?>
                        </div>
                        <div class="carousel-item">
                            <?php echo '<img class="imgenes-carrusel-detalles d-block w-100" src="data:image/png;base64,' . base64_encode($column['image_3']) . '" width="150px" height="350px class="card-img-top " style="margin:10px auto;"/>' ?>
                        </div>
                        <div class="carousel-item">
                            <?php echo '<img class="imgenes-carrusel-detalles d-block w-100" src="data:image/png;base64,' . base64_encode($column['image_4']) . '" width="150px" height="350px class="card-img-top " style="margin:10px auto;"/>' ?>
                        </div>
                        <div class="carousel-item">
                            <?php echo '<img class="imgenes-carrusel-detalles d-block w-100" src="data:image/png;base64,' . base64_encode($column['image_5']) . '" width="150px" height="350px class="card-img-top " style="margin:10px auto;"/>' ?>
                        </div>

                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

        </div>
        <div class="detalles-texto">
            <h4><?php echo htmlentities($column['name_product']) ?> </h4>
            <div class="descripcion-producto">
                <p><b>Descripcion: </b> <?php echo htmlentities($column['description']) ?></p>
            </div>
            <p><b>Precio: </b> $ <?php echo htmlentities($column['price']) ?>.00 MXN</p>
            <p><b>Stock: </b><?php echo htmlentities($column['stock']) ?></p>
            <p><b>Categoria:</b> <?php echo htmlentities($column['name_category']) ?></p>
            <?php if ($column['student_id']!= $_SESSION['student_id']){ 
            ?>
            <form method="post">
                <input name="amount" value="0" type="number" placeholder="0" min="1" class="input-quantity" />
                <button name="add" type="submit" class="button-añadir-carrito">Añadir al carrito</button>
            </form>
            <?php
        }
        ?>
        </div>

    </div>


    <div class="comentarios">
        <h2>Comentarios</h2>
        <?php if ($column['student_id']!= $_SESSION['student_id']){ 
            ?>
        <div class="comentario">
            <form method="post" action="">
                <textarea name="comment" placeholder="Agregar Comentario"></textarea>
                <button name="save_comm" type="submit">Publicar</button>
            </form>
        </div>
        <?php
        }
        ?>
        <?php
        $slct_rev = $cnnPDO->prepare('SELECT * FROM review WHERE id_product = :id_product ORDER BY date_review DESC');
        $slct_rev->bindParam(':id_product', $column['id_product']);
        $slct_rev->execute();
        $count = $slct_rev->rowCount();
        $col = $slct_rev->fetchAll();
        if ($count) {

            echo '<div class="comentarios-publicados">';
            foreach ($col as $data) {
                echo '<div class="comentario-del-usuario">';
                echo '    <div>';
                echo '        <img src="data:image/png;base64,'.base64_encode($data['pic_profile']).'" alt="">';
                echo '    </div>';
                echo '    <div>';
                echo '        <p>' . htmlentities($data['date_review']) . '</p>';
                echo '        <p><b>' . htmlentities($data['name_student']) . '</b></p>';
                echo '        <p><b>comentario: </b>' . htmlentities($data['comment']) . ' </p>';
                echo '    </div>';
                echo '</div>';
            }
            echo '</div>';
        } else echo 'Tu producto no tiene comentarios';

        ?>

    </div>

    </div>
</body>

</html>




</body>
<?php ob_end_flush();?>
</html>