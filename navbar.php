<?php
require 'cdn.html';
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <script src="https://kit.fontawesome.com/b1473ebfe8.js" crossorigin="anonymous"></script>
  <title>Document</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg color-bg" data-bs-theme="dark">
    <div class="container-fluid ">
      <a class="navbar-brand" href="main_window.php" style="color: rgb(255, 255, 255);">Halcon Store</a>
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
              <li><a class="dropdown-item" href="vender.php"><i class="fa-solid fa-calendar-check"></i> Vender </a></li>
              <li><a class="dropdown-item" href="main_window.php#footer"><i class="fa-solid fa-user"></i> Acerca de nosotros
                </a></li>
            </ul>
          </li>
          <label class="close perfil-modal" for="btn-modal-perfil" class="dropdown-item"><i class="fa-solid fa-user"></i> Perfil </label>


          <input type="checkbox" id="btn-modal-perfil">
          <div class="container-modal-perfil">
            <div class="content-modal-perfil">
              <div class="mi-perfil">
                <div class="img-perfil"><?php echo '<img src="data:image/png;base64,' . base64_encode($_SESSION['pic_profile']) . '" alt="">'; ?></div>
                <div class="container-menu">
                  <h5>Nombre: <?php echo $_SESSION['name']; ?> </h5>
                  <h5>Matricula: <?php echo $_SESSION['student_id']; ?> </h5>
                  <ul class="menu">
                    <li><a href="my_products.php"><i class="fa-solid fa-arrow-up"></i> Mis Publicaciones</a></li>
                    <li><a href="mis_pedidos.php"><i class="fa-solid fa-clock-rotate-left"></i> Historial De Compras</a></li>
                    <li>
                      <label class="close" for="btn-modal-editar" class="dropdown-item"><i class="fa-regular fa-pen-to-square"></i> Editar Perfil </label>

                      <?php
                      if (isset($_POST['edit'])) {


                        $name = $_POST['new_name'];
                        $password = $_POST['new_password'];
                        $pic_profile = null;

                        if (isset($_FILES['new_pic']) && $_FILES['new_pic']["error"] == UPLOAD_ERR_OK) {
                          $size = getimagesize($_FILES["new_pic"]["tmp_name"]);
                          if ($size !== false) {
                            $pic_profile = file_get_contents($_FILES['new_pic']["tmp_name"]);
                          }
                        }

                        $sql = $cnnPDO->prepare("UPDATE user SET name = ?, password =?,
                                pic_profile = COALESCE(NULLIF(?, ''), pic_profile) 
                                WHERE student_id = ?");
                        $sql->execute([$name, $password, $pic_profile, $_SESSION['student_id']]);
                        $alertMessage = '<div class="alert alert-success  alert-dismissible fade show" role="alert">
                                                <strong>Datos Actualizados!</strong> Tus datos fueron editados con exito.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                             </div>';


                        if ($pic_profile !== null) {
                          $_SESSION['pic_profile'] = $pic_profile;
                        }
                        $_SESSION['name'] = $name;
                        $_SESSION['password'] = $password;


                        header('location:main_window.php');
                      }
                      ?>

                      <input type="checkbox" id="btn-modal-editar">
                      <div class="container-modal-editar">
                        <div class="content-modal-editar">
                          <form enctype="multipart/form-data" method="post">
                            <div class="img-perfil-editar">
                              <h2>Editar Perfil</h2>
                              <div class="form-floating mb-2">
                                <input name="new_pic" type="file" class="custom-file-input-editar">

                              </div>
                            </div>
                            <div class="container-editar-form">
                              <div class="form-floating mb-4">
                                <input name="new_password" value="<?php echo $_SESSION['password'] ?>" class="input-editar" type="text">
                                <label class="label-editar">Password</label>
                              </div>
                              <div class="form-floating">
                                <input name="new_name" value="<?php echo $_SESSION['name'] ?>" class="input-editar" type="text">
                                <label class="label-editar">Nombre</label>
                              </div>
                            </div>
                            <br>
                            <div class="d-grid gap-3 col-7 mx-auto">
                              <button class="btn btn-light" type="submit" name="edit">Guardar</button>
                            </div>
                          </form>
                          <div class="btn-cerrar-editar">
                            <label for="btn-modal-editar">Cerrar</label>
                          </div>
                        </div>
                        <label for="btn-modal-editar" class="cerrar-modal-perfil"></label>
                    </li>
                    <li><a class="close" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesion</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <label for="btn-modal-perfil" class="cerrar-modal-perfil"></label>
          </div>
        </ul>

        <form class="d-flex position" role="search" action="buscar.php" method="GET">
          <input class="form-control me-2" type="search" name="query" placeholder="Buscar" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>

        <label class="close" for="btn-modal-notificaciones" class="dropdown-item"><i class="fa-sharp-duotone fa-solid fa-bell"></i> Notificaciones </label>
        <input type="checkbox" id="btn-modal-notificaciones">
        <div class="container-modal-notificaciones">
          <div class="content-modal-notificaciones">
            <div class="btn-cerrar">
              <label for="btn-modal-notificaciones"><i class="fa-sharp-duotone fa-solid fa-xmark"></i></label>
            </div>
            <h2><i class="fa-sharp-duotone fa-solid fa-bell"></i> Notificaciones</h2>
            <?php 
              $sel_not=$cnnPDO->prepare('SELECT * FROM notification WHERE id_vendedor =?');
              $sel_not->execute([$_SESSION['student_id']]);
              $row = $sel_not->fetchAll();
              $count =$sel_not->rowCount();
              if ($count){
                foreach($row as $noti){
            
                  echo '<div class="informacion-notificacion">
                  <p>'.htmlentities($noti['name_cus']).' compro '.htmlentities($noti['name_product']).'</p>
                  <p> '.htmlentities($noti['date']).'</p>
                  </div>';
                }
              }else{
              echo 'No tienes notificaciones';
              }
            ?>
              
          </div>
        </div>
      </div>


      <label class="close" for="btn-modal" class="dropdown-item"><i class="fa-solid fa-cart-shopping"></i> Carrito de compras </label>
      <input type="checkbox" id="btn-modal">
      <div class="container-modal">
        <div class="content-modal">
          <div class="btn-cerrar">
            <label for="btn-modal"><i class="fa-sharp-duotone fa-solid fa-xmark"></i></label>
          </div>
          <h2><i class="fa-sharp-duotone fa-solid fa-cart-shopping"></i> Carrito De Compras</h2>

          <div class="modal-products">
            <div class="add-products">
              <table>
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </thead>
                <?php
                if (isset($_POST['buy'])) {
                  try {
                    $cnnPDO->beginTransaction();

                    $select = $cnnPDO->prepare('SELECT date, id_product, amount, student_id, total, name_product FROM shopping_cart WHERE student_id= ?');
                    $select->execute([$_SESSION['student_id']]);
                    $count = $select->rowCount();
                    $fetch_select = $select->fetchAll();

                    if ($count) {
                      foreach ($fetch_select as $purch) {
                        $date_purchase = date('Y-m-d\TH:i:sP');
                        $up_product = $purch['id_product'];
                        $up_stock = $purch['amount'];
                        $ins_total = $purch['total'];

                        $select3 = $cnnPDO->prepare('SELECT student_id FROM product WHERE id_product = ?');
                        $select3->execute([$purch['id_product']]);
                        $id_vendedor = $select3->fetchColumn();

                        $update = $cnnPDO->prepare('UPDATE product SET stock = stock - ? WHERE id_product = ?');
                        $update->execute([$up_stock, $up_product]);

                        $insert = $cnnPDO->prepare('INSERT INTO purchase (total, date, student_id) VALUES (?,?,?)');
                        $insert->execute([$ins_total, $date_purchase, $_SESSION['student_id']]);

                        $ins_not = $cnnPDO->prepare('INSERT INTO notification (id_comprador, name_cus, name_product, id_vendedor, date, id_product) VALUES (?,?,?,?,?,?)');
                        $ins_not->execute([$_SESSION['student_id'], $_SESSION['name'] ,$purch['name_product'], $id_vendedor, $date_purchase, $up_product]);
                      }
                      $delete = $cnnPDO->prepare('DELETE FROM shopping_cart WHERE student_id = ?');
                      $delete->execute([$_SESSION['student_id']]);

                      $cnnPDO->commit();

                      $alertMessage = '<div class="alert alert-success  alert-dismissible fade show" role="alert">
                                                <strong>Compra Exitosa!</strong> Disfrute de sus productos.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                             </div>';
                    } else {
                      $alertMessage = '<div class="alert alert-danger  alert-dismissible fade show" role="alert">
                                                <strong>Carrito Vacio</strong> No hay productos en el carrito.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                             </div>';
                    }
                  } catch (Exception $error) {
                    $cnnPDO->rollBack();
                    $alertMessage = '<div class="alert alert-danger  alert-dismissible fade show" role="alert">
                                            <strong>Error en la compra:</strong> ' . $error->getMessage() . '
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                         </div>';
                  }
                }

                ?>
                <?php
                if (isset($_POST['delete'])) {
                  $p = $_POST['delete'];
                  $delete = $cnnPDO->prepare('DELETE FROM shopping_cart WHERE id_product =? AND student_id=?');
                  $delete->execute([$p, $_SESSION['student_id']]);
                  $alertMessage = '<div class="alert alert-danger  alert-dismissible fade show" role="alert">
                                                <strong>Producto Eliminado</strong> 
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                             </div>';
                }

                $sc = $cnnPDO->prepare('SELECT * FROM shopping_cart WHERE student_id =?');
                $sc->execute([$_SESSION['student_id']]);
                $count_car = $sc->rowCount();
                $col_car = $sc->fetchAll();



                if ($count_car) {


                  foreach ($col_car as $data) {

                    echo '<form method="POST">  
                      <tr>
                      <td>' . $data['name_product'] . '</td>
                      <td>' . $data['amount'] . '</td>
                      <td>' . $data['price'] . '</td>
                      <td>' . $data['total'] . '</td>
                      <td><button value="' . $data['id_product'] . '" name="delete" type="submit"><i class="fa-solid fa-trash"></i></button></td>
                      </tr>
                    </form>
                  ';
                  }
                }
                $sum = $cnnPDO->prepare('SELECT SUM(total) FROM shopping_cart WHERE student_id = ?');
                $sum->execute([$_SESSION['student_id']]);
                $pay = $sum->fetchColumn();
                ?>
                <tfoot>
                  <tr class="total-row">
                    <td colspan="4">Total General:</td>
                    <td><?php echo '$' . $pay . '.00 MXN';  ?></td>
                  </tr>
                </tfoot>

              </table>
            </div>
          </div>

          <form method="post">
            <button name="buy" class="boton-comprar">comprar</button>
          </form>

        </div>
        <label for="btn-modal" class="cerrar-modal"></label>
      </div>
    </div>
    </div>
  </nav>
  <?php echo isset($alertMessage) ? $alertMessage : '';
  unset($alertMessage) ?>



</body>
<?php ob_end_flush(); ?>

</html>