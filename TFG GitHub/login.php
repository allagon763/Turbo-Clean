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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $login = $_POST["login"];
    $password = $_POST["password"];
    // Con trim() se eliminan los espacios, en este caso del nombre de usuario y de la contraseña
    $login = trim($login);
    $password = trim($password);

    // Así conecta a la base de datos
    $conex = mysqli_connect("localhost", "root", "", "TFG");

    // Verifica la conexión
    if (!$conex) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    // Consulta si el usuario existe en la base de datos
    $query = "SELECT user_id, login, password FROM users WHERE login = '$login'";
    $result = mysqli_query($conex, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row["password"];

        // Verifica si la contraseña ingresada coincide con el hash almacenado en la base de datos
        if (hash_equals($hashed_password, crypt($password, $hashed_password))) {
            // Si la contraseña es correcta, inicia sesión y redirige al usuario a la página de reserva
            $_SESSION["user_id"] = $row["user_id"];
            header("Location: reservas.html");
            exit();
        } else {
            // Si no es correcta, pone que la contraseña es incorrecta
            echo '<div id="mensaje-error">Contraseña incorrecta.</div>';
        }
    } else {
        // Si falla el usuario, pone usuario no encontrado
        echo '<div id="mensaje-error">Usuario no encontrado.</div>';
    }

    // Así cierra la conexión
    mysqli_close($conex);
}
?>
</body>
</html>

