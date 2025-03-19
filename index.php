<?php

require 'db_conexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>index</title>
  <script src="https://kit.fontawesome.com/b1473ebfe8.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="styless.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body class="body-main_window">
<nav class="navbar navbar-expand-lg color-bg" data-bs-theme="dark">
    <div class="container-fluid">
    <a class="navbar-brand" href="index.php" style="color: rgb(255, 255, 255);">
    
      <img  href="index.php" src="image/Imagen de WhatsApp 2025-03-12 a las 10.29.01_3bba10f1.jpg" alt="Logo" style="height: 40px; margin-right: 10px;">
      Mecatools
    </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="background-color: rgba(100, 100, 100, 0.265);">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-bars"></i> Menu
            </a>
            <ul class="dropdown-menu custom-anchor" style="background-color: black;">
              <li><a class="dropdown-item" href="#footer"><i class="fa-solid fa-user"></i> Acerca de nosotros
                </a></li>
            </ul>
          </li>
        
        </ul>

        <form class="d-flex position" role="search" action="buscar.php" method="GET">
          <input class="form-control me-2" type="search" name="query" placeholder="Buscar" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
    </div>
    </div>
  </nav>
  
  <div class="imagen-principal">
    <?php echo isset($alertMessage) ? $alertMessage : ''; ?>
    <div class="imagen-principal-text">></div>
  </div>

  <?php
  $select_cat = $cnnPDO->prepare('SELECT * FROM category');
  $select_cat->execute();
  $column_cat = $select_cat->fetchAll(PDO::FETCH_ASSOC);

  $items_per_slide = 3;
  $total_items = count($column_cat);
  $slides = ceil($total_items / $items_per_slide);
  ?>

  <div class="title-categorias">
    <h1>Categorias</h1>
  </div>
  <div class="categoriass">
    <div id="carouselExample" class="carousel slide">
      <div class="carousel-inner" style="margin:auto;">
        <?php
        for ($i = 0; $i < $slides; $i++) {
          $start = $i * $items_per_slide;
          $end = min($start + $items_per_slide, $total_items);
          $active_class = ($i === 0) ? 'active' : '';
          echo '<div class="carousel-item ' . $active_class . '">';
          echo '<div class="imagenes-de-carrusel row">';

          for ($j = $start; $j < $end; $j++) {
            $img_car = $column_cat[$j];
            echo '<div class="col-3 mx-2 audifonos">';
            echo '  <a href="categories.php?slug=' . htmlentities($img_car['slug_category']) . '">';
            echo '    <img src="data:image/png;base64,' . base64_encode($img_car['image_category']) . '" alt="">';
            echo '  </a>';
            echo '</div>';
          }

          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <div class="title-productos">
    <h1>Productos</h1>
  </div>

  <div class="container-cards">
    <?php
    $select = $cnnPDO->prepare('SELECT * FROM product');
    $select->execute();
    $column = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($column as $data) {
      echo '  <a class="card-product" href="window_product.php?slug=' . htmlentities($data['slug_product']) . ' " >';
      echo '    <img src="data:image_png;base64,' . base64_encode($data['image_1']) . '"  alt="...">';
      echo '    <div class="card-body-product">';
      echo '      <h5 class="card-name">' . htmlentities($data['name_product']) . '</h5>';
      echo '      <h5 class="card-name">Categoria: ' . htmlentities($data['name_category']) . '</h5>';
      echo '    </div>';
      echo '  </a>';
    }
    ?>
  </div>

  <footer id="footer">
    <h1>Información sobre la página</h1>
    <br>
    <div class="footer-content">
      <div class="footer-links">
        <h4>Información Legal</h4>
        <ul>
          <li><a href="/privacy-policy">Política de Privacidad</a></li>
          <li><a href="/terms-of-service">Términos de Servicio</a></li>
          <li><a href="/faq">Preguntas Frecuentes</a></li>
        </ul>
      </div>
      <div class="footer-social">
        <h4>Siguenos!</h4>
        <a href="https://www.facebook.com/UniversidadTecnologicadeCoahuila" target="_blank"><i class="fa-brands fa-facebook"></i> Facebook</a>
        <a href="https://www.tiktok.com/@utdecoahuila" target="_blank"> <i class="fa-brands fa-tiktok"></i> tiktok</a>
        <a href="https://www.instagram.com/utcoahuila" target="_blank"> <i class="fa-brands fa-instagram"></i>
          Instagram</a>
      </div>
    </div>
  </footer>
</body>
</html>
