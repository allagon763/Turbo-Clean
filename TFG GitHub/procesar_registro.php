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

// Así verificamos si se reciben datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $login = $_POST["login"];
    // Con trim() se eliminan los espacios, en este caso del nombre de usuario y de la contraseña
    $login = trim($login);
    $password = trim($password);

    // Así conectamos con la base de datos
    $conex = mysqli_connect("localhost", "root", "", "TFG");

    // Con esto verificamos la conexión
    if (!$conex) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    // Verificamos si el usuario ya existe en la base de datos
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conex, $sql);
    if (mysqli_num_rows($result) > 0) {
        // El usuario ya existe, con esto inicia sesión con su ID
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        // Y así redirige al usuario a la página de reservas
        header("Location: reservas.html");
        exit();
    } else {
        // Hash de la contraseña (la cifra para la privacidad del usuario)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Inserta datos del nuevo usuario en la base de datos
        $sql = "INSERT INTO users (nombre, email, password, login) VALUES ('$nombre', '$email', '$hashed_password', '$login')";
        if (mysqli_query($conex, $sql)) {
            // Obtiene el ID del usuario recién registrado
            $user_id = mysqli_insert_id($conex);
            // Guarda el ID del usuario en la sesión
            $_SESSION['user_id'] = $user_id;
            // Redirige al usuario a la página de reservas
            header("Location: reservas.html");
            exit();
        } else {
            // Este es el error al registrar al usuario
            echo '<div id="mensaje-error">Error al registrar al usuario: ' . mysqli_error($conex) . '</div>';
        }
    }

    // Cierra la conexión
    mysqli_close($conex);
}
?>
</body>
</html>
