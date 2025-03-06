<?php
require 'db_conexion.php';

$apiKey = '39c8a26f01db324b4c865460a55feb0039dbbf99';

function verificarCorreo($email, $dominioPermitido, $apiKey) {
    $emailDomain = substr(strrchr($email, "@"), 1);

    if ($emailDomain !== $dominioPermitido) {
        return "Necesitas registrarte con tu correo institucional.";
    }

    $url = "https://api.hunter.io/v2/email-verifier?email=" . urlencode($email) . "&api_key=" . $apiKey;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return 'Error en la solicitud: ' . curl_error($ch);
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['data']['status']) && $data['data']['status'] == 'valid') {
        return "El correo electrónico pertenece al dominio permitido y es válido.";
    } else {
        return "El correo electrónico no es válido o no existe.";
    }
}

$resultado = "";
$alertClass = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $career = $_POST['career'];
    $building = $_POST['building'];
    $password = $_POST['password'];
    $url_img = 'image/pic profile.jpg';
    $pic_profile = file_get_contents($url_img);

    if (!empty($student_id) && !empty($name) && !empty($email) && !empty($phone) && !empty($career) && !empty($building) && !empty($password)) {
        if ($career !== "Selecciona tu carrera..." && $building !== "Selecciona tu edificio...") {
            $dominioPermitido = 'alumno.utc.edu.mx';

            $resultado = verificarCorreo($email, $dominioPermitido, $apiKey);

            if ($resultado === "El correo electrónico pertenece al dominio permitido y es válido.") {
                try {
                    
                    $insert = $cnnPDO->prepare("INSERT INTO user (student_id, name, email, phone, career, building, password, pic_profile) VALUES (:student_id, :name, :email, :phone, :career, :building, :password, :pic_profile)");

                    $insert->bindParam(':student_id', $student_id);
                    $insert->bindParam(':name', $name);
                    $insert->bindParam(':email', $email);
                    $insert->bindParam(':phone', $phone);
                    $insert->bindParam(':career', $career);
                    $insert->bindParam(':building', $building);
                    $insert->bindParam(':password', $password);
                    $insert->bindParam(':pic_profile', $pic_profile,PDO::PARAM_LOB);

                    $insert->execute();

                    header("Location: login.php");
                    exit();
                } catch (PDOException $e) {
                    $resultado = 'Error al insertar en la base de datos: ' . $e->getMessage();
                    $alertClass = 'alert-danger';
                }
            } else {
                $alertClass = 'alert-danger';
            }
        } else {
            $resultado = "Por favor, selecciona una carrera y un edificio válidos.";
            $alertClass = 'alert-warning';
        }
    } else {
        $resultado = "Por favor, complete todos los campos.";
        $alertClass = 'alert-warning';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="body-registrar">
<div class="imagen-login">
    <div class="container-registrar">
        <div class="img-registrar"></div>
        <div class="formulario-registrar start">
            <form action="" method="post">
                <h1 class="titulo-registrar">Registrar</h1>
                <input name="student_id" class="input-matricula-registrar" type="text" required spellcheck="false">
                <label class="label-matricula-registrar">Matricula</label>

                <input name="name" class="input-nombre-registrar" type="text" required spellcheck="false">
                <label class="label-nombre-registrar">Nombre</label>
    
                <input name="email" class="input-email-registrar" type="email" required spellcheck="false">
                <label class="label-email-registrar">Email</label>

                <input name="phone" class="input-numero-registrar" type="text" required spellcheck="false">
                <label class="label-numero-registrar">Numero</label>

                <select name="career" class="input-carrera-registrar" required>
                    <option selected>Selecciona tu carrera...</option>
                    <option value="Innovación de Negocios y Mercadotecnia">Innovación de Negocios y Mercadotecnia</option>
                    <option value="Diseño y Gestión de Redes Logísticas">Diseño y Gestión de Redes Logísticas</option>
                    <option value="Biotecnología">Biotecnología</option>
                    <option value="Confiabilidad de Planta">Confiabilidad de Planta</option>
                    <option value="Desarrollo y Gestión de Software">Desarrollo y Gestión de Software</option>
                    <option value="Entornos Virtuales y Negocios Digitales">Entornos Virtuales y Negocios Digitales</option>
                    <option value="Energías Renovables">Energías Renovables</option>
                    <option value="Mecatrónica">Mecatrónica</option>
                    <option value="Metal Mecánica">Metal Mecánica</option>
                    <option value="Nanotecnología">Nanotecnología</option>
                    <option value="Procesos y Operaciones Industriales">Procesos y Operaciones Industriales</option>
                    <option value="Redes Inteligentes y Ciberseguridad">Redes Inteligentes y Ciberseguridad</option>
                    <option value="Seguridad Ambiental Sustentable">Seguridad Ambiental Sustentable</option>
                    <option value="Maestría en Ingeniería para la Manufactura Inteligente">Maestría en Ingeniería para la Manufactura Inteligente</option>
                </select>

                <label class="label-carrera-registrar">Carrera</label>

                <select name="building" class="input-edificio-registrar" required>
                    <option selected>Selecciona tu edificio...</option>
                    <option value="1">Edificio 1</option>
                    <option value="2">Edificio 2</option>
                    <option value="3">Edificio 3</option>
                    <option value="4">Edificio 4</option>
                </select>

                <label class="label-edificio-registrar">Edificio</label>

                <input name="password" class="input-password-registrar" type="password" required spellcheck="false">
                <label class="label-password-registrar">Password</label>

                <button name="signup" class="boton-registrar" type="submit">Register</button>
                <?php if ($resultado): ?>
                <div class="alerta <?= $alertClass ?>" role="alert">
                    <?= $resultado ?>
                </div>
                <?php endif; ?>
                <p class="rega">¿Ya tienes cuenta? <a href="login.php" class="buttons">Login</a></p>
            </form>  
        </div>
        </div>
    </div>
</body>
</html>
