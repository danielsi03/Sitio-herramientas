<?php
require 'cdn.html';
ob_start();



?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <script src="https://kit.fontawesome.com/b1473ebfe8.js" crossorigin="anonymous"></script>
  <title>Mecatools</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg color-bg" data-bs-theme="dark">
    <div class="container-fluid">
    <a class="navbar-brand" href="index.php" style="color: rgb(255, 255, 255);">
      <img  href="index.php" src="image/Imagen de WhatsApp 2025-03-12 a las 10.29.01_3bba10f1.jpg" alt="Logo" style="height: 40px; margin-right: 10px;">
      Mecatools
    </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" 
              style="background-color: rgba(100, 100, 100, 0.265);">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Herramientas de Corte</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#" onclick="buscarCategoria('Fresado')">Fresas</a></li>
              <li><a class="dropdown-item" href="#" onclick="buscarCategoria('Drill')">Brocas</a></li>
              <li><a class="dropdown-item" href="#" onclick="buscarCategoria('Insertos')">Insertos</a></li>
            </ul>
          </li>

         

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Consumibles</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#" onclick="buscarCategoria('AL CUT')">Lubricantes</a></li>
              <li><a class="dropdown-item" href="#" onclick="buscarCategoria('.')">Refrigerantes</a></li>
              <li><a class="dropdown-item" href="#" onclick="buscarCategoria('Disc')">Abrasivos</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Medición y Control</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#" onclick="buscarCategoria('Digimatic')">Micrómetros y Calibradores</a></li>
              <li><a class="dropdown-item" href="#" onclick="buscarCategoria('Caratula')">Relojes Comparadores</a></li>

            </ul>
          </li>

         
        </ul>

        <form class="d-flex" role="search" action="buscar.php" method="GET" id="searchForm">
          <input class="form-control me-2" type="search" name="query" id="searchBox" placeholder="Buscar" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>

  <script>
    function buscarCategoria(nombreCategoria) {
      document.getElementById("searchBox").value = nombreCategoria; 
      document.getElementById("searchForm").submit(); 
    }
  </script>

</body>
<?php ob_end_flush(); ?>
</html>