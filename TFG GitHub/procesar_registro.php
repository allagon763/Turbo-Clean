<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turbo Clean - Lavadero de Coches</title>
    <link rel="stylesheet" href="index.css"> 
    <link rel="icon" href="logotipo.jpg" type="image/png">
</head>
<body>
<?php
session_start();
$conex = mysqli_connect("localhost", "root", "", "TFG");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'check_user') {
        $email = $_POST['email'];
        $login = $_POST['login'];

        $sql = "SELECT * FROM users WHERE email = ? OR login = ?";
        $stmt = mysqli_prepare($conex, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $login);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $response = ["exists" => mysqli_num_rows($resultado) > 0];
        echo json_encode($response);
        exit();
    }

    $nombre = $_POST['nombre'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // así verifica si la contraseña cumple con los requisitos
    if (!validatePassword($password)) {
        echo 'La contraseña no cumple con los requisitos.';
        exit();
    }

    // así verifica si el email cumple con los requisitos
    if (!validateEmail($email)) {
        echo 'El correo electrónico no es válido.';
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (nombre, login, password, email) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conex, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $login, $passwordHash, $email);

    if (mysqli_stmt_execute($stmt)) {
        echo 'Registro exitoso';
    } else {
        echo 'Error al registrar el usuario.';
    }

    mysqli_close($conex);
}

function validatePassword($password) {
    $minLength = 8;
    $hasUpperCase = preg_match('/[A-Z]/', $password);
    $hasLowerCase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/\d/', $password);
    $hasSpecialChar = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);

    return strlen($password) >= $minLength && $hasUpperCase && $hasLowerCase && $hasNumber && $hasSpecialChar;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
?>

</body>
</html>
