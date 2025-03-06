<?php
require 'db_conexion.php';
session_start();
require 'navbar.php';
$select=$cnnPDO->prepare('SELECT * FROM purchase WHERE student_id=? ORDER BY date DESC');
$select->execute([$_SESSION['student_id']]);
$count =$select->rowCount();
$col=$select->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="body-mis-pedidos">
    <div class="container-mis-pedidos">
        <h2>Mis Pedidos</h2>
        <div class="pedido">
            <?php
            if($count){ 
                foreach($col as $data){
                echo  '<div class="pedido-contenido">
                    <div class="img-pedidos">
                        <img src="image/6384868.png" alt="Producto">
                    </div>
                    <div class="pedido-header">
                        <h3>Pedido #'.htmlentities($data['id_purchase']).' </h3>
                        <p>Fecha: '.htmlentities($data['date']).'</p>
                        <p>Estado: Enviado</p>
                    </div>
                    <div class="detalle-pedido">
                        <h4>Detalles del Producto</h4>
                        <p>Total de la compra: $ '.htmlentities($data['total']).'.00</p>
                    </div>
                </div>';
                }
        }else{
            echo'<h3>Aun no has realizado ninguna compra</h3>';
        }
        ?>
        </div>
        
    </div>
</body>
</html>
