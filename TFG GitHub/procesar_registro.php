
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

    // Verifica si el usuario ya está registrado
    $sql = "SELECT * FROM users WHERE login = ?";
    $stmt = mysqli_prepare($conex, $sql);
    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $response = ["error" => "El nombre de usuario ya está registrado."];
        echo json_encode($response);
        exit();
    }

    //Hash de la contraseña (la cifra para la privacidad del usuario)
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (nombre, login, password, email) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conex, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $login, $passwordHash, $email);

    if (mysqli_stmt_execute($stmt)) {
        $response = ["success" => "Registro exitoso"];
        echo json_encode($response);
    } else {
        $response = ["error" => "Error al registrar el usuario."];
        echo json_encode($response);
    }

    mysqli_close($conex);
}
