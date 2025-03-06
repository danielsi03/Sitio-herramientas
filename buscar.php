<?php
require 'db_conexion.php';
session_start();
require 'navbar.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="body-buscar">

<div class="container-cards-buscar">
<div class="container-cards">
<?php
$query = isset($_GET['query']) ? $_GET['query'] : '';
$searchTerm = "%" . $query . "%";
$search = $cnnPDO->prepare("SELECT * FROM product WHERE name_product LIKE :searchTerm");
$search->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$search->execute();
$count = $search->rowCount();
$result = $search->fetchAll(PDO::FETCH_ASSOC);


if ($count) {
    
    
    foreach ($result as $row) {

        echo  '     <a class="card-product" href="window_product.php?slug=' . htmlentities($row["slug_product"]) . '" >';
        echo '          <img src="data:image/png;base64,' . base64_encode($row['image_1']) . '"   none; alt="Imagen del producto" object-fit: cover;">';
        echo '          <div class="card-body-product">';
        echo '              <h5 class="card-name">Nombre: ' . htmlentities($row["name_product"]) . '</h5>';
        echo '              <p class="card-text">Precio: $ ' . htmlentities($row["price"]) . '.00 MXN</p>';
        echo '              <p class="card-text">Stock: ' . htmlentities($row["stock"]) . '</p>';
        echo '          </div>';
        

    }


} else {
    echo "No se encontraron productos.";
}

?>

</div>
</div>

</body>
</html>
