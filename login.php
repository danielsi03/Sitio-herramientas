<?php
session_start();
require 'db_conexion.php';
require 'cdn.html';

 if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $search = $cnnPDO->prepare('SELECT * FROM user WHERE email = ? AND password = ? ');
    $search -> execute([$email,$password]);
    $count = $search -> rowCount();
    $colum = $search ->fetch();
    
    if ($count) {
        $_SESSION['student_id'] = $colum['student_id'];
        $_SESSION['name'] = $colum['name'];
        $_SESSION['pic_profile']=$colum['pic_profile'];
        $_SESSION['password'] = $colum['password'];

        header('location:main_window.php');
    
            }else{
                echo  ' <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                            <strong>ATENCION!</strong> Correo o contraseña incorrectos.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';

            }
        }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/b1473ebfe8.js" crossorigin="anonymous"></script>
</head>
<body class="body-login">
    <div class="imagen-login">
    <div class="container-login">
        <div class="formulario">
            <form action="" method="post">
                <h1 class="titulo-login">Login</h1>
                <input name="email" class="input-nombre" type="email" required spellcheck="false">
                <label class="label-nombre">Email</label>
                <input name="password" class="input-password" type="password" required spellcheck="false">
                <label class="label-password">Password </label>
                <button name="login" class="boton-login">Login</button>
                <p class="reg">¿Aún no estás registrado? <a class="buttons" href="registrar.php">Registrarte</a></p>
            </form>
        </div>
    </div>
    </div>
</body>
</html>